#!/bin/sh


PURCHVALS=(59.99 49.99 39.99 29.99 109.99 89.99 69.99 49.99 509.99 389.99 289.99 209.99)

for i in {1..500}; do
        OFFSET=`echo $((( $RANDOM % 10 ) + 2))`
        HIST=$(($OFFSET + $i))
        PURCHARR=$(($OFFSET - 1))
        PURCHPRICE=${PURCHVALS[$PURCHARR]}
        DATE=`date +'%F %T' -d $HIST' min ago'`
        echo -e "insert into "$SAMPLE_DB".sample_purchases values (0,$OFFSET,$PURCHPRICE,'$DATE');" 
done
