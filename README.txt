Introduction
============

- This is the companion code for the blog entry:
  http://aclark.net/team/aclark/blog/a-lamp-buildout-for-wordpress-and-other-php-apps

- This buildout creates a LAMP stack, suitable for deploying many PHP apps. 

Installation
=============

- To install a PHP application via buildout, follow these steps:

    % svn export http://svn.aclark.net/svn/public/buildout/lamp/trunk lamp-buildout
    % cd lamp-buildout
    % python bootstrap.py
    % bin/buildout
    % bin/supervisord -e debug -n

Questions/Comments/Concerns? Please email: aclark@aclark.net.

