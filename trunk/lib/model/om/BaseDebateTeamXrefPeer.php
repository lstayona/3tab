<?php


abstract class BaseDebateTeamXrefPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'debates_teams_xrefs';

	
	const CLASS_DEFAULT = 'lib.model.DebateTeamXref';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'debates_teams_xrefs.ID';

	
	const DEBATE_ID = 'debates_teams_xrefs.DEBATE_ID';

	
	const TEAM_ID = 'debates_teams_xrefs.TEAM_ID';

	
	const POSITION = 'debates_teams_xrefs.POSITION';

	
	const CREATED_AT = 'debates_teams_xrefs.CREATED_AT';

	
	const UPDATED_AT = 'debates_teams_xrefs.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'DebateId', 'TeamId', 'Position', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (DebateTeamXrefPeer::ID, DebateTeamXrefPeer::DEBATE_ID, DebateTeamXrefPeer::TEAM_ID, DebateTeamXrefPeer::POSITION, DebateTeamXrefPeer::CREATED_AT, DebateTeamXrefPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'debate_id', 'team_id', 'position', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'DebateId' => 1, 'TeamId' => 2, 'Position' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, ),
		BasePeer::TYPE_COLNAME => array (DebateTeamXrefPeer::ID => 0, DebateTeamXrefPeer::DEBATE_ID => 1, DebateTeamXrefPeer::TEAM_ID => 2, DebateTeamXrefPeer::POSITION => 3, DebateTeamXrefPeer::CREATED_AT => 4, DebateTeamXrefPeer::UPDATED_AT => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'debate_id' => 1, 'team_id' => 2, 'position' => 3, 'created_at' => 4, 'updated_at' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/DebateTeamXrefMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.DebateTeamXrefMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = DebateTeamXrefPeer::getTableMap();
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
		return str_replace(DebateTeamXrefPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(DebateTeamXrefPeer::ID);

		$criteria->addSelectColumn(DebateTeamXrefPeer::DEBATE_ID);

		$criteria->addSelectColumn(DebateTeamXrefPeer::TEAM_ID);

		$criteria->addSelectColumn(DebateTeamXrefPeer::POSITION);

		$criteria->addSelectColumn(DebateTeamXrefPeer::CREATED_AT);

		$criteria->addSelectColumn(DebateTeamXrefPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(debates_teams_xrefs.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT debates_teams_xrefs.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = DebateTeamXrefPeer::doSelectRS($criteria, $con);
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
		$objects = DebateTeamXrefPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return DebateTeamXrefPeer::populateObjects(DebateTeamXrefPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			DebateTeamXrefPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = DebateTeamXrefPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinDebate(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebateTeamXrefPeer::DEBATE_ID, DebatePeer::ID);

		$rs = DebateTeamXrefPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinTeam(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebateTeamXrefPeer::TEAM_ID, TeamPeer::ID);

		$rs = DebateTeamXrefPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinDebate(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol = (DebateTeamXrefPeer::NUM_COLUMNS - DebateTeamXrefPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebatePeer::addSelectColumns($c);

		$c->addJoin(DebateTeamXrefPeer::DEBATE_ID, DebatePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebateTeamXrefPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DebatePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getDebate(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addDebateTeamXref($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initDebateTeamXrefs();
				$obj2->addDebateTeamXref($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinTeam(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol = (DebateTeamXrefPeer::NUM_COLUMNS - DebateTeamXrefPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		TeamPeer::addSelectColumns($c);

		$c->addJoin(DebateTeamXrefPeer::TEAM_ID, TeamPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebateTeamXrefPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = TeamPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getTeam(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addDebateTeamXref($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initDebateTeamXrefs();
				$obj2->addDebateTeamXref($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebateTeamXrefPeer::DEBATE_ID, DebatePeer::ID);

		$criteria->addJoin(DebateTeamXrefPeer::TEAM_ID, TeamPeer::ID);

		$rs = DebateTeamXrefPeer::doSelectRS($criteria, $con);
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

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol2 = (DebateTeamXrefPeer::NUM_COLUMNS - DebateTeamXrefPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebatePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebatePeer::NUM_COLUMNS;

		TeamPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + TeamPeer::NUM_COLUMNS;

		$c->addJoin(DebateTeamXrefPeer::DEBATE_ID, DebatePeer::ID);

		$c->addJoin(DebateTeamXrefPeer::TEAM_ID, TeamPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebateTeamXrefPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = DebatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDebate(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDebateTeamXref($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initDebateTeamXrefs();
				$obj2->addDebateTeamXref($obj1);
			}


					
			$omClass = TeamPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getTeam(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDebateTeamXref($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initDebateTeamXrefs();
				$obj3->addDebateTeamXref($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptDebate(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebateTeamXrefPeer::TEAM_ID, TeamPeer::ID);

		$rs = DebateTeamXrefPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptTeam(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebateTeamXrefPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebateTeamXrefPeer::DEBATE_ID, DebatePeer::ID);

		$rs = DebateTeamXrefPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptDebate(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol2 = (DebateTeamXrefPeer::NUM_COLUMNS - DebateTeamXrefPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TeamPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TeamPeer::NUM_COLUMNS;

		$c->addJoin(DebateTeamXrefPeer::TEAM_ID, TeamPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebateTeamXrefPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = TeamPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getTeam(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDebateTeamXref($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDebateTeamXrefs();
				$obj2->addDebateTeamXref($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptTeam(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebateTeamXrefPeer::addSelectColumns($c);
		$startcol2 = (DebateTeamXrefPeer::NUM_COLUMNS - DebateTeamXrefPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebatePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebatePeer::NUM_COLUMNS;

		$c->addJoin(DebateTeamXrefPeer::DEBATE_ID, DebatePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebateTeamXrefPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DebatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDebate(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDebateTeamXref($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDebateTeamXrefs();
				$obj2->addDebateTeamXref($obj1);
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
		return DebateTeamXrefPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(DebateTeamXrefPeer::ID); 

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
			$comparison = $criteria->getComparison(DebateTeamXrefPeer::ID);
			$selectCriteria->add(DebateTeamXrefPeer::ID, $criteria->remove(DebateTeamXrefPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(DebateTeamXrefPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(DebateTeamXrefPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof DebateTeamXref) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(DebateTeamXrefPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(DebateTeamXref $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(DebateTeamXrefPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(DebateTeamXrefPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(DebateTeamXrefPeer::DATABASE_NAME, DebateTeamXrefPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = DebateTeamXrefPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(DebateTeamXrefPeer::DATABASE_NAME);

		$criteria->add(DebateTeamXrefPeer::ID, $pk);


		$v = DebateTeamXrefPeer::doSelect($criteria, $con);

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
			$criteria->add(DebateTeamXrefPeer::ID, $pks, Criteria::IN);
			$objs = DebateTeamXrefPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseDebateTeamXrefPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/DebateTeamXrefMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.DebateTeamXrefMapBuilder');
}
