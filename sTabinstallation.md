# Stuff to know #
  * Tested on Windows 7, Windows XP
  * Software uses PHP, Apache, PostgreSQL

# What you need #
  * WAMP
  * PostgreSQL

# How to install #
  1. Install the required software & moving the script
    1. WAMP. The installation directory must be C:\wamp
    1. PostgreSQL. Set the password to postgres. If asked, set the username to postgres as well
    1. Move the folder 3tab\_full to C:\wamp\www\
    1. The settings of directories and passwords can be found in databases.yml and config.php under 3tab\_full\3tab\config\
  1. Fixing the corrupt dll files in WAMP
    1. Exit WAMP
    1. WAMP 2.0c uses php5.2.6. The dll files for pgsql in this version are broken
    1. Go to C:\wamp\bin\php\php5.2.6\ext, and replace php\_pdo\_pgsql.dll and php\_pgsql.dll with the files in the installation package (dll files)
    1. Start WAMP, left click the system tray icon, click on start services. After that, left click again and go to PHP->PHP extensions. Make sure php\_pgsql and php\_pdo\_pgsql have checkmarks next to them
    1. Go to http://localhost/?phpinfo=1 and if you see pdo\_pgsql and pgsql, you’ve done it correctly
  1. Changing timeout settings for WAMP
    1. As rounds progress, it will take a longer time to confirm the results after inputting all the data. The current WAMP settings set a timeout limit to 30 seconds, which needs to be changed to 0 (=unlimited)
    1. Go to Wamp\bin\apache\apache2.2.8\bin\php.ini. Change the value of max\_execution\_time and max\_input\_time to 0 from 30 and 60 respectively.
    1. Change settings for Wamp\bin\php\php5.2.6\php.ini as well. It is necessary to change both files.
    1. Click on restart all services->start all services. Make sure the system tray icon turns white (from red, then yellow)
  1. Setting up postgreSQL
    1. Start->postgresql8.4->pgAdminIII
    1. Connect to the server ‘postgreSQL 8.4’(password should be postgres), right click database, and create a new database. The database name must be called '3tab'
    1. Right click database stab, select ‘create script’ (or execute arbitrary SQL queries)
    1. Click File -> Open, select ‘lib.model.schema.sql’. It can be found in the C:\WAMP\www\3tab\_full\3tab\data\sql
    1. Query-> execute pgScript (or press F6)
    1. Repeat the two steps above for the 'views.sql' file. It can be also found at C:\WAMP\www\3tab\_full\3tab\data\sql folder.
  1. Access http://localhost/3tab_full/3tab/web/index.php/tournament . If the page is displayed, you’re done!