#!/usr/bin/perl
# Ping a single device, bring back alive
# Uses TCP Ping by default
#

use strict;
use warnings;
use Net::Ping;
use JSON;

my $host=$ARGV[0];
my %output;

my $p = Net::Ping->new();
if ($p->ping($host)) {
$output{'host'} = $host;
$output{'status'} = 'alive';
} else {
$output{'host'} = $host;
$output{'status'} = 'unreachable';
}
$p->close();

my $result = encode_json(\%output);

print $result;
