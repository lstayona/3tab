<?php



class TeamResultMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TeamResultMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('team_results');
		$tMap->setPhpName('TeamResult');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('DEBATE_TEAM_XREF_ID', 'DebateTeamXrefId', 'int' , CreoleTypes::INTEGER, 'debates_teams_xrefs', 'ID', true, null);

		$tMap->addColumn('TEAM_VOTE_COUNT', 'TeamVoteCount', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('OPPONENT_DEBATE_TEAM_XREF_ID', 'OpponentDebateTeamXrefId', 'int', CreoleTypes::INTEGER, 'debates_teams_xrefs', 'ID', true, null);

		$tMap->addColumn('OPPONENT_TEAM_VOTE_COUNT', 'OpponentTeamVoteCount', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('MAJORITY_TEAM_SCORE', 'MajorityTeamScore', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('WINNING_DEBATE_TEAM_XREF_ID', 'WinningDebateTeamXrefId', 'int', CreoleTypes::INTEGER, 'debates_teams_xrefs', 'ID', true, null);

	} 
} 