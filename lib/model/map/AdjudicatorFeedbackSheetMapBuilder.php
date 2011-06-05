<?php



class AdjudicatorFeedbackSheetMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.AdjudicatorFeedbackSheetMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('adjudicator_feedback_sheets');
		$tMap->setPhpName('AdjudicatorFeedbackSheet');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('adjudicator_feedback_sheets_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('ADJUDICATOR_ID', 'AdjudicatorId', 'int', CreoleTypes::INTEGER, 'adjudicators', 'ID', true, null);

		$tMap->addForeignKey('ADJUDICATOR_ALLOCATION_ID', 'AdjudicatorAllocationId', 'int', CreoleTypes::INTEGER, 'adjudicator_allocations', 'ID', false, null);

		$tMap->addForeignKey('DEBATE_TEAM_XREF_ID', 'DebateTeamXrefId', 'int', CreoleTypes::INTEGER, 'debates_teams_xrefs', 'ID', false, null);

		$tMap->addColumn('COMMENTS', 'Comments', 'string', CreoleTypes::VARCHAR, false, 500);

		$tMap->addColumn('SCORE', 'Score', 'double', CreoleTypes::FLOAT, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 