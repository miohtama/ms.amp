.. contents ::

Introduction
============

mobilejoomla.buildout is automated method to install full 
Joomla! and Mobilejoomla! AMP stack as a local user. mobilejoomla.buildout is based on `buildout <http://www.buildout.org>`_
configuration automator.

mobilejoomla.buildout target audience is developers who wish to contribute to Mobilejoomla! development
or site integrators who wish to test Mobilejoomla! easily.

* It will pull the bleeding edge Mobilejoomla! GIT version for development

* It will automatically install Joomla! with Mobilejoomla! extension and Terawurfl device database (with the supplied database)

* It will installed Apache+MySQL+PHP stack   

* Applications and libraries are compiled from the scratch so they have known good set (KGS) and you do not need to struggle with distribution specific problems

* It does not touch any system files which guarantees your computer won't get hosed (everything is done as normal user)

* The installation experience is similar on all Linux distributions and OSX - we do not need to provide minimal distribution specific documentation

* You can set-up Mobilejoomla! development environemtn on new computer in the matter of minutes of effective work time

* Optionally, you can also install Wordpress, SugarCRM and other PHP applications using the same buildout 

.. note ::

	This buildout is not safe for production usage as it contains default passwords.

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

Terminal commands
-----------------

This will checkout the latest mobilejoomla.buildout from Github and run it for you.

    % git clone http://xxx
    % cd mobilejoomla.buildout
    % python bootstrap.py
    % bin/buildout

.. note ::

	Running buildout command may take up to two hours time as it will download
	LAMP stack source code and compile it for you.

	
Then you need to set MySQL master password (admin/admin)

    % parts/mysql/bin/mysqladmin -u admin password 'admin'

The set-up is following:

* Apache port 17881

* MySQL port 17882

* MySQL user: root / admin

* Joomla: not installed, will enter to Joomla installation screen

* Mobilejoomla: not installe, you need to perform manual installation after 

* phpMyAdmin: http://localhost:17881/phpmyadmin
	 
Usage
=====

A utility daemon called `supervisord <http://supervisord.org/>`_ is used to manage Apache and MySQL launching.

You can start MySQL and Apache with the following command

    % bin/supervisord -c parts/supervisor/supervisord.conf -n
	
This will start supervisor process on foreground (non-daemonized mode). When supervisor is terminated,
it will terminate all process started by itself.	
Both MySQL and Apache will be taken down when you press Control-C in the terminal.

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

Ports
-----

If you need to change any ports edit buildout.cfg, application specific section and rerun buildout. 

.. note ::

    Editing buildout.cfg does not change any values direclty. Different application specific configuration files
    are being generated when buildout is run, they do not read buildout.cfg itself. 
    Thus, if you edit buildout.cfg you need to always rerun buildout to make changes effective.

Kudos
=============

This buildout is orignally based on Alex Clark's effort

* http://old.aclark.net/team/aclark/blog/a-lamp-buildout-for-wordpress-and-other-php-apps



