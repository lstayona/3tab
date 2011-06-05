<?php



class AdjudicatorMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.AdjudicatorMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('adjudicators');
		$tMap->setPhpName('Adjudicator');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('adjudicators_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('TEST_SCORE', 'TestScore', 'double', CreoleTypes::FLOAT, true, null);

		$tMap->addForeignKey('INSTITUTION_ID', 'InstitutionId', 'int', CreoleTypes::INTEGER, 'institutions', 'ID', true, null);

		$tMap->addColumn('ACTIVE', 'Active', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 