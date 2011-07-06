<?php



class DebaterCheckinMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.DebaterCheckinMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('debater_checkins');
		$tMap->setPhpName('DebaterCheckin');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('debater_checkins_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('DEBATER_ID', 'DebaterId', 'int', CreoleTypes::INTEGER, 'debaters', 'ID', true, null);

		$tMap->addForeignKey('ROUND_ID', 'RoundId', 'int', CreoleTypes::INTEGER, 'rounds', 'ID', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 