<?php



class DebateTeamXrefMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.DebateTeamXrefMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('debates_teams_xrefs');
		$tMap->setPhpName('DebateTeamXref');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('debates_teams_xrefs_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('DEBATE_ID', 'DebateId', 'int', CreoleTypes::INTEGER, 'debates', 'ID', true, null);

		$tMap->addForeignKey('TEAM_ID', 'TeamId', 'int', CreoleTypes::INTEGER, 'teams', 'ID', true, null);

		$tMap->addColumn('POSITION', 'Position', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 