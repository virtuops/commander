#!/usr/bin/perl
#
# Sends secure email using SMTPS.  Must have Net::SMTPS loaded and accessible to the web server user
# Form requires recipient,subject,body and message fields.  The message field will catch errors
# Also make sure you have the port to your SMTP server open and you have a user with credentials for that server.
# 
#

use strict;
use warnings;
use JSON;
use Net::SMTPS;

my ($productname, $productcategory, $purchaseamount, $purchasedate, $recipient, $subject, $body);

# You can adjust the vars below to email anyone anything
$productname = $ARGV[0];
$productcategory = $ARGV[1];
$purchaseamount = $ARGV[2];
$purchasedate = $ARGV[3];

# 
# Mail input params
#
$recipient = 'chris@virtuops.com';
$subject = 'Purchase Information';
$body = <<__MAILBODY__;
This was emailed from VirtuOps Commander:

PRODUCT NAME: $productname

PRODUCT CATEGORY: $productcategory

PURCHASE AMOUNT: $purchaseamount

PURCHASE DATE: $purchasedate

Sincerely,

VirtuOps

__MAILBODY__

my %output;

#my $smtpserver = 'smtp.gmail.com';
#my $smtpport = 587;
#my $smtpuser   = '<User with credentials to the server>';
#my $smtppassword = '<Password for user with credentials>';

my $smtpserver='';
my $smtpport;
my $smtpuser = '';
my $smtppassword = '';

if (length($smtpserver) == 0)
{
  $output{'device'} = "Not Configured";
  $output{'message'} = "DNS tool not configured, go to /var/www/html/commander/tmp/tools and configure";
  my $json = encode_json(\%output);
  print $json;
  exit;
} 

my $smtp = Net::SMTPS->new($smtpserver, Port=>$smtpport, doSSL => 'starttls', Timeout => 10, Debug => 0);

die "Could not connect to server!\n" unless $smtp;

$smtp->auth($smtpuser, $smtppassword);
$smtp->mail('support@virtuops.com');
$smtp->to($recipient);
$smtp->data();
$smtp->datasend("Subject: $subject");
$smtp->datasend("\n");
$smtp->datasend("$body");
$smtp->datasend("\n");
$smtp->dataend();
my @msgs = $smtp->message();
$smtp->quit;


foreach my $msg (@msgs) {
        if ($msg =~ /OK/) {
                $output{'status'} = "OK";
                $output{'message'} = "Message Sent for $productname";
        } else {
		$output{'status'} = "FAILURE:  Message Not Sent";
               	$output{'message'} = "Please check your SMTP server settings, user credentials and firewalls between VirtuOps and your SMTP server.";
	}
}

my $json = encode_json(\%output);
print $json;
exit;
