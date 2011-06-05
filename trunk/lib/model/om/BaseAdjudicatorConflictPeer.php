<?php


abstract class BaseAdjudicatorConflictPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'adjudicator_conflicts';

	
	const CLASS_DEFAULT = 'lib.model.AdjudicatorConflict';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'adjudicator_conflicts.ID';

	
	const TEAM_ID = 'adjudicator_conflicts.TEAM_ID';

	
	const ADJUDICATOR_ID = 'adjudicator_conflicts.ADJUDICATOR_ID';

	
	const CREATED_AT = 'adjudicator_conflicts.CREATED_AT';

	
	const UPDATED_AT = 'adjudicator_conflicts.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'TeamId', 'AdjudicatorId', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (AdjudicatorConflictPeer::ID, AdjudicatorConflictPeer::TEAM_ID, AdjudicatorConflictPeer::ADJUDICATOR_ID, AdjudicatorConflictPeer::CREATED_AT, AdjudicatorConflictPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'team_id', 'adjudicator_id', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'TeamId' => 1, 'AdjudicatorId' => 2, 'CreatedAt' => 3, 'UpdatedAt' => 4, ),
		BasePeer::TYPE_COLNAME => array (AdjudicatorConflictPeer::ID => 0, AdjudicatorConflictPeer::TEAM_ID => 1, AdjudicatorConflictPeer::ADJUDICATOR_ID => 2, AdjudicatorConflictPeer::CREATED_AT => 3, AdjudicatorConflictPeer::UPDATED_AT => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'team_id' => 1, 'adjudicator_id' => 2, 'created_at' => 3, 'updated_at' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/AdjudicatorConflictMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.AdjudicatorConflictMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = AdjudicatorConflictPeer::getTableMap();
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
		return str_replace(AdjudicatorConflictPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AdjudicatorConflictPeer::ID);

		$criteria->addSelectColumn(AdjudicatorConflictPeer::TEAM_ID);

		$criteria->addSelectColumn(AdjudicatorConflictPeer::ADJUDICATOR_ID);

		$criteria->addSelectColumn(AdjudicatorConflictPeer::CREATED_AT);

		$criteria->addSelectColumn(AdjudicatorConflictPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(adjudicator_conflicts.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT adjudicator_conflicts.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = AdjudicatorConflictPeer::doSelectRS($criteria, $con);
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
		$objects = AdjudicatorConflictPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return AdjudicatorConflictPeer::populateObjects(AdjudicatorConflictPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			AdjudicatorConflictPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = AdjudicatorConflictPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinTeam(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorConflictPeer::TEAM_ID, TeamPeer::ID);

		$rs = AdjudicatorConflictPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAdjudicator(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorConflictPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = AdjudicatorConflictPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinTeam(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AdjudicatorConflictPeer::addSelectColumns($c);
		$startcol = (AdjudicatorConflictPeer::NUM_COLUMNS - AdjudicatorConflictPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		TeamPeer::addSelectColumns($c);

		$c->addJoin(AdjudicatorConflictPeer::TEAM_ID, TeamPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorConflictPeer::getOMClass();

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
										$temp_obj2->addAdjudicatorConflict($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAdjudicatorConflicts();
				$obj2->addAdjudicatorConflict($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAdjudicator(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AdjudicatorConflictPeer::addSelectColumns($c);
		$startcol = (AdjudicatorConflictPeer::NUM_COLUMNS - AdjudicatorConflictPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		AdjudicatorPeer::addSelectColumns($c);

		$c->addJoin(AdjudicatorConflictPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorConflictPeer::getOMClass();

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
										$temp_obj2->addAdjudicatorConflict($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAdjudicatorConflicts();
				$obj2->addAdjudicatorConflict($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorConflictPeer::TEAM_ID, TeamPeer::ID);

		$criteria->addJoin(AdjudicatorConflictPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = AdjudicatorConflictPeer::doSelectRS($criteria, $con);
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

		AdjudicatorConflictPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorConflictPeer::NUM_COLUMNS - AdjudicatorConflictPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TeamPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TeamPeer::NUM_COLUMNS;

		AdjudicatorPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + AdjudicatorPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorConflictPeer::TEAM_ID, TeamPeer::ID);

		$c->addJoin(AdjudicatorConflictPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorConflictPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = TeamPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getTeam(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addAdjudicatorConflict($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorConflicts();
				$obj2->addAdjudicatorConflict($obj1);
			}


					
			$omClass = AdjudicatorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getAdjudicator(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addAdjudicatorConflict($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initAdjudicatorConflicts();
				$obj3->addAdjudicatorConflict($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptTeam(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorConflictPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = AdjudicatorConflictPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptAdjudicator(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorConflictPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorConflictPeer::TEAM_ID, TeamPeer::ID);

		$rs = AdjudicatorConflictPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptTeam(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AdjudicatorConflictPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorConflictPeer::NUM_COLUMNS - AdjudicatorConflictPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorConflictPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorConflictPeer::getOMClass();

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
					$temp_obj2->addAdjudicatorConflict($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorConflicts();
				$obj2->addAdjudicatorConflict($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptAdjudicator(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AdjudicatorConflictPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorConflictPeer::NUM_COLUMNS - AdjudicatorConflictPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TeamPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TeamPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorConflictPeer::TEAM_ID, TeamPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorConflictPeer::getOMClass();

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
					$temp_obj2->addAdjudicatorConflict($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorConflicts();
				$obj2->addAdjudicatorConflict($obj1);
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
		return AdjudicatorConflictPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(AdjudicatorConflictPeer::ID); 

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
			$comparison = $criteria->getComparison(AdjudicatorConflictPeer::ID);
			$selectCriteria->add(AdjudicatorConflictPeer::ID, $criteria->remove(AdjudicatorConflictPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(AdjudicatorConflictPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(AdjudicatorConflictPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof AdjudicatorConflict) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AdjudicatorConflictPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(AdjudicatorConflict $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AdjudicatorConflictPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AdjudicatorConflictPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(AdjudicatorConflictPeer::DATABASE_NAME, AdjudicatorConflictPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = AdjudicatorConflictPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(AdjudicatorConflictPeer::DATABASE_NAME);

		$criteria->add(AdjudicatorConflictPeer::ID, $pk);


		$v = AdjudicatorConflictPeer::doSelect($criteria, $con);

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
			$criteria->add(AdjudicatorConflictPeer::ID, $pks, Criteria::IN);
			$objs = AdjudicatorConflictPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseAdjudicatorConflictPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/AdjudicatorConflictMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.AdjudicatorConflictMapBuilder');
}
