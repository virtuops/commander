#!/bin/perl
use strict;
use warnings;
use JSON;
use DBI;
use DBD::Pg;
use Data::Dumper;

my %output;

my ($table,$number,$alarmid,$shortdesc,$nodelabel,$dbuser,$dbpass,$dbname,$curlpath,$user,$domain,$password,$data,$ticketoutput,$cmdoutput,$status);

$table = 'incident';
$curlpath = '/usr/bin/curl';
$user = 'usermon';
$dbuser = 'opennms';
$dbname = 'opennms';
$domain = 'gogodev.service-now.com';
$password = 'N3tc00l';
$dbpass = 'opennms';
$nodelabel = $ARGV[0];
$shortdesc = $ARGV[1];
$alarmid = $ARGV[2];

$shortdesc = $nodelabel." ".$shortdesc;
$shortdesc =~ s/\n//g;

$cmdoutput = '/var/www/html/nochero_commander/tmp/tools/createinc_out.txt';

open (FILEDATA,"+> $cmdoutput");

print FILEDATA "INCOMING VARS: $nodelabel, $shortdesc, $alarmid\n";

$data = '{"short_description":"'.$shortdesc.'"}';

my $createcmd = $curlpath." -s -X POST -H 'Content-Type: application/json' -d '".$data."' -u '".$user.":".$password."' https://".$domain."/api/now/table/".$table." 2>&1";


my $createrequest = `$createcmd`;

print FILEDATA $createrequest;

$ticketoutput = decode_json($createrequest);

$number = $ticketoutput->{'result'}->{'number'};

my $dbh = DBI->connect("dbi:Pg:dbname=$dbname", "$dbuser", "$dbpass", {AutoCommit => 1});

my $sth = $dbh->prepare('UPDATE alarms set tticketid = ? where alarmid = ?');
$sth->execute($number,$alarmid);

$dbh->disconnect();

if (length($number) > 0) {
print $number." created\n";
} else {
print "Something went wrong, no number created.\n";
}
