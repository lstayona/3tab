<?php


abstract class BaseDebaterResultPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'debater_results';

	
	const CLASS_DEFAULT = 'lib.model.DebaterResult';

	
	const NUM_COLUMNS = 4;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const DEBATE_TEAM_XREF_ID = 'debater_results.DEBATE_TEAM_XREF_ID';

	
	const DEBATER_ID = 'debater_results.DEBATER_ID';

	
	const SPEAKING_POSITION = 'debater_results.SPEAKING_POSITION';

	
	const AVERAGED_SCORE = 'debater_results.AVERAGED_SCORE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('DebateTeamXrefId', 'DebaterId', 'SpeakingPosition', 'AveragedScore', ),
		BasePeer::TYPE_COLNAME => array (DebaterResultPeer::DEBATE_TEAM_XREF_ID, DebaterResultPeer::DEBATER_ID, DebaterResultPeer::SPEAKING_POSITION, DebaterResultPeer::AVERAGED_SCORE, ),
		BasePeer::TYPE_FIELDNAME => array ('debate_team_xref_id', 'debater_id', 'speaking_position', 'averaged_score', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('DebateTeamXrefId' => 0, 'DebaterId' => 1, 'SpeakingPosition' => 2, 'AveragedScore' => 3, ),
		BasePeer::TYPE_COLNAME => array (DebaterResultPeer::DEBATE_TEAM_XREF_ID => 0, DebaterResultPeer::DEBATER_ID => 1, DebaterResultPeer::SPEAKING_POSITION => 2, DebaterResultPeer::AVERAGED_SCORE => 3, ),
		BasePeer::TYPE_FIELDNAME => array ('debate_team_xref_id' => 0, 'debater_id' => 1, 'speaking_position' => 2, 'averaged_score' => 3, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/DebaterResultMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.DebaterResultMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = DebaterResultPeer::getTableMap();
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
		return str_replace(DebaterResultPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(DebaterResultPeer::DEBATE_TEAM_XREF_ID);

		$criteria->addSelectColumn(DebaterResultPeer::DEBATER_ID);

		$criteria->addSelectColumn(DebaterResultPeer::SPEAKING_POSITION);

		$criteria->addSelectColumn(DebaterResultPeer::AVERAGED_SCORE);

	}

	const COUNT = 'COUNT(*)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT *)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = DebaterResultPeer::doSelectRS($criteria, $con);
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
		$objects = DebaterResultPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return DebaterResultPeer::populateObjects(DebaterResultPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			DebaterResultPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = DebaterResultPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinDebateTeamXref(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = DebaterResultPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(DebaterResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterResultPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = DebaterResultPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinDebateTeamXref(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebaterResultPeer::addSelectColumns($c);
		$startcol = (DebaterResultPeer::NUM_COLUMNS - DebaterResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebateTeamXrefPeer::addSelectColumns($c);

		$c->addJoin(DebaterResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterResultPeer::getOMClass();

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
										$temp_obj2->addDebaterResult($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initDebaterResults();
				$obj2->addDebaterResult($obj1); 			}
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

		DebaterResultPeer::addSelectColumns($c);
		$startcol = (DebaterResultPeer::NUM_COLUMNS - DebaterResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebaterPeer::addSelectColumns($c);

		$c->addJoin(DebaterResultPeer::DEBATER_ID, DebaterPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterResultPeer::getOMClass();

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
										$temp_obj2->addDebaterResult($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initDebaterResults();
				$obj2->addDebaterResult($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$criteria->addJoin(DebaterResultPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = DebaterResultPeer::doSelectRS($criteria, $con);
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

		DebaterResultPeer::addSelectColumns($c);
		$startcol2 = (DebaterResultPeer::NUM_COLUMNS - DebaterResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebateTeamXrefPeer::NUM_COLUMNS;

		DebaterPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DebaterPeer::NUM_COLUMNS;

		$c->addJoin(DebaterResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$c->addJoin(DebaterResultPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterResultPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = DebateTeamXrefPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDebateTeamXref(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDebaterResult($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initDebaterResults();
				$obj2->addDebaterResult($obj1);
			}


					
			$omClass = DebaterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDebater(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDebaterResult($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initDebaterResults();
				$obj3->addDebaterResult($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptDebateTeamXref(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterResultPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = DebaterResultPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(DebaterResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = DebaterResultPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptDebateTeamXref(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebaterResultPeer::addSelectColumns($c);
		$startcol2 = (DebaterResultPeer::NUM_COLUMNS - DebaterResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebaterPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebaterPeer::NUM_COLUMNS;

		$c->addJoin(DebaterResultPeer::DEBATER_ID, DebaterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterResultPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DebaterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDebater(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDebaterResult($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDebaterResults();
				$obj2->addDebaterResult($obj1);
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

		DebaterResultPeer::addSelectColumns($c);
		$startcol2 = (DebaterResultPeer::NUM_COLUMNS - DebaterResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebateTeamXrefPeer::NUM_COLUMNS;

		$c->addJoin(DebaterResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterResultPeer::getOMClass();

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
					$temp_obj2->addDebaterResult($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDebaterResults();
				$obj2->addDebaterResult($obj1);
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
		return DebaterResultPeer::CLASS_DEFAULT;
	}

} 
if (Propel::isInit()) {
			try {
		BaseDebaterResultPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/DebaterResultMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.DebaterResultMapBuilder');
}
