<?php



class TeamMarginMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TeamMarginMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('team_margins');
		$tMap->setPhpName('TeamMargin');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignKey('DEBATE_TEAM_XREF_ID', 'DebateTeamXrefId', 'int', CreoleTypes::INTEGER, 'debates_teams_xrefs', 'ID', true, null);

		$tMap->addColumn('MAJORITY_TEAM_SCORE', 'MajorityTeamScore', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TEAM_SPEAKER_SCORE', 'TeamSpeakerScore', 'double', CreoleTypes::NUMERIC, true, null);

		$tMap->addColumn('MARGIN', 'Margin', 'double', CreoleTypes::NUMERIC, true, null);

	} 
} 