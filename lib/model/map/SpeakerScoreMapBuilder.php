<?php



class SpeakerScoreMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SpeakerScoreMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('speaker_scores');
		$tMap->setPhpName('SpeakerScore');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('speaker_scores_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('DEBATER_ID', 'DebaterId', 'int', CreoleTypes::INTEGER, 'debaters', 'ID', true, null);

		$tMap->addColumn('TOTAL_SPEAKER_SCORE', 'TotalSpeakerScore', 'double', CreoleTypes::FLOAT, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 