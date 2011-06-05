<?php


abstract class BaseAdjudicatorFeedbackSheetPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'adjudicator_feedback_sheets';

	
	const CLASS_DEFAULT = 'lib.model.AdjudicatorFeedbackSheet';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'adjudicator_feedback_sheets.ID';

	
	const ADJUDICATOR_ID = 'adjudicator_feedback_sheets.ADJUDICATOR_ID';

	
	const ADJUDICATOR_ALLOCATION_ID = 'adjudicator_feedback_sheets.ADJUDICATOR_ALLOCATION_ID';

	
	const DEBATE_TEAM_XREF_ID = 'adjudicator_feedback_sheets.DEBATE_TEAM_XREF_ID';

	
	const COMMENTS = 'adjudicator_feedback_sheets.COMMENTS';

	
	const SCORE = 'adjudicator_feedback_sheets.SCORE';

	
	const CREATED_AT = 'adjudicator_feedback_sheets.CREATED_AT';

	
	const UPDATED_AT = 'adjudicator_feedback_sheets.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'AdjudicatorId', 'AdjudicatorAllocationId', 'DebateTeamXrefId', 'Comments', 'Score', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (AdjudicatorFeedbackSheetPeer::ID, AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, AdjudicatorFeedbackSheetPeer::COMMENTS, AdjudicatorFeedbackSheetPeer::SCORE, AdjudicatorFeedbackSheetPeer::CREATED_AT, AdjudicatorFeedbackSheetPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'adjudicator_id', 'adjudicator_allocation_id', 'debate_team_xref_id', 'comments', 'score', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'AdjudicatorId' => 1, 'AdjudicatorAllocationId' => 2, 'DebateTeamXrefId' => 3, 'Comments' => 4, 'Score' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
		BasePeer::TYPE_COLNAME => array (AdjudicatorFeedbackSheetPeer::ID => 0, AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID => 1, AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID => 2, AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID => 3, AdjudicatorFeedbackSheetPeer::COMMENTS => 4, AdjudicatorFeedbackSheetPeer::SCORE => 5, AdjudicatorFeedbackSheetPeer::CREATED_AT => 6, AdjudicatorFeedbackSheetPeer::UPDATED_AT => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'adjudicator_id' => 1, 'adjudicator_allocation_id' => 2, 'debate_team_xref_id' => 3, 'comments' => 4, 'score' => 5, 'created_at' => 6, 'updated_at' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/AdjudicatorFeedbackSheetMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.AdjudicatorFeedbackSheetMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = AdjudicatorFeedbackSheetPeer::getTableMap();
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
		return str_replace(AdjudicatorFeedbackSheetPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::ID);

		$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID);

		$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID);

		$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID);

		$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COMMENTS);

		$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::SCORE);

		$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::CREATED_AT);

		$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(adjudicator_feedback_sheets.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT adjudicator_feedback_sheets.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = AdjudicatorFeedbackSheetPeer::doSelectRS($criteria, $con);
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
		$objects = AdjudicatorFeedbackSheetPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return AdjudicatorFeedbackSheetPeer::populateObjects(AdjudicatorFeedbackSheetPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			AdjudicatorFeedbackSheetPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = AdjudicatorFeedbackSheetPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinAdjudicator(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = AdjudicatorFeedbackSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAdjudicatorAllocation(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$rs = AdjudicatorFeedbackSheetPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = AdjudicatorFeedbackSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAdjudicator(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AdjudicatorFeedbackSheetPeer::addSelectColumns($c);
		$startcol = (AdjudicatorFeedbackSheetPeer::NUM_COLUMNS - AdjudicatorFeedbackSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		AdjudicatorPeer::addSelectColumns($c);

		$c->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorFeedbackSheetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = AdjudicatorPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getAdjudicator(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addAdjudicatorFeedbackSheet($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAdjudicatorFeedbackSheets();
				$obj2->addAdjudicatorFeedbackSheet($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAdjudicatorAllocation(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AdjudicatorFeedbackSheetPeer::addSelectColumns($c);
		$startcol = (AdjudicatorFeedbackSheetPeer::NUM_COLUMNS - AdjudicatorFeedbackSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		AdjudicatorAllocationPeer::addSelectColumns($c);

		$c->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorFeedbackSheetPeer::getOMClass();

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
										$temp_obj2->addAdjudicatorFeedbackSheet($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAdjudicatorFeedbackSheets();
				$obj2->addAdjudicatorFeedbackSheet($obj1); 			}
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

		AdjudicatorFeedbackSheetPeer::addSelectColumns($c);
		$startcol = (AdjudicatorFeedbackSheetPeer::NUM_COLUMNS - AdjudicatorFeedbackSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebateTeamXrefPeer::addSelectColumns($c);

		$c->addJoin(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorFeedbackSheetPeer::getOMClass();

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
										$temp_obj2->addAdjudicatorFeedbackSheet($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAdjudicatorFeedbackSheets();
				$obj2->addAdjudicatorFeedbackSheet($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = AdjudicatorFeedbackSheetPeer::doSelectRS($criteria, $con);
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

		AdjudicatorFeedbackSheetPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorFeedbackSheetPeer::NUM_COLUMNS - AdjudicatorFeedbackSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorPeer::NUM_COLUMNS;

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + AdjudicatorAllocationPeer::NUM_COLUMNS;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DebateTeamXrefPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$c->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$c->addJoin(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorFeedbackSheetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = AdjudicatorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getAdjudicator(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addAdjudicatorFeedbackSheet($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorFeedbackSheets();
				$obj2->addAdjudicatorFeedbackSheet($obj1);
			}


					
			$omClass = AdjudicatorAllocationPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getAdjudicatorAllocation(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addAdjudicatorFeedbackSheet($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initAdjudicatorFeedbackSheets();
				$obj3->addAdjudicatorFeedbackSheet($obj1);
			}


					
			$omClass = DebateTeamXrefPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDebateTeamXref(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addAdjudicatorFeedbackSheet($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initAdjudicatorFeedbackSheets();
				$obj4->addAdjudicatorFeedbackSheet($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptAdjudicator(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = AdjudicatorFeedbackSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptAdjudicatorAllocation(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = AdjudicatorFeedbackSheetPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorFeedbackSheetPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$criteria->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$rs = AdjudicatorFeedbackSheetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptAdjudicator(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AdjudicatorFeedbackSheetPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorFeedbackSheetPeer::NUM_COLUMNS - AdjudicatorFeedbackSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorAllocationPeer::NUM_COLUMNS;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DebateTeamXrefPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);

		$c->addJoin(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorFeedbackSheetPeer::getOMClass();

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
					$temp_obj2->addAdjudicatorFeedbackSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorFeedbackSheets();
				$obj2->addAdjudicatorFeedbackSheet($obj1);
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
					$temp_obj3->addAdjudicatorFeedbackSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initAdjudicatorFeedbackSheets();
				$obj3->addAdjudicatorFeedbackSheet($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptAdjudicatorAllocation(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AdjudicatorFeedbackSheetPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorFeedbackSheetPeer::NUM_COLUMNS - AdjudicatorFeedbackSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorPeer::NUM_COLUMNS;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DebateTeamXrefPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$c->addJoin(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorFeedbackSheetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = AdjudicatorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getAdjudicator(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addAdjudicatorFeedbackSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorFeedbackSheets();
				$obj2->addAdjudicatorFeedbackSheet($obj1);
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
					$temp_obj3->addAdjudicatorFeedbackSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initAdjudicatorFeedbackSheets();
				$obj3->addAdjudicatorFeedbackSheet($obj1);
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

		AdjudicatorFeedbackSheetPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorFeedbackSheetPeer::NUM_COLUMNS - AdjudicatorFeedbackSheetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorPeer::NUM_COLUMNS;

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + AdjudicatorAllocationPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$c->addJoin(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorFeedbackSheetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = AdjudicatorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getAdjudicator(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addAdjudicatorFeedbackSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorFeedbackSheets();
				$obj2->addAdjudicatorFeedbackSheet($obj1);
			}

			$omClass = AdjudicatorAllocationPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getAdjudicatorAllocation(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addAdjudicatorFeedbackSheet($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initAdjudicatorFeedbackSheets();
				$obj3->addAdjudicatorFeedbackSheet($obj1);
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
		return AdjudicatorFeedbackSheetPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(AdjudicatorFeedbackSheetPeer::ID); 

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
			$comparison = $criteria->getComparison(AdjudicatorFeedbackSheetPeer::ID);
			$selectCriteria->add(AdjudicatorFeedbackSheetPeer::ID, $criteria->remove(AdjudicatorFeedbackSheetPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(AdjudicatorFeedbackSheetPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(AdjudicatorFeedbackSheetPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof AdjudicatorFeedbackSheet) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AdjudicatorFeedbackSheetPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(AdjudicatorFeedbackSheet $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AdjudicatorFeedbackSheetPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AdjudicatorFeedbackSheetPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(AdjudicatorFeedbackSheetPeer::DATABASE_NAME, AdjudicatorFeedbackSheetPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = AdjudicatorFeedbackSheetPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(AdjudicatorFeedbackSheetPeer::DATABASE_NAME);

		$criteria->add(AdjudicatorFeedbackSheetPeer::ID, $pk);


		$v = AdjudicatorFeedbackSheetPeer::doSelect($criteria, $con);

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
			$criteria->add(AdjudicatorFeedbackSheetPeer::ID, $pks, Criteria::IN);
			$objs = AdjudicatorFeedbackSheetPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseAdjudicatorFeedbackSheetPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/AdjudicatorFeedbackSheetMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.AdjudicatorFeedbackSheetMapBuilder');
}
