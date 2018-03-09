#!/usr/bin/perl
#


use strict;
use warnings;
use Net::DNS;
use JSON;

my $host='';
my $res;
my $output;

$host = $ARGV[0];

$res = Net::DNS::Resolver->new();
my $reply = $res->search($host);

if ($reply) {
        foreach my $rr ($reply->answer) {

        next unless $rr->type eq "A" || $rr->type eq "PTR";

                if ($rr->type eq "A") {
                my $ipaddr = $rr->address;
                $output = $host;
                $output .= " -> IP: $ipaddr";
                } elsif ($rr->type eq "PTR") {
                my $name = $rr->ptrdname;
                $output = $host;
                $output .= " -> Name: $name";

                }

        }
} else {
        $output = $host;
        $output .= " -> QUERY FAILED!";
}

print $output;
