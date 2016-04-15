Backing up files

1.	Connect to the server
2.	Right click database stab->backup
3.	Choose a file name. The format should be in ‘compress’mode
4.	If successful, the program should return “Process returned exit code 0.”

Restoring files

1.	Connect to the server
2.	Right click database stab->backup
3.	Select the file
4.	Make sure you check ‘clean before restore’ before restoring, or the program will return an error
5.	If successful, the program should return “Process returned exit code 0.”

Importing Tournament Data

	Data is case sensitive (ex. Institutions)
	If there are debaters with same names, make sure that they’re entered differently (ex. ‘John Smith(Monash)’, ‘John Smith(Oxford)’

Starting Rounds

	Enter (or import) institutions, venues, teams, debaters
	Go to round->create
	Filling in data
	Name: Round 1, Round 2, etc.
	Type: 1-random draw, 2-power paired
	Feedback weightage: if the weight of feedbacks are the same throughout all rounds, make the variable consistent ( ex. 1)
	Preceded by round: select the round before the round your creating. If you are creating Round 3, select round 2, if you are creating round 7, select round 6. For round 1, you can’t select anything so leave it blank

Bugs

1.	If the adjudicator’s score is 1, and he is placed in a chair during adjudicator allocation, he can still be selected under trainee allocation
2.	Trainee feedbacks can be submitted infinitely
3.	The ‘bracket’ number in previous view matchups reflect the recent number

Other

	Logs will be created under \www\stab\log. The file gets bigger as you use the software, so delete the logs often to prevent stab from taking up space from your hard drive
	The matchups are not random; they are ordered from higher brackets to lower brackets