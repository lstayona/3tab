<?php



class DebaterMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.DebaterMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('debaters');
		$tMap->setPhpName('Debater');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('debaters_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addForeignKey('TEAM_ID', 'TeamId', 'int', CreoleTypes::INTEGER, 'teams', 'ID', false, null);

		$tMap->addColumn('ENGLISH_AS_A_SECOND_LANGUAGE', 'EnglishAsASecondLanguage', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('ENGLISH_AS_A_FOREIGN_LANGUAGE', 'EnglishAsAForeignLanguage', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 