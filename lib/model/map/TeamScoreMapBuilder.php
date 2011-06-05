<?php



class TeamScoreMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TeamScoreMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('team_scores');
		$tMap->setPhpName('TeamScore');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('team_scores_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('TEAM_ID', 'TeamId', 'int', CreoleTypes::INTEGER, 'teams', 'ID', true, null);

		$tMap->addColumn('TOTAL_TEAM_SCORE', 'TotalTeamScore', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TOTAL_SPEAKER_SCORE', 'TotalSpeakerScore', 'double', CreoleTypes::FLOAT, true, null);

		$tMap->addColumn('TOTAL_MARGIN', 'TotalMargin', 'double', CreoleTypes::FLOAT, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 