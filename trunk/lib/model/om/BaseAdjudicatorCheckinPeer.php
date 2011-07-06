<?php


abstract class BaseAdjudicatorCheckinPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'adjudicator_checkins';

	
	const CLASS_DEFAULT = 'lib.model.AdjudicatorCheckin';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'adjudicator_checkins.ID';

	
	const ADJUDICATOR_ID = 'adjudicator_checkins.ADJUDICATOR_ID';

	
	const ROUND_ID = 'adjudicator_checkins.ROUND_ID';

	
	const CREATED_AT = 'adjudicator_checkins.CREATED_AT';

	
	const UPDATED_AT = 'adjudicator_checkins.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'AdjudicatorId', 'RoundId', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (AdjudicatorCheckinPeer::ID, AdjudicatorCheckinPeer::ADJUDICATOR_ID, AdjudicatorCheckinPeer::ROUND_ID, AdjudicatorCheckinPeer::CREATED_AT, AdjudicatorCheckinPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'adjudicator_id', 'round_id', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'AdjudicatorId' => 1, 'RoundId' => 2, 'CreatedAt' => 3, 'UpdatedAt' => 4, ),
		BasePeer::TYPE_COLNAME => array (AdjudicatorCheckinPeer::ID => 0, AdjudicatorCheckinPeer::ADJUDICATOR_ID => 1, AdjudicatorCheckinPeer::ROUND_ID => 2, AdjudicatorCheckinPeer::CREATED_AT => 3, AdjudicatorCheckinPeer::UPDATED_AT => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'adjudicator_id' => 1, 'round_id' => 2, 'created_at' => 3, 'updated_at' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/AdjudicatorCheckinMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.AdjudicatorCheckinMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = AdjudicatorCheckinPeer::getTableMap();
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
		return str_replace(AdjudicatorCheckinPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AdjudicatorCheckinPeer::ID);

		$criteria->addSelectColumn(AdjudicatorCheckinPeer::ADJUDICATOR_ID);

		$criteria->addSelectColumn(AdjudicatorCheckinPeer::ROUND_ID);

		$criteria->addSelectColumn(AdjudicatorCheckinPeer::CREATED_AT);

		$criteria->addSelectColumn(AdjudicatorCheckinPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(adjudicator_checkins.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT adjudicator_checkins.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = AdjudicatorCheckinPeer::doSelectRS($criteria, $con);
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
		$objects = AdjudicatorCheckinPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return AdjudicatorCheckinPeer::populateObjects(AdjudicatorCheckinPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			AdjudicatorCheckinPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = AdjudicatorCheckinPeer::getOMClass();
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
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorCheckinPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = AdjudicatorCheckinPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorCheckinPeer::ROUND_ID, RoundPeer::ID);

		$rs = AdjudicatorCheckinPeer::doSelectRS($criteria, $con);
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

		AdjudicatorCheckinPeer::addSelectColumns($c);
		$startcol = (AdjudicatorCheckinPeer::NUM_COLUMNS - AdjudicatorCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		AdjudicatorPeer::addSelectColumns($c);

		$c->addJoin(AdjudicatorCheckinPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorCheckinPeer::getOMClass();

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
										$temp_obj2->addAdjudicatorCheckin($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAdjudicatorCheckins();
				$obj2->addAdjudicatorCheckin($obj1); 			}
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

		AdjudicatorCheckinPeer::addSelectColumns($c);
		$startcol = (AdjudicatorCheckinPeer::NUM_COLUMNS - AdjudicatorCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		RoundPeer::addSelectColumns($c);

		$c->addJoin(AdjudicatorCheckinPeer::ROUND_ID, RoundPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorCheckinPeer::getOMClass();

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
										$temp_obj2->addAdjudicatorCheckin($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAdjudicatorCheckins();
				$obj2->addAdjudicatorCheckin($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorCheckinPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$criteria->addJoin(AdjudicatorCheckinPeer::ROUND_ID, RoundPeer::ID);

		$rs = AdjudicatorCheckinPeer::doSelectRS($criteria, $con);
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

		AdjudicatorCheckinPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorCheckinPeer::NUM_COLUMNS - AdjudicatorCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorPeer::NUM_COLUMNS;

		RoundPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + RoundPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorCheckinPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$c->addJoin(AdjudicatorCheckinPeer::ROUND_ID, RoundPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorCheckinPeer::getOMClass();


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
					$temp_obj2->addAdjudicatorCheckin($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorCheckins();
				$obj2->addAdjudicatorCheckin($obj1);
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
					$temp_obj3->addAdjudicatorCheckin($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initAdjudicatorCheckins();
				$obj3->addAdjudicatorCheckin($obj1);
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
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorCheckinPeer::ROUND_ID, RoundPeer::ID);

		$rs = AdjudicatorCheckinPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorCheckinPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorCheckinPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = AdjudicatorCheckinPeer::doSelectRS($criteria, $con);
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

		AdjudicatorCheckinPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorCheckinPeer::NUM_COLUMNS - AdjudicatorCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		RoundPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + RoundPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorCheckinPeer::ROUND_ID, RoundPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorCheckinPeer::getOMClass();

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
					$temp_obj2->addAdjudicatorCheckin($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorCheckins();
				$obj2->addAdjudicatorCheckin($obj1);
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

		AdjudicatorCheckinPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorCheckinPeer::NUM_COLUMNS - AdjudicatorCheckinPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorCheckinPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorCheckinPeer::getOMClass();

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
					$temp_obj2->addAdjudicatorCheckin($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorCheckins();
				$obj2->addAdjudicatorCheckin($obj1);
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
		return AdjudicatorCheckinPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(AdjudicatorCheckinPeer::ID); 

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
			$comparison = $criteria->getComparison(AdjudicatorCheckinPeer::ID);
			$selectCriteria->add(AdjudicatorCheckinPeer::ID, $criteria->remove(AdjudicatorCheckinPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(AdjudicatorCheckinPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(AdjudicatorCheckinPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof AdjudicatorCheckin) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AdjudicatorCheckinPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(AdjudicatorCheckin $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AdjudicatorCheckinPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AdjudicatorCheckinPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(AdjudicatorCheckinPeer::DATABASE_NAME, AdjudicatorCheckinPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = AdjudicatorCheckinPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(AdjudicatorCheckinPeer::DATABASE_NAME);

		$criteria->add(AdjudicatorCheckinPeer::ID, $pk);


		$v = AdjudicatorCheckinPeer::doSelect($criteria, $con);

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
			$criteria->add(AdjudicatorCheckinPeer::ID, $pks, Criteria::IN);
			$objs = AdjudicatorCheckinPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseAdjudicatorCheckinPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/AdjudicatorCheckinMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.AdjudicatorCheckinMapBuilder');
}
