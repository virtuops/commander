#!/usr/bin/perl
#
# NOTE:  If you installed Net::SNMP as root, you need to make sure that the Apache (or web server) user can see Net/SNMP.pm
# Run perl -V from the command line and look at @INC, then make sure Net/SNMP is in the path of one of the
# @INC directories
#
#

use strict;
use warnings;
use JSON;
use Net::SNMP;
use Data::Dumper;

my $host=$ARGV[0];
my $community=$ARGV[1];
my $oid=$ARGV[2];
my %output;


my ($session, $error) = Net::SNMP->session(
   -hostname  => shift || $host,
   -community => shift || $community,
);

if (!defined $session) {
$output{'host'} = $host;
$output{'status'} = 'No Session';
my $json = encode_json(\%output);

} else {

my $result = $session->get_request(-varbindlist => [ $oid ],);

if (!defined $result) {
$output{'host'} = $host;
$output{'status'} = 'No Result';
my $json = encode_json(\%output);
$session->close();

} else {

print Dumper ($result);
$output{'oid'} = $oid;
$output{'value'} = $result->{$oid} ? $result->{$oid} : 'No OID Value Found';

}

}
$session->close();

my $json = encode_json(\%output);
print $json;
