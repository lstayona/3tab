<?php


abstract class BaseTeamResultPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'team_results';

	
	const CLASS_DEFAULT = 'lib.model.TeamResult';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const DEBATE_TEAM_XREF_ID = 'team_results.DEBATE_TEAM_XREF_ID';

	
	const TEAM_VOTE_COUNT = 'team_results.TEAM_VOTE_COUNT';

	
	const OPPONENT_DEBATE_TEAM_XREF_ID = 'team_results.OPPONENT_DEBATE_TEAM_XREF_ID';

	
	const OPPONENT_TEAM_VOTE_COUNT = 'team_results.OPPONENT_TEAM_VOTE_COUNT';

	
	const MAJORITY_TEAM_SCORE = 'team_results.MAJORITY_TEAM_SCORE';

	
	const WINNING_DEBATE_TEAM_XREF_ID = 'team_results.WINNING_DEBATE_TEAM_XREF_ID';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('DebateTeamXrefId', 'TeamVoteCount', 'OpponentDebateTeamXrefId', 'OpponentTeamVoteCount', 'MajorityTeamScore', 'WinningDebateTeamXrefId', ),
		BasePeer::TYPE_COLNAME => array (TeamResultPeer::DEBATE_TEAM_XREF_ID, TeamResultPeer::TEAM_VOTE_COUNT, TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID, TeamResultPeer::OPPONENT_TEAM_VOTE_COUNT, TeamResultPeer::MAJORITY_TEAM_SCORE, TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('debate_team_xref_id', 'team_vote_count', 'opponent_debate_team_xref_id', 'opponent_team_vote_count', 'majority_team_score', 'winning_debate_team_xref_id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('DebateTeamXrefId' => 0, 'TeamVoteCount' => 1, 'OpponentDebateTeamXrefId' => 2, 'OpponentTeamVoteCount' => 3, 'MajorityTeamScore' => 4, 'WinningDebateTeamXrefId' => 5, ),
		BasePeer::TYPE_COLNAME => array (TeamResultPeer::DEBATE_TEAM_XREF_ID => 0, TeamResultPeer::TEAM_VOTE_COUNT => 1, TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID => 2, TeamResultPeer::OPPONENT_TEAM_VOTE_COUNT => 3, TeamResultPeer::MAJORITY_TEAM_SCORE => 4, TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('debate_team_xref_id' => 0, 'team_vote_count' => 1, 'opponent_debate_team_xref_id' => 2, 'opponent_team_vote_count' => 3, 'majority_team_score' => 4, 'winning_debate_team_xref_id' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/TeamResultMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.TeamResultMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = TeamResultPeer::getTableMap();
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
		return str_replace(TeamResultPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(TeamResultPeer::DEBATE_TEAM_XREF_ID);

		$criteria->addSelectColumn(TeamResultPeer::TEAM_VOTE_COUNT);

		$criteria->addSelectColumn(TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID);

		$criteria->addSelectColumn(TeamResultPeer::OPPONENT_TEAM_VOTE_COUNT);

		$criteria->addSelectColumn(TeamResultPeer::MAJORITY_TEAM_SCORE);

		$criteria->addSelectColumn(TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID);

	}

	const COUNT = 'COUNT(team_results.DEBATE_TEAM_XREF_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT team_results.DEBATE_TEAM_XREF_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TeamResultPeer::doSelectRS($criteria, $con);
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
		$objects = TeamResultPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return TeamResultPeer::populateObjects(TeamResultPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			TeamResultPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = TeamResultPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinDebateTeamXrefRelatedByDebateTeamXrefId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TeamResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = TeamResultPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinDebateTeamXrefRelatedByOpponentDebateTeamXrefId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = TeamResultPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinDebateTeamXrefRelatedByWinningDebateTeamXrefId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = TeamResultPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinDebateTeamXrefRelatedByDebateTeamXrefId(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TeamResultPeer::addSelectColumns($c);
		$startcol = (TeamResultPeer::NUM_COLUMNS - TeamResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebateTeamXrefPeer::addSelectColumns($c);

		$c->addJoin(TeamResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TeamResultPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DebateTeamXrefPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getDebateTeamXrefRelatedByDebateTeamXrefId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addTeamResultRelatedByDebateTeamXrefId($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initTeamResultsRelatedByDebateTeamXrefId();
				$obj2->addTeamResultRelatedByDebateTeamXrefId($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinDebateTeamXrefRelatedByOpponentDebateTeamXrefId(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TeamResultPeer::addSelectColumns($c);
		$startcol = (TeamResultPeer::NUM_COLUMNS - TeamResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebateTeamXrefPeer::addSelectColumns($c);

		$c->addJoin(TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TeamResultPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DebateTeamXrefPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addTeamResultRelatedByOpponentDebateTeamXrefId($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initTeamResultsRelatedByOpponentDebateTeamXrefId();
				$obj2->addTeamResultRelatedByOpponentDebateTeamXrefId($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinDebateTeamXrefRelatedByWinningDebateTeamXrefId(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TeamResultPeer::addSelectColumns($c);
		$startcol = (TeamResultPeer::NUM_COLUMNS - TeamResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebateTeamXrefPeer::addSelectColumns($c);

		$c->addJoin(TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TeamResultPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DebateTeamXrefPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getDebateTeamXrefRelatedByWinningDebateTeamXrefId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addTeamResultRelatedByWinningDebateTeamXrefId($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initTeamResultsRelatedByWinningDebateTeamXrefId();
				$obj2->addTeamResultRelatedByWinningDebateTeamXrefId($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TeamResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$criteria->addJoin(TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$criteria->addJoin(TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = TeamResultPeer::doSelectRS($criteria, $con);
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

		TeamResultPeer::addSelectColumns($c);
		$startcol2 = (TeamResultPeer::NUM_COLUMNS - TeamResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebateTeamXrefPeer::NUM_COLUMNS;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DebateTeamXrefPeer::NUM_COLUMNS;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DebateTeamXrefPeer::NUM_COLUMNS;

		$c->addJoin(TeamResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$c->addJoin(TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$c->addJoin(TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TeamResultPeer::getOMClass();


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
				$temp_obj2 = $temp_obj1->getDebateTeamXrefRelatedByDebateTeamXrefId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addTeamResultRelatedByDebateTeamXrefId($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initTeamResultsRelatedByDebateTeamXrefId();
				$obj2->addTeamResultRelatedByDebateTeamXrefId($obj1);
			}


					
			$omClass = DebateTeamXrefPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addTeamResultRelatedByOpponentDebateTeamXrefId($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initTeamResultsRelatedByOpponentDebateTeamXrefId();
				$obj3->addTeamResultRelatedByOpponentDebateTeamXrefId($obj1);
			}


					
			$omClass = DebateTeamXrefPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDebateTeamXrefRelatedByWinningDebateTeamXrefId(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addTeamResultRelatedByWinningDebateTeamXrefId($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initTeamResultsRelatedByWinningDebateTeamXrefId();
				$obj4->addTeamResultRelatedByWinningDebateTeamXrefId($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptDebateTeamXrefRelatedByDebateTeamXrefId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TeamResultPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptDebateTeamXrefRelatedByOpponentDebateTeamXrefId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TeamResultPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptDebateTeamXrefRelatedByWinningDebateTeamXrefId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamResultPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamResultPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TeamResultPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptDebateTeamXrefRelatedByDebateTeamXrefId(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TeamResultPeer::addSelectColumns($c);
		$startcol2 = (TeamResultPeer::NUM_COLUMNS - TeamResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TeamResultPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptDebateTeamXrefRelatedByOpponentDebateTeamXrefId(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TeamResultPeer::addSelectColumns($c);
		$startcol2 = (TeamResultPeer::NUM_COLUMNS - TeamResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TeamResultPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptDebateTeamXrefRelatedByWinningDebateTeamXrefId(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TeamResultPeer::addSelectColumns($c);
		$startcol2 = (TeamResultPeer::NUM_COLUMNS - TeamResultPeer::NUM_LAZY_LOAD_COLUMNS) + 1;


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TeamResultPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

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
		return TeamResultPeer::CLASS_DEFAULT;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(TeamResultPeer::DATABASE_NAME);

		$criteria->add(TeamResultPeer::DEBATE_TEAM_XREF_ID, $pk);


		$v = TeamResultPeer::doSelect($criteria, $con);

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
			$criteria->add(TeamResultPeer::DEBATE_TEAM_XREF_ID, $pks, Criteria::IN);
			$objs = TeamResultPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseTeamResultPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/TeamResultMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.TeamResultMapBuilder');
}
