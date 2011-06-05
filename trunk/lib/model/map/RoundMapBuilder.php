<?php



class RoundMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.RoundMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('rounds');
		$tMap->setPhpName('Round');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('rounds_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, null);

		$tMap->addColumn('TYPE', 'Type', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('STATUS', 'Status', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('PRECEDED_BY_ROUND_ID', 'PrecededByRoundId', 'int', CreoleTypes::INTEGER, 'rounds', 'ID', false, null);

		$tMap->addColumn('FEEDBACK_WEIGHTAGE', 'FeedbackWeightage', 'double', CreoleTypes::FLOAT, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 