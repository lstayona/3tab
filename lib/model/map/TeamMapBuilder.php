<?php



class TeamMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TeamMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('teams');
		$tMap->setPhpName('Team');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('teams_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addForeignKey('INSTITUTION_ID', 'InstitutionId', 'int', CreoleTypes::INTEGER, 'institutions', 'ID', true, null);

		$tMap->addColumn('SWING', 'Swing', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('ENGLISH_AS_A_SECOND_LANGUAGE', 'EnglishAsASecondLanguage', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('ENGLISH_AS_A_FOREIGN_LANGUAGE', 'EnglishAsAForeignLanguage', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('ACTIVE', 'Active', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 