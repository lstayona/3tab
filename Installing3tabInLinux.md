# Introduction #

A description on how to install 3tab.

# Details #

1. Setup Postgres, PHP and Apache
useful links
  * To install and configure Postgres https://help.ubuntu.com/8.04/serverguide/C/postgresql.html
  * How to install Postgres on Dreamhost VPS http://discussion.dreamhost.com/thread-128619.html
  * Postgres Documentation http://www.postgresql.org/docs/8.3/static/admin.html
  * sudo apt-get install php5-pgsql if having problems with postgres

2. Intall symfony and 3tab

  * Install Symfony from http://www.symfony-project.org/installation/1_0 . Best to use SVN.
  * Checkout Symfony 1.0 (svn co http://svn.symfony-project.com/branches/1.0)
  * Checkout 3tab. (svn checkout http://3tab.googlecode.com/svn/trunk/ 3tab-read-only)
  * Directory structure should be (symfony and 3tab on the same level)
```
- Parent
- - symfony
- - 3tab
```

3. Create database
  * Create the database you want to use. Create a user and grant permissions to the database
  * from 3tab/data/sql :
load lib.model.schema.sql and views.sql into the database you have created

Errors
- when trying to drop tables that don't exist

- when trying to drop views that don't exist
```
psql:views.sql:1: ERROR:  view "team_margins" does not exist
psql:views.sql:2: ERROR:  view "debater_results" does not exist
psql:views.sql:3: ERROR:  view "team_results" does not exist
```
4. Setup 3tab

  * go to your 3tab/config/ directory
  * there is a file called config.php.sample and a file called databases.yml.sample there
  * make a copy and rename both to the same name without the sample
  * so you should have config.php and databases.yml after you're done
  * edit the database.yml to change the line
```
pgsql://postgres:data01@localhost/3tab to suit your database setup. pgsql://username:password@host/database_name
```
  * now edit config.php file
  * there are two variables there
  * you need to point them to your symfony directory
```
$sf_symfony_lib_dir = '/var/www/symfony-1.0/lib';
$sf_symfony_data_dir = '/var/www/symfony-1.0/data';
```
  * Replace "/var/www/symfony-1.0/" with the path to your symfony directory
  * To check if everything is installed correctly, go to your 3tab folder and type ./symfony -T .  You should see a long list of available Pake tasks and some 3tab specific ones at the top (3tab-import-csv-all > 3tab import csv all, 3tab-import-csv-specific > 3tab import csv specific)
  * Run ./symfony fix-perms to fix permissions
  * Run ./symfony cc to clear cache

5. Go to website/3tab/index.php/tournament

**Additional helpful stuff**
To reset database, load load lib.model.schema.sql and views.sql
`psql -U postgres 3tab-ytn_hs -f data.sql`

To dump database
`pg_dump -U postgres -c -o 3tab -f 3tab_logan.sql`

To create database
`createdb -U postgres 3tab-ytn_hs`

To password protect your installation
  * http://wiki.dreamhost.com/Htaccess_file_overview
  * http://wiki.dreamhost.com/Password-protecting_directories