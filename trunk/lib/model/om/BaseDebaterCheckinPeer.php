<?php


abstract class BaseDebaterCheckinPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'debater_checkins';

	
	const CLASS_DEFAULT = 'lib.model.DebaterCheckin';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'debater_checkins.ID';

	
	const DEBATER_ID = 'debater_checkins.DEBATER_ID';

	
	const ROUND_ID = 'debater_checkins.ROUND_ID';

	
	const CREATED_AT = 'debater_checkins.CREATED_AT';

	
	const UPDATED_AT = 'debater_checkins.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'DebaterId', 'RoundId', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (DebaterCheckinPeer::ID, DebaterCheckinPeer::DEBATER_ID, DebaterCheckinPeer::ROUND_ID, DebaterCheckinPeer::CREATED_AT, DebaterCheckinPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'debater_id', 'round_id', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'DebaterId' => 1, 'RoundId' => 2, 'CreatedAt' => 3, 'UpdatedAt' => 4, ),
		BasePeer::TYPE_COLNAME => array (DebaterCheckinPeer::ID => 0, DebaterCheckinPeer::DEBATER_ID => 1, DebaterCheckinPeer::ROUND_ID => 2, DebaterCheckinPeer::CREATED_AT => 3, DebaterCheckinPeer::UPDATED_AT => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'debater_id' => 1, 'round_id' => 2, 'created_at' => 3, 'updated_at' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/DebaterCheckinMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.DebaterCheckinMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = DebaterCheckinPeer::getTableMap();
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
		return str_replace(DebaterCheckinPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(DebaterCheckinPeer::ID);

		$criteria->addSelectColumn(DebaterCheckinPeer::DEBATER_ID);

		$criteria->addSelectColumn(DebaterCheckinPeer::ROUND_ID);

		$criteria->addSelectColumn(DebaterCheckinPeer::CREATED_AT);

		$criteria->addSelectColumn(DebaterCheckinPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(debater_checkins.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT debater_checkins.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = DebaterCheckinPeer::doSelectRS($criteria, $con);
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
		$objects = DebaterCheckinPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return DebaterCheckinPeer::populateObjects(DebaterCheckinPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			DebaterCheckinPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = DebaterCheckinPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinDebater(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterCheckinPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = DebaterCheckinPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinRound(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterCheckinPeer::ROUND_ID, RoundPeer::ID);

		$rs = DebaterCheckinPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinDebater(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebaterCheckinPeer::addSelectColumns($c);
		$startcol = (DebaterCheckinPeer::NUM_COLUMNS - DebaterCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebaterPeer::addSelectColumns($c);

		$c->addJoin(DebaterCheckinPeer::DEBATER_ID, DebaterPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterCheckinPeer::getOMClass();

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
										$temp_obj2->addDebaterCheckin($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initDebaterCheckins();
				$obj2->addDebaterCheckin($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinRound(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebaterCheckinPeer::addSelectColumns($c);
		$startcol = (DebaterCheckinPeer::NUM_COLUMNS - DebaterCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		RoundPeer::addSelectColumns($c);

		$c->addJoin(DebaterCheckinPeer::ROUND_ID, RoundPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterCheckinPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = RoundPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getRound(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addDebaterCheckin($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initDebaterCheckins();
				$obj2->addDebaterCheckin($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterCheckinPeer::DEBATER_ID, DebaterPeer::ID);

		$criteria->addJoin(DebaterCheckinPeer::ROUND_ID, RoundPeer::ID);

		$rs = DebaterCheckinPeer::doSelectRS($criteria, $con);
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

		DebaterCheckinPeer::addSelectColumns($c);
		$startcol2 = (DebaterCheckinPeer::NUM_COLUMNS - DebaterCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebaterPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebaterPeer::NUM_COLUMNS;

		RoundPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + RoundPeer::NUM_COLUMNS;

		$c->addJoin(DebaterCheckinPeer::DEBATER_ID, DebaterPeer::ID);

		$c->addJoin(DebaterCheckinPeer::ROUND_ID, RoundPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterCheckinPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = DebaterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDebater(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDebaterCheckin($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initDebaterCheckins();
				$obj2->addDebaterCheckin($obj1);
			}


					
			$omClass = RoundPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getRound(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDebaterCheckin($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initDebaterCheckins();
				$obj3->addDebaterCheckin($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptDebater(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterCheckinPeer::ROUND_ID, RoundPeer::ID);

		$rs = DebaterCheckinPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptRound(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DebaterCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DebaterCheckinPeer::DEBATER_ID, DebaterPeer::ID);

		$rs = DebaterCheckinPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptDebater(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebaterCheckinPeer::addSelectColumns($c);
		$startcol2 = (DebaterCheckinPeer::NUM_COLUMNS - DebaterCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		RoundPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + RoundPeer::NUM_COLUMNS;

		$c->addJoin(DebaterCheckinPeer::ROUND_ID, RoundPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterCheckinPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = RoundPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getRound(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDebaterCheckin($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDebaterCheckins();
				$obj2->addDebaterCheckin($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptRound(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DebaterCheckinPeer::addSelectColumns($c);
		$startcol2 = (DebaterCheckinPeer::NUM_COLUMNS - DebaterCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebaterPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebaterPeer::NUM_COLUMNS;

		$c->addJoin(DebaterCheckinPeer::DEBATER_ID, DebaterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DebaterCheckinPeer::getOMClass();

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
					$temp_obj2->addDebaterCheckin($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDebaterCheckins();
				$obj2->addDebaterCheckin($obj1);
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
		return DebaterCheckinPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(DebaterCheckinPeer::ID); 

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
			$comparison = $criteria->getComparison(DebaterCheckinPeer::ID);
			$selectCriteria->add(DebaterCheckinPeer::ID, $criteria->remove(DebaterCheckinPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(DebaterCheckinPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(DebaterCheckinPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof DebaterCheckin) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(DebaterCheckinPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(DebaterCheckin $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(DebaterCheckinPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(DebaterCheckinPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(DebaterCheckinPeer::DATABASE_NAME, DebaterCheckinPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = DebaterCheckinPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(DebaterCheckinPeer::DATABASE_NAME);

		$criteria->add(DebaterCheckinPeer::ID, $pk);


		$v = DebaterCheckinPeer::doSelect($criteria, $con);

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
			$criteria->add(DebaterCheckinPeer::ID, $pks, Criteria::IN);
			$objs = DebaterCheckinPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseDebaterCheckinPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/DebaterCheckinMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.DebaterCheckinMapBuilder');
}
