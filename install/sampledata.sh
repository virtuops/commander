#!/bin/sh

MYSQL_PATH=$1
MYSQL_USER=$2
MYSQL_PASSWORD=$3
MYSQL_HOST=$4
MYSQL_PORT=$5
SAMPLE_DB=$6

PURCHVALS=(59.99 49.99 39.99 29.99 109.99 89.99 69.99 49.99 509.99 389.99 289.99 209.99)

echo -e 'drop database if exists '$SAMPLE_DB';' | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT

echo -e 'create database if not exists '$SAMPLE_DB';' | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT

echo -e '

echo -e "grant all on "$SAMPLE_DB".* to 'sampleuser'@'localhost' identified by 'sampleuser123';" | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT

echo -e 'create table '$SAMPLE_DB'.sample_customers(`custid` int(11) primary key not null auto_increment, `custname` varchar(24), `custstreet` varchar(64), `custcity` varchar(64), `custstate` varchar(64), `postalcode` int(11), `custcountry` varchar(64));' | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT -A $SAMPLE_DB

echo -e 'create table '$SAMPLE_DB'.sample_products(`productid` int(11) primary key not null auto_increment, `productname` varchar(255), `productprice` decimal(11,2), `productcategory` varchar(24));' | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT -A $SAMPLE_DB

echo -e 'create table '$SAMPLE_DB'.sample_purchases(`purchaseid` int(11) primary key not null auto_increment, `productid` int(11), `purchaseamount` decimal(11,2), `purchasedate` datetime, `purchasetype` varchar(24), `purchaselocation` varchar(24));' | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT -A $SAMPLE_DB

echo -e 'create table '$SAMPLE_DB'.maintenance_window(`device` varchar(48),`starttime` datetime, `endtime` datetime);' | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT -A $SAMPLE_DB

echo -e "insert into "$SAMPLE_DB".sample_customers values (0,'VirtuOps','123 WindyCity Lane','Chicago','IL',60657,'USA'),(0,'ACME','204 Coyote Place','Mesa','AZ',85200,'USA'),(0,'SuperCorp','234 Hero Ave','Springfield','IL',62629,'USA');" | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT -A $SAMPLE_DB

echo -e "insert into "$SAMPLE_DB".sample_products values (0,'WidgetMaster 2000',59.99,'Widgets'),(0,'WidgetPremier 1000',49.99,'Widgets'),(0,'WidgetSpecial 500',39.99,'Widgets'),(0,'WidgetStandard 100',29.99,'Widgets'),(0,'GadgetUltimate',109.99,'Gadgets'),(0,'GadgetPlatinum',89.99,'Gadgets'),(0,'GadgetGold',69.99,'Gadgets'),(0,'GadgetStarter',49.99,'Gadgets'),(0,'ThingyUltra',509.99,'Thingys'),(0,'ThingySupra',389.99,'Thingys'),(0,'ThingyAdvanced',289.99,'Thingys'),(0,'ThingyBasic',209.99,'Thingys');" | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT -A $SAMPLE_DB

for i in {1..500}; do
	OFFSET=`echo $((( $RANDOM % 10 ) + 2))`
        HIST=$(($OFFSET + $i))
        PURCHARR=$(($OFFSET - 1))
        PURCHPRICE=${PURCHVALS[$PURCHARR]}

	if (( $OFFSET < 6 )); then
		PURCHTYPE='credit card'
		PURCHLOCATION='online'
	else
		PURCHTYPE='cash'
		PURCHLOCATION='store'
	fi

        DATE=`date +'%F %T' -d $HIST' min ago'`
        echo -e "insert into "$SAMPLE_DB".sample_purchases values (0,$OFFSET,$PURCHPRICE,'$DATE','$PURCHTYPE','$PURCHLOCATION');" | $MYSQL_PATH -u$MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_HOST -P $MYSQL_PORT -A $SAMPLE_DB
done
