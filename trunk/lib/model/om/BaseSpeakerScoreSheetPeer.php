<?php


abstract class BaseSpeakerScoreSheetPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'speaker_score_sheets';

	
	const CLASS_DEFAULT = 'lib.model.SpeakerScoreSheet';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'speaker_score_sheets.ID';

	
	const ADJUDICATOR_ALLOCATION_ID = 'speaker_score_sheets.ADJUDICATOR_ALLOCATION_ID';

	
	const DEBATE_TEAM_XREF_ID = 'speaker_score_sheets.DEBATE_TEAM_XREF_ID';

	
	const DEBATER_ID = 'speaker_score_sheets.DEBATER_ID';

	
	const SCORE = 'speaker_score_sheets.SCORE';

	
	const SPEAKING_POSITION = 'speaker_score_sheets.SPEAKING_POSITION';

	
	const CREATED_AT = 'speaker_score_sheets.CREATED_AT';

	
	const UPDATED_AT = 'speaker_score_sheets.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'AdjudicatorAllocationId', 'DebateTeamXrefId', 'DebaterId', 'Score', 'SpeakingPosition', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (SpeakerScoreSheetPeer::ID, SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, SpeakerScoreSheetPeer::DEBATER_ID, SpeakerScoreSheetPeer::SCORE, SpeakerScoreSheetPeer::SPEAKING_POSITION, SpeakerScoreSheetPeer::CREATED_AT, SpeakerScoreSheetPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'adjudicator_allocation_id', 'debate_team_xref_id', 'debater_id', 'score', 'speaking_position', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'AdjudicatorAllocationId' => 1, 'DebateTeamXrefId' => 2, 'DebaterId' => 3, 'Score' => 4, 'SpeakingPosition' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
		BasePeer::TYPE_COLNAME => array (SpeakerScoreSheetPeer::ID => 0, SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID => 1, SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID => 2, SpeakerScoreSheetPeer::DEBATER_ID => 3, SpeakerScoreSheetPeer::SCORE => 4, SpeakerScoreSheetPeer::SPEAKING_POSITION => 5, SpeakerScoreSheetPeer::CREATED_AT => 6, SpeakerScoreSheetPeer::UPDATED_AT => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'adjudicator_allocation_id' => 1, 'debate_team_xref_id' => 2, 'debater_id' => 3, 'score' => 4, 'speaking_position' => 5, 'created_at' => 6, 'updated_at' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/SpeakerScoreSheetMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.SpeakerScoreSheetMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = SpeakerScoreSheetPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(SpeakerScoreSheetPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(SpeakerScoreSheetPeer::ID);

		$criteria->addSelectColumn(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID);

		$criteria->addSelectColumn(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID);

		$criteria->addSelectColumn(SpeakerScoreSheetPeer::DEBATER_ID);

		$criteria->addSelectColumn(SpeakerScoreSheetPeer::SCORE);

		$criteria->addSelectColumn(SpeakerScoreSheetPeer::SPEAKING_POSITION);

		$criteria->addSelectColumn(SpeakerScoreSheetPeer::CREATED_AT);

		$criteria->addSelectColumn(SpeakerScoreSheetPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(speaker_score_sheets.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT speaker_score_sheets.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = SpeakerScoreSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = SpeakerScoreSheetPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return SpeakerScoreSheetPeer::populateObjects(SpeakerScoreSheetPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			SpeakerScoreSheetPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = SpeakerScoreSheetPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinAdjudicatorAllocation(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$rs = SpeakerScoreSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinDebateTeamXref(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = SpeakerScoreSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinDebater(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SpeakerScoreSheetPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = SpeakerScoreSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAdjudicatorAllocation(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SpeakerScoreSheetPeer::addSelectColumns($c);
		$startcol = (SpeakerScoreSheetPeer::NUM_COLUMNS - SpeakerScoreSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		AdjudicatorAllocationPeer::addSelectColumns($c);

		$c->addJoin(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SpeakerScoreSheetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = AdjudicatorAllocationPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getAdjudicatorAllocation(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addSpeakerScoreSheet($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initSpeakerScoreSheets();
				$obj2->addSpeakerScoreSheet($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinDebateTeamXref(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SpeakerScoreSheetPeer::addSelectColumns($c);
		$startcol = (SpeakerScoreSheetPeer::NUM_COLUMNS - SpeakerScoreSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebateTeamXrefPeer::addSelectColumns($c);

		$c->addJoin(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SpeakerScoreSheetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DebateTeamXrefPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getDebateTeamXref(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addSpeakerScoreSheet($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initSpeakerScoreSheets();
				$obj2->addSpeakerScoreSheet($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinDebater(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SpeakerScoreSheetPeer::addSelectColumns($c);
		$startcol = (SpeakerScoreSheetPeer::NUM_COLUMNS - SpeakerScoreSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebaterPeer::addSelectColumns($c);

		$c->addJoin(SpeakerScoreSheetPeer::DEBATER_ID, DebaterPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SpeakerScoreSheetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DebaterPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getDebater(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addSpeakerScoreSheet($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initSpeakerScoreSheets();
				$obj2->addSpeakerScoreSheet($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$criteria->addJoin(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$criteria->addJoin(SpeakerScoreSheetPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = SpeakerScoreSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SpeakerScoreSheetPeer::addSelectColumns($c);
		$startcol2 = (SpeakerScoreSheetPeer::NUM_COLUMNS - SpeakerScoreSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorAllocationPeer::NUM_COLUMNS;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DebateTeamXrefPeer::NUM_COLUMNS;

		DebaterPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DebaterPeer::NUM_COLUMNS;

		$c->addJoin(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$c->addJoin(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$c->addJoin(SpeakerScoreSheetPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SpeakerScoreSheetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = AdjudicatorAllocationPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getAdjudicatorAllocation(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addSpeakerScoreSheet($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initSpeakerScoreSheets();
				$obj2->addSpeakerScoreSheet($obj1);
			}


					
			$omClass = DebateTeamXrefPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDebateTeamXref(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addSpeakerScoreSheet($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initSpeakerScoreSheets();
				$obj3->addSpeakerScoreSheet($obj1);
			}


					
			$omClass = DebaterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDebater(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addSpeakerScoreSheet($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initSpeakerScoreSheets();
				$obj4->addSpeakerScoreSheet($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptAdjudicatorAllocation(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$criteria->addJoin(SpeakerScoreSheetPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = SpeakerScoreSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptDebateTeamXref(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$criteria->addJoin(SpeakerScoreSheetPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = SpeakerScoreSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptDebater(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SpeakerScoreSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$criteria->addJoin(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = SpeakerScoreSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptAdjudicatorAllocation(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SpeakerScoreSheetPeer::addSelectColumns($c);
		$startcol2 = (SpeakerScoreSheetPeer::NUM_COLUMNS - SpeakerScoreSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebateTeamXrefPeer::NUM_COLUMNS;

		DebaterPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DebaterPeer::NUM_COLUMNS;

		$c->addJoin(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$c->addJoin(SpeakerScoreSheetPeer::DEBATER_ID, DebaterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SpeakerScoreSheetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DebateTeamXrefPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDebateTeamXref(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addSpeakerScoreSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initSpeakerScoreSheets();
				$obj2->addSpeakerScoreSheet($obj1);
			}

			$omClass = DebaterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDebater(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addSpeakerScoreSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initSpeakerScoreSheets();
				$obj3->addSpeakerScoreSheet($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptDebateTeamXref(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SpeakerScoreSheetPeer::addSelectColumns($c);
		$startcol2 = (SpeakerScoreSheetPeer::NUM_COLUMNS - SpeakerScoreSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorAllocationPeer::NUM_COLUMNS;

		DebaterPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DebaterPeer::NUM_COLUMNS;

		$c->addJoin(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$c->addJoin(SpeakerScoreSheetPeer::DEBATER_ID, DebaterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SpeakerScoreSheetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = AdjudicatorAllocationPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getAdjudicatorAllocation(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addSpeakerScoreSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initSpeakerScoreSheets();
				$obj2->addSpeakerScoreSheet($obj1);
			}

			$omClass = DebaterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDebater(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addSpeakerScoreSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initSpeakerScoreSheets();
				$obj3->addSpeakerScoreSheet($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptDebater(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SpeakerScoreSheetPeer::addSelectColumns($c);
		$startcol2 = (SpeakerScoreSheetPeer::NUM_COLUMNS - SpeakerScoreSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorAllocationPeer::NUM_COLUMNS;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DebateTeamXrefPeer::NUM_COLUMNS;

		$c->addJoin(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$c->addJoin(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SpeakerScoreSheetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = AdjudicatorAllocationPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getAdjudicatorAllocation(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addSpeakerScoreSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initSpeakerScoreSheets();
				$obj2->addSpeakerScoreSheet($obj1);
			}

			$omClass = DebateTeamXrefPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDebateTeamXref(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addSpeakerScoreSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initSpeakerScoreSheets();
				$obj3->addSpeakerScoreSheet($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return SpeakerScoreSheetPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(SpeakerScoreSheetPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(SpeakerScoreSheetPeer::ID);
			$selectCriteria->add(SpeakerScoreSheetPeer::ID, $criteria->remove(SpeakerScoreSheetPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(SpeakerScoreSheetPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(SpeakerScoreSheetPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof SpeakerScoreSheet) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(SpeakerScoreSheetPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(SpeakerScoreSheet $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(SpeakerScoreSheetPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(SpeakerScoreSheetPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(SpeakerScoreSheetPeer::DATABASE_NAME, SpeakerScoreSheetPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = SpeakerScoreSheetPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(SpeakerScoreSheetPeer::DATABASE_NAME);

		$criteria->add(SpeakerScoreSheetPeer::ID, $pk);


		$v = SpeakerScoreSheetPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(SpeakerScoreSheetPeer::ID, $pks, Criteria::IN);
			$objs = SpeakerScoreSheetPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseSpeakerScoreSheetPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/SpeakerScoreSheetMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.SpeakerScoreSheetMapBuilder');
}
