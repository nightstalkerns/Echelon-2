# ![BigBrotherBot](http://i.imgur.com/7sljo4G.png) Echelon 2 Beta (v2.3)

### If you have older versions of Echelon 2, its recommended that you perform a clean installation. (delete everything and install from scratch)

Echelon is a web investigation tool for B3 administrators to study detailed statistics and other helpful information: about the B3 bot; game server clients; and admins. Echelon v.2 is not all about just inspecting information, it is also about interacting with the B3 bot; the gameserver; and the B3 MySQL database.

![Screenshot1](https://i.gyazo.com/09150cd6fe48886237e06c2635a3a3c0.png)


NOTE: E-Mail feature is mostly disabled

# Changelog
# [2.3] - 2018.12.21
#       - 2019.06.15 mapconfig added
#       - 2019.08.05 installation instructions updated

## Echelon Development v2 ##
All the files are copyrighted by WatchMiltan, Eire.32 (eire32designs.com) and Bigbrotherbot (bigbrotherbot.com)

## Requirements ##
- Webserver (Aphace currently, other support coming soon)
- Version 5+ PHP
- MySQL DB (your B3 DB will work, but a seperate  one is advised)
- A MySQL user with connection rights to your B3 databases
- RCON details for the servers running B3 (RCON support is currently being phased out of Echelon)

## Installation ##

download zip from https://github.com/dkman123/Echelon-2

install apache prereq
> sudo apt install apache2

install php prerequisites
```
sudo apt install php
sudo apt install php-mysqli
```

to test php and verify extensions (not necessary)
```
cd /var/www/html
sudo mkdir testphp
sudo chown urt testphp
cd testphp
featherpad ./phpinfo.php
```
contents of phpinfo.php
```
<?php

// Show all information, defaults to INFO_ALL
phpinfo();

// Show just the module information.
// phpinfo(8) yields identical results.
phpinfo(INFO_MODULES);

?>
```

perform updates (not absolutely necessary)
```
sudo apt-get update
sudo apt-get upgrade
```

NOTE: In case you need it, the apache log shows php errors
> sudo featherpad /var/log/apache2/access.log

turn off directory listing
> sudo featherpad /etc/apache2/apache2.conf

find the line with <Directory /var/www/>

remove “Indexes” from the next line

restart apache
> sudo systemctl restart apache2


edit the php.ini file
> sudo featherpad /etc/php/7.2/apache2/php.ini

uncomment the line 
> extension=mysqli

if you need to debug echelon (or anything php)

Change display_errors to On (for normal operation you probably want this Off for security)
> display_errors = On

you may need to restart apache
> sudo systemctl restart apache2


Visit http://localhost/testphp/phpinfo.php

it should work

if it does you can rename phpinfo.php to phpinfo.phpX (for security reasons)
```
cd /var/www/html/testphp
sudo mv phpinfo.php phpinfo.phpX
```

if you get a blank white page make sure php installed (you're hitting a php error)
> sudo apt-get install php

-----

- Create a MySQL user to connect your echelon database from your Webserver 

(replace **{NEWPASSWORD}** below. store this as the "mysql echelon" user)
```
mysql -u root -p

CREATE DATABASE echelon CHARACTER SET utf8;
GRANT ALL ON echelon.* TO 'echelon'@'localhost' IDENTIFIED BY '{NEWPASSWORD}';
FLUSH PRIVILEGES;
```
- Run the echelon.sql file on your database to create the Echelon tables
```
use echelon;
source ~/Documents/Echelon-2/echelon.sql
source ~/Documents/Echelon-2/echelon-2.3.1-mapconfig.sql
source ~/Documents/Echelon-2/echelon-2.3.2-mapconfig.sql
```

- Copy/Move the echelon folder to your /var/www/html folder
- Set permissions
```
sudo mv ~/Documents/Echelon-2/echelon /var/www/html/echelon
cd /var/www/html
sudo chmod 664 echelon
sudo chmod 775 echelon

cd /var/www/html/echelon
sudo chgrp -R www-data *

# the web server needs to be able to write to these folders
sudo chmod 775 install
sudo chmod 775 inc
sudo chmod 775 lib

cd /var/www/html/echelon/install
sudo chown www-data *
# sudo chgrp www-data *

cd /var/www/html/echelon/inc
sudo chown www-data config.php
sudo chmod 774 config.php

cd /var/www/html/echelon
sudo chmod 774 lib/log.txt
```
- NOTE: If you need to repeat installation:
```
  cd /var/www/html/install
  cp config_orig.php config.php
  sudo chown www-data *
  sudo chgrp www-data *
	# in mysql: delete from ech_users where username='admin';
```

- Visit http://localhost/echelon/install/index.php and follow the installer
```
Your email address
Database Host: 127.0.0.1
Database Username: echelon
Database Password: what you replaced as the mysql echelon user
Database Name: echelon
```
- The mail feature doesn't work anymore. 

**Make sure you copy the generated admin password and paste it into a notepad
   (you won't get it again.**  Hence the "repeat installation" instructions above)

Read the error at the top.

- Delete the install folder once the web installer is done
> sudo rm -r install

- Visit http://localhost/echelon/index.php
- Get things set up

Settings - Game Settings
```
Full Name: Urban terror
Short Name: UrT
Game: Urban terror
Hostname: 127.0.0.1
User: b3
Database Name: b3
DB Password: whatever you replaced as the mysql b3 user
```
note: when you save this page you get an expanded page

turn on xlrstats (optional)

re-enter the b3 DB password, enter the admin password in the bottom verification

Settings - Server Settings

add a server
```
Server Name: your server name
IPAddress: 127.0.0.1
RCON IP: 127.0.0.1
RCON Port: 28960
RCON Password: whatever you set as the rcon password in the server.cfg
```

Settings - Site Settings
```
Site Name: {enter your details}...
...
PHP Time Format: D, Y-m-d (H:i)
PHP Time Zone: America/New_York
SSL connection required: we will revisit this one
```

Settings - My Account

change your password if you'd like

Settings - Site Admin

add other users

You need to email the reg key to the new users

- Login to Echelon using the credentials (that were emailed to you, or displayed)

- Setup and config your Echelon to your needs

## NOTE ##
Please understand that there are large portions of Echelon that are unfinished. Please check back to this repo for the latest version.
There is also spotty support for BFBC2, (rcon will not work and will most likely error)
