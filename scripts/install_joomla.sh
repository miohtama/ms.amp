#!/bin/sh
#
# Set-up Joomla from predefined database copy
#

if [ -e htdocs/joomla/installation ] ; then

    echo "Setting up MySQL user"
    # Install the admin user
    parts/mysql/bin/mysqladmin --socket=var/mysql.sock -u root password 'admin'

    echo "Exctractin dev db"
    # Extract sample database to templates folder
    tar -xjf templates/developmentdatabase.tar.bz2 -C templates

    echo "Importing dev db"
    # Import database
    parts/mysql/bin/mysql --socket=var/mysql.sock -uroot -padmin -e "source templates/developmentdatabase.sql"

    echo "Marking Joomla installation done"
    # Mark installation succesfully complete
    mv htdocs/joomla/installation htdocs/joomla/_installation
else
    echo "Joomla set-up exists"
fi

exit 0

