<?php



class TraineeAllocationMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TraineeAllocationMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('trainee_allocations');
		$tMap->setPhpName('TraineeAllocation');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('trainee_allocations_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('TRAINEE_ID', 'TraineeId', 'int', CreoleTypes::INTEGER, 'adjudicators', 'ID', true, null);

		$tMap->addForeignKey('CHAIR_ID', 'ChairId', 'int', CreoleTypes::INTEGER, 'adjudicators', 'ID', true, null);

		$tMap->addForeignKey('ROUND_ID', 'RoundId', 'int', CreoleTypes::INTEGER, 'rounds', 'ID', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 