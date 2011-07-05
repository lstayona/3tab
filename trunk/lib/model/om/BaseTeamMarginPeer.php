<?php


abstract class BaseTeamMarginPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'team_margins';

	
	const CLASS_DEFAULT = 'lib.model.TeamMargin';

	
	const NUM_COLUMNS = 4;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const DEBATE_TEAM_XREF_ID = 'team_margins.DEBATE_TEAM_XREF_ID';

	
	const MAJORITY_TEAM_SCORE = 'team_margins.MAJORITY_TEAM_SCORE';

	
	const TEAM_SPEAKER_SCORE = 'team_margins.TEAM_SPEAKER_SCORE';

	
	const MARGIN = 'team_margins.MARGIN';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('DebateTeamXrefId', 'MajorityTeamScore', 'TeamSpeakerScore', 'Margin', ),
		BasePeer::TYPE_COLNAME => array (TeamMarginPeer::DEBATE_TEAM_XREF_ID, TeamMarginPeer::MAJORITY_TEAM_SCORE, TeamMarginPeer::TEAM_SPEAKER_SCORE, TeamMarginPeer::MARGIN, ),
		BasePeer::TYPE_FIELDNAME => array ('debate_team_xref_id', 'majority_team_score', 'team_speaker_score', 'margin', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('DebateTeamXrefId' => 0, 'MajorityTeamScore' => 1, 'TeamSpeakerScore' => 2, 'Margin' => 3, ),
		BasePeer::TYPE_COLNAME => array (TeamMarginPeer::DEBATE_TEAM_XREF_ID => 0, TeamMarginPeer::MAJORITY_TEAM_SCORE => 1, TeamMarginPeer::TEAM_SPEAKER_SCORE => 2, TeamMarginPeer::MARGIN => 3, ),
		BasePeer::TYPE_FIELDNAME => array ('debate_team_xref_id' => 0, 'majority_team_score' => 1, 'team_speaker_score' => 2, 'margin' => 3, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/TeamMarginMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.TeamMarginMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = TeamMarginPeer::getTableMap();
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
		return str_replace(TeamMarginPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(TeamMarginPeer::DEBATE_TEAM_XREF_ID);

		$criteria->addSelectColumn(TeamMarginPeer::MAJORITY_TEAM_SCORE);

		$criteria->addSelectColumn(TeamMarginPeer::TEAM_SPEAKER_SCORE);

		$criteria->addSelectColumn(TeamMarginPeer::MARGIN);

	}

	const COUNT = 'COUNT(*)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT *)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamMarginPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamMarginPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TeamMarginPeer::doSelectRS($criteria, $con);
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
		$objects = TeamMarginPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return TeamMarginPeer::populateObjects(TeamMarginPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			TeamMarginPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = TeamMarginPeer::getOMClass();
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
			$criteria->addSelectColumn(TeamMarginPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamMarginPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TeamMarginPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = TeamMarginPeer::doSelectRS($criteria, $con);
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

		TeamMarginPeer::addSelectColumns($c);
		$startcol = (TeamMarginPeer::NUM_COLUMNS - TeamMarginPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebateTeamXrefPeer::addSelectColumns($c);

		$c->addJoin(TeamMarginPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TeamMarginPeer::getOMClass();

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
										$temp_obj2->addTeamMargin($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initTeamMargins();
				$obj2->addTeamMargin($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TeamMarginPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TeamMarginPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TeamMarginPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = TeamMarginPeer::doSelectRS($criteria, $con);
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

		TeamMarginPeer::addSelectColumns($c);
		$startcol2 = (TeamMarginPeer::NUM_COLUMNS - TeamMarginPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebateTeamXrefPeer::NUM_COLUMNS;

		$c->addJoin(TeamMarginPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TeamMarginPeer::getOMClass();


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
					$temp_obj2->addTeamMargin($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initTeamMargins();
				$obj2->addTeamMargin($obj1);
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
		return TeamMarginPeer::CLASS_DEFAULT;
	}

} 
if (Propel::isInit()) {
			try {
		BaseTeamMarginPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/TeamMarginMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.TeamMarginMapBuilder');
}
