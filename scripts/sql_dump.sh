#!/bin/sh
#
# Create the database drop from the current development database
# 

MYSQLBASE=parts/mysql

$MYSQLBASE/bin/mysqldump --socket=var/mysql.sock joomla -uroot -padmin > setupfiles/developmentdatabase.sql
tar -cjf setupfiles/developmentdatabase.tar.bz2 setupfiles/developmentdatabase.sql
rm setupfiles/developmentdatabase.sql