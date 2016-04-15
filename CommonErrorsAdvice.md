#problems that arise and common causes

# Introduction #

Got an error? See if anyone else has caught it before and what might be the issue

# Details #

1. Import Doesn't work
  * you must import the institutions first, followed by the teams, then debaters, then judges/venues
  * you must create rounds before importing judges
  * open the excel file in a text editor and check if it exported to csv correctly : field contents delimited with "" and fields separated by ,
  * everyone must be attached to an institution - if creating independent judges, create an institution called "independent"

2. Some debaters are not being important
  * 3tab compares debaters names to ensure there are no duplicates. If there are two debaters with the same name, it will skip that row

3. Matchups not confirming
  * could be because there insufficient active venues