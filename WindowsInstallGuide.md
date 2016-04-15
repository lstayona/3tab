# Download the 3 required components #
[Wamp Server](http://www.wampserver.com/en/) (Based on 2.2c)

[PostgreSQL](http://www.postgresql.org/) (Based on 8.4)

[Tortoise SVN](http://tortoisesvn.net)

(Newer versions should also work fine)



# Install Wamp Server #

1. Download the Wamp Server package

2. Double click on the downloaded file to begin installation (I suggest you switch off any security / antivirus software temporarily while installing Wamp Server as it needs to make some system changes that might be blocked by the security software)

3. Follow the on screen instructions and **make sure you set the installation directory to _"c:\wamp"_**

/4. You should now see a Wamp Server icon in the system tray icons area (usually bottom right of your screen.

5. To make sure Wamp Server is installed correctly, left click on the
Wamp Server icon and click on Localhost. You should see a page that shows "Server Configuration Apache Version etc. You can also type http://localhost in your browser to see this page.

6. Wamp Server is installed properly if you see that page. If you get an access forbidden error, just swap **http://localhost* with**http://127.0.0.1* from now on and you should be fine.




# Install PostgreSQL Server #

1. Download the PosgreSQL package

2. Double click on the downloaded file to begin installation

3. Follow the on screen instructions, install in any directory, and you can also choose any directory to store the PostgreSQL data

4. Set your password **Please Remember this for the 3tab set up later**

5. Leave the port number as "5432", **If you decide to change it, please remember it for the 3tab set up later**

6. Deselect Launch Stack Builder at exit (ignore if you don't see this, or just close stack builder if it launches

7. Test your postgreSQL installation by launching the pgAdminIII application

8. Double click on the server (PostgreSQL8.4 (localhost:5432) and you will be prompted for your password.

9. Enter your password to connect (default username is "postgres" if required), you should see one database "postgres" already created, **Do Not Delete this Database**




# Connect Wamp Server to PostgreSQL Server #

1. Go to **c:\wamp\bin\php\php5.3.9** (might be different for newer Wamp Server versions), copy the file **libpq.dll**

2. Paste the file **libpq.dll** in **c:\wamp\bin\apache\apache2.2.21\bin** (might be different for newer Wamp Server Versions

3. Leftlick on the Wamp Server system tray icon, and go to the **PHP->PHP extensions** menu

4. Click on **php\_pgsql** and **php\_pdo\_pgsql** to enable it.

5. Restart your Wamp Server by clicking on restart all services. If the restart is successful, your Wamp Server icon should be green.

6. Click on the Wamp Server icon and go back to **PHP->PHP extensions** menu, make sure that **php\_pgsql** and **php\_pdo\_pgsql** have ticks next to them.

7.  Create a new file in your **c:\wamp\www** directory called **phpinfo.php**. Insert this line **<?php phpinfo() ?> and save the file.**

8. Open your web browser and go to http://localhost/phpinfo.php. Scroll down and look for **pdo\_pgsql** and **pgsql** sections. (use ctrl-f)

9.If you see them both, your Wamp Server is properly set up for PostgreSQL.




# Install TortoiseSVN #

1. Download the TortoiseSVN package from the link up top

2. Click on the TortoiseSVN file to begin installation.

3. You don't have to configure anything, just use the default settings.




# Export 3tab and symfony to your PC with tortoiseSVN #

1. Go to you **c:\wamp\www** folder

2. Right click anywhere and select **TortoiseSVN-> Export**

3. Enter the URL of repository as http://3tab.googlecode.com/svn/trunk/

4. Set the export directory to **c:\wamp\www\3tab**

5. Repeast step 2 & 3 but now set the repository as http://svn.symfony-project.com/branches/1.0

6. Set the export directory to **c:\wamp\www\symfony**

7. Go to c:\wamp\www\3tab\config and create a new text file called **config.php**

8. Enter this inside and save it

```
<?php

// symfony directories
$sf_symfony_lib_dir  = dirname(__FILE__) . '/../../symfony/lib';
$sf_symfony_data_dir = dirname(__FILE__) . '/../../symfony/data';

```

**Change symfony to whatever export directory name you set in step 6**


9. Go to your web browser and enter http://localhost/3tab/web/index.php, if you see a screen that says **"500 error ...oops ...."** the you've exported correctly, otherwise if you get a normal web server error (white page, black text), make sure you've exported correctly before proceeding, just delete the folders in c:\wamp\www and start over from the top of this section.




# Create and link your 3tab database to 3tab #

1. Open pgAdmin III again. Select your server and connect with your username and password.

2. Right click on **Databases** under your server and select **New Database**. Leave everything as default and **enter the name as _3tab_** (or any name of your choice, but please remember this).

3. Right click on the new database **3tab** and select **CREATE Script**, select **File->Open** and go to the **c:\wamp\www\3tab\data\sql** folder.

4. Open the file **lib.model.schema.sql** and execute (press the start button or press f6)

5. Repeat step 3, open the file **views.sql** and execute as well

6. If you go to **3tab->Schemas->Public->Tables** (Hint: Click on the "+ button on th left of each) you should see 18 tables (debaters, debates, rounds, teams etc.)

7. Go to the folder **c:\wamp\www\3tab\config** and create a new file **databases.yml**, copy and paste this inside:

```
all:
  propel:
    class:          sfPropelDatabase
    param:
      dsn:          pgsql://user:pass@localhost/3tab

```

set **user** to your postgreSQL username and **pass** to your postgreSQL password.

-If you used a different database name, replace **3tab** with your database name.

-If you did not use the default port, add **:00000** behind localhost with your port number replacing 00000.


8. Save the **databases.yml** file, go to your browser and open http://localhost/3tab/web/index.php/tournament If you see a screen with 3tab and several button like Tournament, Team Rankings and Contol Panel, **CONGRATULATIONS, you've successfully installed 3tab!**




# Using 3tab for the first time #

1. You should start by registering your institutions by going to **Control Panel -> Institutions**

2. Click on create and enter your first institution.

3. To make sure your database is connected properly, open pgAdmin III onace again, and go to **3tab->Schemas->Tables->Institutions and click the**button to the right of SQL pen and paper button**to view the contents of the institutions table.**

4. You should see one row with the details of the institution you just created, if you see this, you're good to go!

5. Look out for the user guide in the wiki section for further 3tab usage instructions.

6. 