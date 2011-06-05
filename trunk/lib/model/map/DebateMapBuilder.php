<?php



class DebateMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.DebateMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('debates');
		$tMap->setPhpName('Debate');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('debates_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('ROUND_ID', 'RoundId', 'int', CreoleTypes::INTEGER, 'rounds', 'ID', true, null);

		$tMap->addForeignKey('VENUE_ID', 'VenueId', 'int', CreoleTypes::INTEGER, 'venues', 'ID', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 