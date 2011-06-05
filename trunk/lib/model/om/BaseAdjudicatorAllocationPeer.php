<?php


abstract class BaseAdjudicatorAllocationPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'adjudicator_allocations';

	
	const CLASS_DEFAULT = 'lib.model.AdjudicatorAllocation';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'adjudicator_allocations.ID';

	
	const DEBATE_ID = 'adjudicator_allocations.DEBATE_ID';

	
	const ADJUDICATOR_ID = 'adjudicator_allocations.ADJUDICATOR_ID';

	
	const TYPE = 'adjudicator_allocations.TYPE';

	
	const CREATED_AT = 'adjudicator_allocations.CREATED_AT';

	
	const UPDATED_AT = 'adjudicator_allocations.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'DebateId', 'AdjudicatorId', 'Type', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (AdjudicatorAllocationPeer::ID, AdjudicatorAllocationPeer::DEBATE_ID, AdjudicatorAllocationPeer::ADJUDICATOR_ID, AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocationPeer::CREATED_AT, AdjudicatorAllocationPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'debate_id', 'adjudicator_id', 'type', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'DebateId' => 1, 'AdjudicatorId' => 2, 'Type' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, ),
		BasePeer::TYPE_COLNAME => array (AdjudicatorAllocationPeer::ID => 0, AdjudicatorAllocationPeer::DEBATE_ID => 1, AdjudicatorAllocationPeer::ADJUDICATOR_ID => 2, AdjudicatorAllocationPeer::TYPE => 3, AdjudicatorAllocationPeer::CREATED_AT => 4, AdjudicatorAllocationPeer::UPDATED_AT => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'debate_id' => 1, 'adjudicator_id' => 2, 'type' => 3, 'created_at' => 4, 'updated_at' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/AdjudicatorAllocationMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.AdjudicatorAllocationMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = AdjudicatorAllocationPeer::getTableMap();
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
		return str_replace(AdjudicatorAllocationPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AdjudicatorAllocationPeer::ID);

		$criteria->addSelectColumn(AdjudicatorAllocationPeer::DEBATE_ID);

		$criteria->addSelectColumn(AdjudicatorAllocationPeer::ADJUDICATOR_ID);

		$criteria->addSelectColumn(AdjudicatorAllocationPeer::TYPE);

		$criteria->addSelectColumn(AdjudicatorAllocationPeer::CREATED_AT);

		$criteria->addSelectColumn(AdjudicatorAllocationPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(adjudicator_allocations.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT adjudicator_allocations.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = AdjudicatorAllocationPeer::doSelectRS($criteria, $con);
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
		$objects = AdjudicatorAllocationPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return AdjudicatorAllocationPeer::populateObjects(AdjudicatorAllocationPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			AdjudicatorAllocationPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = AdjudicatorAllocationPeer::getOMClass();
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
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorAllocationPeer::DEBATE_ID, DebatePeer::ID);

		$rs = AdjudicatorAllocationPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorAllocationPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = AdjudicatorAllocationPeer::doSelectRS($criteria, $con);
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

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol = (AdjudicatorAllocationPeer::NUM_COLUMNS - AdjudicatorAllocationPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DebatePeer::addSelectColumns($c);

		$c->addJoin(AdjudicatorAllocationPeer::DEBATE_ID, DebatePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorAllocationPeer::getOMClass();

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
										$temp_obj2->addAdjudicatorAllocation($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAdjudicatorAllocations();
				$obj2->addAdjudicatorAllocation($obj1); 			}
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

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol = (AdjudicatorAllocationPeer::NUM_COLUMNS - AdjudicatorAllocationPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		AdjudicatorPeer::addSelectColumns($c);

		$c->addJoin(AdjudicatorAllocationPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorAllocationPeer::getOMClass();

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
										$temp_obj2->addAdjudicatorAllocation($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAdjudicatorAllocations();
				$obj2->addAdjudicatorAllocation($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorAllocationPeer::DEBATE_ID, DebatePeer::ID);

		$criteria->addJoin(AdjudicatorAllocationPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = AdjudicatorAllocationPeer::doSelectRS($criteria, $con);
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

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorAllocationPeer::NUM_COLUMNS - AdjudicatorAllocationPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebatePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebatePeer::NUM_COLUMNS;

		AdjudicatorPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + AdjudicatorPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorAllocationPeer::DEBATE_ID, DebatePeer::ID);

		$c->addJoin(AdjudicatorAllocationPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorAllocationPeer::getOMClass();


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
					$temp_obj2->addAdjudicatorAllocation($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorAllocations();
				$obj2->addAdjudicatorAllocation($obj1);
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
					$temp_obj3->addAdjudicatorAllocation($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initAdjudicatorAllocations();
				$obj3->addAdjudicatorAllocation($obj1);
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
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorAllocationPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);

		$rs = AdjudicatorAllocationPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AdjudicatorAllocationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AdjudicatorAllocationPeer::DEBATE_ID, DebatePeer::ID);

		$rs = AdjudicatorAllocationPeer::doSelectRS($criteria, $con);
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

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorAllocationPeer::NUM_COLUMNS - AdjudicatorAllocationPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		AdjudicatorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + AdjudicatorPeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorAllocationPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorAllocationPeer::getOMClass();

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
					$temp_obj2->addAdjudicatorAllocation($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorAllocations();
				$obj2->addAdjudicatorAllocation($obj1);
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

		AdjudicatorAllocationPeer::addSelectColumns($c);
		$startcol2 = (AdjudicatorAllocationPeer::NUM_COLUMNS - AdjudicatorAllocationPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DebatePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DebatePeer::NUM_COLUMNS;

		$c->addJoin(AdjudicatorAllocationPeer::DEBATE_ID, DebatePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AdjudicatorAllocationPeer::getOMClass();

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
					$temp_obj2->addAdjudicatorAllocation($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAdjudicatorAllocations();
				$obj2->addAdjudicatorAllocation($obj1);
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
		return AdjudicatorAllocationPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(AdjudicatorAllocationPeer::ID); 

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
			$comparison = $criteria->getComparison(AdjudicatorAllocationPeer::ID);
			$selectCriteria->add(AdjudicatorAllocationPeer::ID, $criteria->remove(AdjudicatorAllocationPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(AdjudicatorAllocationPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(AdjudicatorAllocationPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof AdjudicatorAllocation) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AdjudicatorAllocationPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(AdjudicatorAllocation $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AdjudicatorAllocationPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AdjudicatorAllocationPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(AdjudicatorAllocationPeer::DATABASE_NAME, AdjudicatorAllocationPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = AdjudicatorAllocationPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(AdjudicatorAllocationPeer::DATABASE_NAME);

		$criteria->add(AdjudicatorAllocationPeer::ID, $pk);


		$v = AdjudicatorAllocationPeer::doSelect($criteria, $con);

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
			$criteria->add(AdjudicatorAllocationPeer::ID, $pks, Criteria::IN);
			$objs = AdjudicatorAllocationPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseAdjudicatorAllocationPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/AdjudicatorAllocationMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.AdjudicatorAllocationMapBuilder');
}
