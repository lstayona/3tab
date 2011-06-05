<?php



class SpeakerScoreSheetMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SpeakerScoreSheetMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('speaker_score_sheets');
		$tMap->setPhpName('SpeakerScoreSheet');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('speaker_score_sheets_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('ADJUDICATOR_ALLOCATION_ID', 'AdjudicatorAllocationId', 'int', CreoleTypes::INTEGER, 'adjudicator_allocations', 'ID', true, null);

		$tMap->addForeignKey('DEBATE_TEAM_XREF_ID', 'DebateTeamXrefId', 'int', CreoleTypes::INTEGER, 'debates_teams_xrefs', 'ID', true, null);

		$tMap->addForeignKey('DEBATER_ID', 'DebaterId', 'int', CreoleTypes::INTEGER, 'debaters', 'ID', true, null);

		$tMap->addColumn('SCORE', 'Score', 'double', CreoleTypes::FLOAT, true, null);

		$tMap->addColumn('SPEAKING_POSITION', 'SpeakingPosition', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 