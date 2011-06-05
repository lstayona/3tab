<?php



class AdjudicatorAllocationMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.AdjudicatorAllocationMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('adjudicator_allocations');
		$tMap->setPhpName('AdjudicatorAllocation');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('adjudicator_allocations_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('DEBATE_ID', 'DebateId', 'int', CreoleTypes::INTEGER, 'debates', 'ID', true, null);

		$tMap->addForeignKey('ADJUDICATOR_ID', 'AdjudicatorId', 'int', CreoleTypes::INTEGER, 'adjudicators', 'ID', true, null);

		$tMap->addColumn('TYPE', 'Type', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 