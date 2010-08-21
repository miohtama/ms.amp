#!/bin/sh
#
# Create the database drop from the current development database
# 

parts/mysql/bin/mysqldump -a -A --add-drop-database --socket=var/mysql.sock -uroot -padmin > templates/developmentdatabase.sql
cd templates ; tar -cjf developmentdatabase.tar.bz2 developmentdatabase.sql ; cd ..
rm templates/developmentdatabase.sql