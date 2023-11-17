# Simple PHP Boilerplate

# Dependencies

 * Xampp
   * Install https://www.apachefriends.org/
 * WinSCP
   * Install https://winscp.net/eng/download.php
 * VSCode
   * Install https://code.visualstudio.com/
 * PHP v.8.1+
   * Installed via Xampp
 * Domain and host
    * https://www.simply.com/
 * MySql 4.9+
   * Installed via Xampp
 * Github
   * Register Education https://education.github.com/benefits
     * Use student card and e-mail for free benefits
     * Version control and AI coding
     * GitKraken

---

# How to install

## Configuring the config and secrets

1. Create a "secrets.ini" file 
2. Create a "yourSecrets.ini" file
3. These files should be one directory above the root folder (which is this repository)

secrets.ini should look like the following:

>[database]  
>db_host     = localhost  
>db_name     = jesper_hansenberg_dk_db_php_boilerplate  
>db_user     = root  
>db_password = 

The "yourSecrets.ini" should contain your details for the remote found on Simply.com  
You can now from the file:  
> app/backend/auth/config.php

Change between local or remote database.

## Local

1. This repository should be placed in the folder **C:\xampp\htdocs**
   1. Or whereever you're hosting from.
2. Startup Xampp
   * Startup Apache in Xampp (Webserver)
   * Startup MySQL in Xampp (Database)
3. Goto localhost/phpmyadmin in a browser
4. Create a new database, give it a name and an encoding, f.x.
   * utf8mb4_general_ci
5. **/app/setup/jesper_hansenberg_dk_db_php_boilerplate.sql**
   * Change line 21 `jesper_hansenberg_dk_db_php_boilerplate` and replace it with the name of your database.
6. Select the database and import the SQL

## Remote via Simply.com

1. Startup WinSCP
   1. Login details found via
   2. Simply -> Controlpanel -> Administration -> Login details
   3. Configure a WinSCP connection with the FTP details
2. This repository should be placed in your /public_html/
3. Go to your MySQL controlpanel via simply.com
4. Import **/app/setup/jesper_hansenberg_dk_db_php_boilerplate.sql**

> Notes
> * Simply's phpmyadmin doesn't allow for new database creation
> * Simply's controlpanel database creation doesn't allow for character encoding selection
> * After creating or importing, make sure to check table and column character encoding via phpmyadmin
> Php threads probably needs to be restarted to ensure php 8.1 via .htaccess

### 

---

# Working instructions

---


# Credit
 - Credit to https://github.com/jandaryl/simple-php-boilerplate for initial work, read the readme from the origin to get a better understanding of the project.