[buildout]
parts =
    ports
    env
    grp
    mysql
    mysql_install_db
    mysql-bin
    mysql-admin
    mycnf
    apache
    apache-conf
    gd
    php
    php-conf
    wordpress
#    phpmyadmin
#    sugarcrm
#    phorum
    supervisor
    pidproxy

[ports]
recipe = plone.recipe.command
command = 
    echo This buildout uses the following ports:
    echo Supervisor: ${ports:supervisor}
    echo Apache: ${ports:apache}
    echo MySQL: ${ports:mysql}
supervisor = 8000
apache = 8001
mysql = 8002

[env]
recipe = gocept.recipe.env

[grp]
recipe = collective.recipe.grp

[mysql]
recipe = hexagonit.recipe.cmmi
url = http://dev.mysql.com/get/Downloads/MySQL-5.1/mysql-5.1.40.tar.gz/from/http://mirror.trouble-free.net/mysql_mirror/
keep-compile-dir = true
configure-options =

[mysql_install_db]
recipe = plone.recipe.command
command = 
    ${mysql:location}/bin/mysql_install_db --datadir=${mycnf:datadir}
    echo 
    echo After starting supervisord, you may want to run:
    echo ${buildout:directory}/parts/mysql/bin/mysqladmin -u root password 'new-password'
    echo
update-command = ${mysql_install_db:command}

[mycnf]
recipe = plone.recipe.command
command =
    echo
    echo These options are passed to mysqld_safe: ${mycnf:opt}
    echo
basedir=${mysql:location}
datadir=${buildout:directory}/var
pid=${mycnf:datadir}/mysql.pid
err = ${mycnf:datadir}/log/mysql.err
sock = ${mycnf:datadir}/mysql.sock
opt = --port=${ports:mysql} --pid-file=${mycnf:pid} --log-error=${mycnf:err} --basedir=${mycnf:basedir} --datadir=${mycnf:datadir} --socket=${mycnf:sock}

[mysql-bin]
recipe = collective.recipe.template
input = ${buildout:directory}/templates/mysql.in
output = ${buildout:directory}/bin/mysql

[mysql-admin]
recipe = collective.recipe.template
input = ${buildout:directory}/templates/mysqladmin.in
output = ${buildout:directory}/bin/mysqladmin

[apache]
recipe = hexagonit.recipe.cmmi
url = http://mirror.nyi.net/apache/httpd/httpd-2.2.14.tar.gz
keep-compile-dir = true
configure-options = --enable-so

[gd]
recipe = hexagonit.recipe.cmmi
url = http://www.libgd.org/releases/gd-2.0.35.tar.gz
keep-compile-dir = true
configure-options = 

[php]
recipe = zc.recipe.cmmi
environment = 
    PATH=${mysql:location}/bin:${env:PATH}
url = http://us3.php.net/get/php-5.2.11.tar.gz/from/this/mirror
extra_options = --prefix=${buildout:directory}/parts/apache/php --with-gd=${buildout:directory}/parts/gd --with-apxs2=${buildout:directory}/parts/apache/bin/apxs --with-mysql=${mysql:location} --with-config-file-path=${buildout:directory}/etc/php.ini --enable-mbstring

[apache-conf]
recipe = collective.recipe.template
port = 12080
input = ${buildout:directory}/templates/httpd.conf.in
output = ${buildout:directory}/etc/httpd.conf

[php-conf]
recipe = collective.recipe.template
input = ${buildout:directory}/templates/php.ini.in
output = ${buildout:directory}/etc/php.ini

[wordpress]
recipe = hexagonit.recipe.download
url = http://wordpress.org/latest.tar.gz
destination = ${buildout:directory}/htdocs
strip-top-level-dir = true

[phpmyadmin]
recipe = hexagonit.recipe.download
#url = http://prdownloads.sourceforge.net/phpmyadmin/phpMyAdmin-3.1.3.2-english.tar.bz2
url = http://prdownloads.sourceforge.net/phpmyadmin/phpMyAdmin-3.1.3.2-english.tar.gz
destination = ${buildout:directory}/htdocs
strip-top-level-dir = true

[sugarcrm]
recipe = hexagonit.recipe.download
#url = http://www.sugarforge.org/frs/download.php/5252/SugarCE-5.2.0c.zip
url = http://www.sugarforge.org/frs/download.php/5597/SugarCE-5.2.0f.zip
destination = ${buildout:directory}/htdocs
strip-top-level-dir = true

[phorum]
recipe = hexagonit.recipe.download
url = http://www.phorum.org/downloads/phorum-5.2.10.tar.gz
destination = ${buildout:directory}/htdocs
strip-top-level-dir = true

[pidproxy]
recipe = zc.recipe.egg
eggs = supervisor
dependent-scripts = true

[supervisor]
recipe = collective.recipe.supervisor
port = ${ports:supervisor}
serverurl = http://127.0.0.1:${ports:supervisor}
pp = ${buildout:directory}/eggs/supervisor-3.0a7-py2.5.egg/supervisor/pidproxy.py
programs =
    10 mysql ${supervisor:pp} [ ${mycnf:pid} ${mysql:location}/bin/mysqld_safe ${mycnf:opt} ]
    20 apache ${apache:location}/bin/httpd [ -c "ErrorLog /dev/stdout" -DFOREGROUND -f ${buildout:directory}/etc/httpd.conf ]
