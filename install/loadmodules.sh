#!/bin/sh

curl -L https://cpanmin.us | perl - --sudo App::cpanminus

yum install -y epel-release perl-Crypt-SSLeay perl-Net-SSLeay perl-Net-SMTPS perl-IO-Socket-SSL perl-Net-OpenSSH perl-Net-SSH-Expect perl-Net-SSH-Perl perl-Net-SSH2 perl-Net-SFTP-Foreign perl-Net-SSH perl-Net-FTPSSL perl-Net-FTP-RetrHandle perl-Net-FTP-AutoReconnect perl-Net-CIDR perl-Net-IRC perl-Net-Jabber perl-Net-POP3S perl-Net-Pcap-Easy perl-Net-Telnet perl-Net-Twitter-Lite perl-Net-Amazon-EC2 perl-Net-Amazon-EC2-Metadata perl-Net-CUPS perl-Net-DBus perl-Net-IMAP-Simple perl-Net-OAuth perl-Net-Pcap perl-Net-Telnet-Cisco perl-POE perl-SNMP-Info perl-DBI perl-DBD-AnyData perl-DBD-CSV perl-DBD-MySQL perl-DBD-ODBC perl-DBD-Pg perl-DBD-SQLite rrdtool-perl perl-Log-Any perl-Log-Any-Adapter perl-Log-Log4perl perl-Log-LogLite perl-Log-Message-Simple perl-Unix-Syslog perl-Log-Dispatch perl-Nagios-Plugin-WWW-Mechanize perl-WWW-Splunk perl-Test-WWW-Mechanize perl-WWW-Salesforce perl-Nagios-Plugin-WWW-Mechanize perl-Test-WWW-Selenium perl-WWW-Curl perl-WWW-GoodData perl-WWW-Mechanize perl-WWW-Mechanize-GZip perl-WWW-Twilio-API perl-WWW-Twilio-TwiML perl-libwww-perl perl-SOAP-Lite perl-SOAP-WSDL-Apache perl-Mail-Sender perl-REST-Client perl-CGI perl-CGI-Application perl-CGI-FormBuilder perl-HTML-Encoding perl-HTML-Entities-Numbered perl-HTML-Format perl-HTML-FormatText-WithLinks perl-HTML-Parser perl-HTML-PrettyPrinter perl-HTML-Scrubber perl-HTML-Table perl-HTML-TableExtract perl-MIME-Lite-HTML perl-Monitoring-Plugin

cpanm WWW::Facebook::API

