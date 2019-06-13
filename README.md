# ![BigBrotherBot](http://i.imgur.com/7sljo4G.png) Echelon 2 Beta (v2.3)

### If you have older versions of Echelon 2, its recommended that you perform a clean installation. (delete everything and install from scratch)

Echelon is a web investigation tool for B3 administrators to study detailed statistics and other helpful information: about the B3 bot; game server clients; and admins. Echelon v.2 is not all about just inspecting information, it is also about interacting with the B3 bot; the gameserver; and the B3 MySQL database.

![Screenshot1](https://i.gyazo.com/79d9649bd3c2e6944cad3f332c8ea0cd.png)
![Screenshot1](https://i.gyazo.com/09150cd6fe48886237e06c2635a3a3c0.png)


NOTE: E-Mail feature is mostly disabled

# Changelog
## [2.3] - 21-12-2018
### Added
- User can set timezone under Settings --> My Account. 
- ported Toplist Penalties from Echelon v1
- Added icons

### Changed
- fixed Greeting, IP-Alias Search
- Navigation bar arrangement
- Maximum tempban duration has been limited to 1 day. Site Admins will be able to customize maximum ban duration in the future.


## Echelon Development v2 ##
All the files are copyrighted by WatchMiltan, Eire.32 (eire32designs.com) and Bigbrotherbot (bigbrotherbot.com)

## Requirements ##
- Webserver (Aphace currently, other support coming soon)
- Version 5+ PHP
- MySQL DB (your B3 DB will work, but a seperate  one is advised)
- A MySQL user with connection rights to your B3 databases
- RCON details for the servers running B3 (RCON support is currently being phased out of Echelon)

## Installation ##
// This is by no means a comprehensive guide, it is a quick guide to get any of you started
- Create a MySQL user to connect your B3 database from your Webserver
```
CREATE DATABASE echelon CHARACTER SET utf8;
GRANT ALL ON echelon.* TO 'echelon'@'localhost' IDENTIFIED BY 'APASSWORD';
FLUSH PRIVILEGES;
```
- Run the echelon.sql file on your database to create the Echelon tables
> source {path_to_file}/echelon.sql
- Copy/Move the echelon folder to your /var/www/html folder
- Set permissions
```
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
- Visit {yoursite}/echelon/install/index.php and follow the installer
- The mail feature doesn't work anymore. Make sure you copy the generated admin password and paste it into a notepad
   (you won't get it again.  Hence the "repeat installation" instructions above)
- Delete the install folder once the web installer is done
- Visit {yoursite}/echelon/index.php
- Get things set up
```
Settings - Game Settings
Settings - Server Settings
Settings - Site Settings
```
- Login to Echelon using the credentials (that were emailed to you, or displayed)
- Setup and config your Echelon to your needs

## NOTE ##
Please understand that there are large portions of Echelon that are unfinished. Please check back to this repo for the latest version.
There is also spotty support for BFBC2, (rcon will not work and will most likely error)
