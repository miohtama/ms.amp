.. contents ::

Introduction
============

mobilejoomla.buildout is automated method to install full 
Joomla! and Mobilejoomla! AMP stack as a local user. mobilejoomla.buildout is based on `buildout <http://www.buildout.org>`_
configuration automator.

Setting up a local AMP stack for Joomla! development on your workstation by hand may easily take one workday.
This automated script is designed to cut that time to ten minutes of effective work time.  

mobilejoomla.buildout target audience is developers who wish to contribute to Mobilejoomla! development
or site integrators who wish to test Mobilejoomla! easily.

* It will pull the bleeding edge Mobilejoomla! GIT version for development

* It will automatically install Joomla! with Mobilejoomla! extension and Terawurfl device database (with the supplied database)

* It will installed Apache+MySQL+PHP stack   

* Applications and libraries are compiled from the scratch so they have known good set (KGS) and you do not need to struggle with distribution specific problems. 
  This includes support for gd, mysqli, zlib and mcrypt PHP modules and Terawurfl handset database. 

* It does not touch any system files which guarantees your computer won't get hosed (everything is done as normal user)

* The installation experience is similar on all Linux distributions and OSX - we do not need to provide minimal distribution specific documentation

* You can set-up Mobilejoomla! development environemtn on new computer in the matter of minutes of effective work time

* Optionally, you can also install Wordpress, SugarCRM and other PHP applications using the same buildout 

* The buildout also makes it very clear you stand on the shoulders of a giant: the amount of free software
  which is pulled in to run your applications is very visible

.. note ::

    In theory, you can run AMP stack on shared hosting using this automated configuration. 
    However, creating full AMP stack takes a lot of server resources and might
    not be approved by the hosting company.

.. note ::

	This buildout is not safe for production usage as it contains default passwords.
	
The work is licensed under GPL 2 license.

Support operating systems
-------------------------

mobilejoomla.buildout supports **Linux** and **OSX** operating systems.

We do not support Windows installation due to difficulties of setting up free software stack.
Advanced Windows users may use instructions here using `MingW <http://www.mingw.org/>`_ or Cygwin
development environments. If you wish to contribute Windows installation instructions,
we wish you write them and leave pull request for the patch on Github.

Prerequisitements
------------------

You need to

* Know UNIX command line basics

* Have user access to some UNIX system (Linux, OSX), preferably on your local computer

Note about download URLs
------------------------

All download URLs are hardcoded in buildout.cfg file. They were retrieved when the file was last edited.
If downloads fail try update these URLs to newer versions. 

Installation
============

Prerequisitments
----------------

You need to have Python 2.6, GCC compiler and Git installed on your system.
Also you need to have tar, gzip and bzip2 commands available.

OSX
+++

* Install `XCode <http://developer.apple.com/mac/>`_ 

* Install `Macports <http://www.macports.org/>`_ 

* After Macports you can install required command-line software to run buildout

::
   
   sudo port install python2.6
   sudo port install git-core +svn bzip2 tar gzip

Linux
+++++

These instructions apply for Debian/Ubuntu. You might need to adapt them for your distribution.

Install 

Terminal commands
-----------------

This will checkout the latest mobilejoomla.buildout from Github and run it for you.

::
    
    git clone git://github.com/miohtama/mobilejoomla.buildout.git
    cd mobilejoomla.buildout
    python bootstrap.py
    bin/buildout

.. note ::

	Running buildout command may take up to one hour time as it will download
	LAMP stack source code and compile it for you.

Then you need create a MySQL database and to set MySQL master password (root/admin)

::

	bin/mysql_install_db
        bin/supervisord # This will start Apache + MySQL running on background
    	bin/mysqladmin -u root -padmin password 'admin'

The set-up is following:

* Apache port 17881

* Apache logs: ``var/log``

* Apache web server root: ``htdocs``

* MySQL port 3306 (MySQL default, see notes below if you need to run several MySQL instances on the same computer)

* MySQL host: localhost

* MySQL user: root / admin

* MySQL database name: joomla

* MySQL database files: var/mysql/mysql

* MySQL logs: ``var/log``

* Joomla admin login http://localhost:17881/joomla/administrator/

* Joomla: admin user is admin/admin.

* Mobilejoomla: not installe, you need to perform manual installation after 

* phpMyAdmin: http://localhost:17881/phpmyadmin

	 
Usage
=====

A utility daemon called `supervisord <http://supervisord.org/>`_ is used to manage Apache and MySQL launching.

You can start MySQL and Apache with the following command

::
    
    bin/supervisord -n
	
This will start supervisor process on foreground (non-daemonized mode). When supervisor is terminated,
it will terminate all process started by itself.	
Both MySQL and Apache will be taken down when you press Control-C in the terminal.

.. note ::

    ``parts/`` and ``htdocs/`` folders  

Database setup
==============

If you start MySQL through ``supervisord``, as described above,
Joomla! site with Mobilejoomla! will be automatically installed for you.

However if you need to run manual install, you can execute the following script
::
    scripts/setup_database.sh
    
Joomla web site browsing
------------------------

By default, Apache is configured in port 17881 an you can enter to Joomla! installation screen:

	http://localhost:17881
	
Mobile phone browsing
---------------------
	
If you want to test Mobilejoomla! with mobile phone you need a local WLAN network.

Use ifconfig to figure out your local WLAN ip address (note: this is usually different from public IP address of your computer)::

	ifconfig

	en0: flags=8863<UP,BROADCAST,SMART,RUNNING,SIMPLEX,MULTICAST> mtu 1500
		ether 00:25:4b:b2:dc:32 
		inet6 fe80::225:4bff:feb2:dc32%en0 prefixlen 64 scopeid 0x4 
		inet 192.168.1.130 netmask 0xffffff00 broadcast 192.168.1.255 <--- here inet is IP4 address of local network interface
		media: autoselect (100baseTX <full-duplex,flow-control>)
		status: active

Then you would enter the following to your mobile browser::

    http://192.168.1.130:17881
    
Joomla installation steps
-------------------------

After the supervisord has been started for the first time and the MySQL database is running, run post-install script while PHP is running::
    
    sh scripts/install_joomla.sh
    
This will create MySQL user and database for you.

The database is prepopulated so you do not need run Joomla! or Mobilejoomla! installers.
The Joomla! installer directory is renamed www/installation -> www/_installation.

Ports
-----

If you need to change any ports edit buildout.cfg, application specific section and rerun buildout. 

.. note ::

    Editing buildout.cfg does not change any values direclty. Different application specific configuration files
    are being generated when buildout is run, they do not read buildout.cfg itself. 
    Thus, if you edit buildout.cfg you need to always rerun buildout to make changes effective.

Workflow
---------

This is how to work with Mobilejoomla! code base.

Seeing soure code tree status::

    git status

Adding files::
    
    git add newfile 
    git commit -m "Added the a file"
    
Updating modified file::

    git add modified file 
    git commit -m "Added the a file"

Posting changes to github:

    # This is needed first if the push complains about fastrefs
    # git pull origin master
    git push origin master
   
Updathing changes from github using Mr. Developer script:

    bin/develop up mobilejoomla
    
Creating development database for distribution
==============================================

This will generate ``setupfiles/developmentdatabase.sql``
which contains MySQL database with preinstalled Joomla!,
Terawurfl and Mobilejoomla!.

::

    sh bin/sql_dump.sh
    git add setupfiles/developmentdatabase.sql
    git commit -m "New dev db included"

Other tools
------------

Jappit mobile simulator

* http://www.jappit.com/m/mobilejoomla/proxy.php?d=nokia5800&page=/index.html

Troubleshooting
---------------

MySQL
=====

Connect to the built MySQL by by hand (helper script)::

    bin/mysql # default password is "admin"

MySQL doesn't start because there is already an instance running.
Make sure mysql instances are not running and kill them if needed for restating MySQL::
    
    ps -Af|grep -i mysql # see if any running mysqls
    killall myql
    
If MySQL default port is in use, you can change the port in [ports] section of buildout.cfg
 and reconfigure MySQL config files by running::

    bin/buildout install ports mycnf supervisor

More about Joomla! and non-standard MySQL ports:

* http://docs.joomla.org/How_to_connect_to_an_external_database

File system layouts
===================

Diffing Joomla! source code tree for changes::

    cp -r htdocs/ htdocs_no_install
    # run joomla installer meanwhile
    cd htdocs/joomla
    diff -r -q . ../../htdocs_no_install/joomla/
        

Contact
-------

Please report any issues through Github issue tracker.

Kudos
------

This buildout is orignally based on Alex Clark's effort

* http://old.aclark.net/team/aclark/blog/a-lamp-buildout-for-wordpress-and-other-php-apps

* http://mfabrik.com

Further reading
===============

* http://docs.joomla.org/Setting_up_your_workstation_for_extension_development

