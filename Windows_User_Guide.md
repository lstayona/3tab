# Introduction #

Full file here : Written by Thevesh Theva

https://docs.google.com/document/d/1TEPdxq99R-hnefaEAsZBCUbE-Nad6sRacKilhukam0k/edit?usp=sharing

Areas covered in this guide:
  * Setting up 3tab
  * Using 3tab
  * Deleting Data in Bulk
  * Importing Data from a CSV file
  * Changing the Scoring Range
  * Networking via wireless network (using IP address)
  * Backing up and Restoring
  * Post-tournament

# Details #

Pro Tip

Sometimes you need to clear symfony's cache before setting changes work (ie changing the score range). Either type “php symfony cc” in your application root folder (but you need to have PHP paths setup properly) or delete all content in the cache folder of your application (go to 3tab/cache - delete everything in) and go back and reload the front page of the app - symfony will recreate the cache pages (http://fabien.potencier.org/article/21/a-symfony-tip-clear-the-cache-without-the-command-line)