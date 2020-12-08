### What is this software for? ###

The web application YConfs is designed to hold a catalog of conferences and to support the organizational activity for conferences. 

### Copyright ###

Copyright © 2016 Siberian Federal University

YConfs is free software: you can redistribute it and/or modify it
under the terms of the GNU General Public License,
for details see http://yconfs.sfu-kras.ru/license. 

### System requirements ###

1. Apache web server with .htaccess enabled and mod_rewrite installed.
2. PHP, version >= 5.2 with GD library and email server enabled. (Tested up to PHP 5.6).
3. MySQL with InnoDb Storage Engine.

### Installation steps ###

#### Step 1 
Copy web application folder to the webserver, where Apache + PHP + MySQL are installed. 

Configure write access permissions on folders: assets, uploads, temp, protected/runtime.   
 
#### Step 2 
Configure a virtual host linked to the web application folder in Apache web server. 

These configurations are made in configuration files of Apache web server (httpd.conf, httpd-vhosts.conf or other file depending on the operation system).

#### Step 3
Create a new database in MySQL and a user with access priviliges on it. 

Load the scheme (DB dump) from the file protected/data/schema.sql into the database.
   
##### A brief instruction how to create a database and a user in MySQL.
In console mode launch command "mysql.exe -u root -p" (user name can be different from "root" in your case) and execute:

    CREATE DATABASE `my_db` CHARACTER SET utf8 COLLATE utf8_general_ci;
    CREATE USER 'my_user'@'localhost' IDENTIFIED BY 'my_password';
    GRANT ALL PRIVILEGES ON my_db.* TO 'my_user'@'localhost';
    exit;

Substitute my_db, my_user and my_password for the name of the new database, name of new user and the password for it accordingly. 

To load the database dump execute the command: 

    mysql.exe -u root -p my_db < schema.sql.


#### Step 4
Create a configuration script protected/config/config.php for the web application.

To create it use a template script protected/config/config.dist, make a copy of it and adjust options.
The main options that have to be specified are the name of the website and parameters used to connect to the database:

    'connectionString' => 'mysql:host=localhost;dbname=my_db',
    'username' => 'my_user',
    'password' => 'my_password'.

#### Step 5
Configure cron launching (recommened one time in 10 minutes):

a) to launch cron via web use the following web address:

    http://address/cron/cronPwd,
    (cronPwd parameter is set in config.php);

b) to launch cron from console use the command:

    protected/yiic.php cron.

##### Help for Unix users

    In a unix-like system execute the command "crontab -e"
    and add the string (to launch via HTTP):
    */10 * * * * wget -O /dev/null -q http://address/cron/cronPwd
    or the string (to launch in console mode): 
    */10 * * * * /usr/bin/php /yconfs_directory_path/protected/yiic.php cron
  
#### Step 6
Use login and password both equal to 'admin' to access the website for the first time. 

Change administrator credentials on the first login.

### Contacts ###

[YConfs Official Website](https://yconfs.sfu-kras.ru/)

[Contacts](https://yconfs.sfu-kras.ru/node/9)