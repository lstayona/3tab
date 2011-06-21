<?php



class DebaterResultMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.DebaterResultMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('debater_results');
		$tMap->setPhpName('DebaterResult');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignKey('DEBATE_TEAM_XREF_ID', 'DebateTeamXrefId', 'int', CreoleTypes::INTEGER, 'debates_teams_xrefs', 'ID', true, null);

		$tMap->addForeignKey('DEBATER_ID', 'DebaterId', 'int', CreoleTypes::INTEGER, 'debaters', 'ID', true, null);

		$tMap->addColumn('SPEAKING_POSITION', 'SpeakingPosition', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('AVERAGED_SCORE', 'AveragedScore', 'double', CreoleTypes::NUMERIC, true, null);

	} 
} 