<?php



class AdjudicatorConflictMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.AdjudicatorConflictMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('adjudicator_conflicts');
		$tMap->setPhpName('AdjudicatorConflict');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('adjudicator_conflicts_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('TEAM_ID', 'TeamId', 'int', CreoleTypes::INTEGER, 'teams', 'ID', true, null);

		$tMap->addForeignKey('ADJUDICATOR_ID', 'AdjudicatorId', 'int', CreoleTypes::INTEGER, 'adjudicators', 'ID', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 