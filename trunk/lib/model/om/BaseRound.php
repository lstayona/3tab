<?php


abstract class BaseRound extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $type;


	
	protected $status = 1;


	
	protected $preceded_by_round_id;


	
	protected $feedback_weightage = 0;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aRoundRelatedByPrecededByRoundId;

	
	protected $collRoundsRelatedByPrecededByRoundId;

	
	protected $lastRoundRelatedByPrecededByRoundIdCriteria = null;

	
	protected $collDebates;

	
	protected $lastDebateCriteria = null;

	
	protected $collTraineeAllocations;

	
	protected $lastTraineeAllocationCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getType()
	{

		return $this->type;
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function getPrecededByRoundId()
	{

		return $this->preceded_by_round_id;
	}

	
	public function getFeedbackWeightage()
	{

		return $this->feedback_weightage;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
						$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = RoundPeer::ID;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = RoundPeer::NAME;
		}

	} 
	
	public function setType($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = RoundPeer::TYPE;
		}

	} 
	
	public function setStatus($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->status !== $v || $v === 1) {
			$this->status = $v;
			$this->modifiedColumns[] = RoundPeer::STATUS;
		}

	} 
	
	public function setPrecededByRoundId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->preceded_by_round_id !== $v) {
			$this->preceded_by_round_id = $v;
			$this->modifiedColumns[] = RoundPeer::PRECEDED_BY_ROUND_ID;
		}

		if ($this->aRoundRelatedByPrecededByRoundId !== null && $this->aRoundRelatedByPrecededByRoundId->getId() !== $v) {
			$this->aRoundRelatedByPrecededByRoundId = null;
		}

	} 
	
	public function setFeedbackWeightage($v)
	{

		if ($this->feedback_weightage !== $v || $v === 0) {
			$this->feedback_weightage = $v;
			$this->modifiedColumns[] = RoundPeer::FEEDBACK_WEIGHTAGE;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = RoundPeer::CREATED_AT;
		}

	} 
	
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = RoundPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->type = $rs->getInt($startcol + 2);

			$this->status = $rs->getInt($startcol + 3);

			$this->preceded_by_round_id = $rs->getInt($startcol + 4);

			$this->feedback_weightage = $rs->getFloat($startcol + 5);

			$this->created_at = $rs->getTimestamp($startcol + 6, null);

			$this->updated_at = $rs->getTimestamp($startcol + 7, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Round object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RoundPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			RoundPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(RoundPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(RoundPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RoundPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->aRoundRelatedByPrecededByRoundId !== null) {
				if ($this->aRoundRelatedByPrecededByRoundId->isModified()) {
					$affectedRows += $this->aRoundRelatedByPrecededByRoundId->save($con);
				}
				$this->setRoundRelatedByPrecededByRoundId($this->aRoundRelatedByPrecededByRoundId);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = RoundPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += RoundPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collRoundsRelatedByPrecededByRoundId !== null) {
				foreach($this->collRoundsRelatedByPrecededByRoundId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDebates !== null) {
				foreach($this->collDebates as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTraineeAllocations !== null) {
				foreach($this->collTraineeAllocations as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aRoundRelatedByPrecededByRoundId !== null) {
				if (!$this->aRoundRelatedByPrecededByRoundId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRoundRelatedByPrecededByRoundId->getValidationFailures());
				}
			}


			if (($retval = RoundPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDebates !== null) {
					foreach($this->collDebates as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTraineeAllocations !== null) {
					foreach($this->collTraineeAllocations as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RoundPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getType();
				break;
			case 3:
				return $this->getStatus();
				break;
			case 4:
				return $this->getPrecededByRoundId();
				break;
			case 5:
				return $this->getFeedbackWeightage();
				break;
			case 6:
				return $this->getCreatedAt();
				break;
			case 7:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RoundPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getType(),
			$keys[3] => $this->getStatus(),
			$keys[4] => $this->getPrecededByRoundId(),
			$keys[5] => $this->getFeedbackWeightage(),
			$keys[6] => $this->getCreatedAt(),
			$keys[7] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RoundPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setType($value);
				break;
			case 3:
				$this->setStatus($value);
				break;
			case 4:
				$this->setPrecededByRoundId($value);
				break;
			case 5:
				$this->setFeedbackWeightage($value);
				break;
			case 6:
				$this->setCreatedAt($value);
				break;
			case 7:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RoundPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setType($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setStatus($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPrecededByRoundId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setFeedbackWeightage($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(RoundPeer::DATABASE_NAME);

		if ($this->isColumnModified(RoundPeer::ID)) $criteria->add(RoundPeer::ID, $this->id);
		if ($this->isColumnModified(RoundPeer::NAME)) $criteria->add(RoundPeer::NAME, $this->name);
		if ($this->isColumnModified(RoundPeer::TYPE)) $criteria->add(RoundPeer::TYPE, $this->type);
		if ($this->isColumnModified(RoundPeer::STATUS)) $criteria->add(RoundPeer::STATUS, $this->status);
		if ($this->isColumnModified(RoundPeer::PRECEDED_BY_ROUND_ID)) $criteria->add(RoundPeer::PRECEDED_BY_ROUND_ID, $this->preceded_by_round_id);
		if ($this->isColumnModified(RoundPeer::FEEDBACK_WEIGHTAGE)) $criteria->add(RoundPeer::FEEDBACK_WEIGHTAGE, $this->feedback_weightage);
		if ($this->isColumnModified(RoundPeer::CREATED_AT)) $criteria->add(RoundPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(RoundPeer::UPDATED_AT)) $criteria->add(RoundPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(RoundPeer::DATABASE_NAME);

		$criteria->add(RoundPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setType($this->type);

		$copyObj->setStatus($this->status);

		$copyObj->setPrecededByRoundId($this->preceded_by_round_id);

		$copyObj->setFeedbackWeightage($this->feedback_weightage);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getRoundsRelatedByPrecededByRoundId() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addRoundRelatedByPrecededByRoundId($relObj->copy($deepCopy));
			}

			foreach($this->getDebates() as $relObj) {
				$copyObj->addDebate($relObj->copy($deepCopy));
			}

			foreach($this->getTraineeAllocations() as $relObj) {
				$copyObj->addTraineeAllocation($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new RoundPeer();
		}
		return self::$peer;
	}

	
	public function setRoundRelatedByPrecededByRoundId($v)
	{


		if ($v === null) {
			$this->setPrecededByRoundId(NULL);
		} else {
			$this->setPrecededByRoundId($v->getId());
		}


		$this->aRoundRelatedByPrecededByRoundId = $v;
	}


	
	public function getRoundRelatedByPrecededByRoundId($con = null)
	{
		if ($this->aRoundRelatedByPrecededByRoundId === null && ($this->preceded_by_round_id !== null)) {
						include_once 'lib/model/om/BaseRoundPeer.php';

			$this->aRoundRelatedByPrecededByRoundId = RoundPeer::retrieveByPK($this->preceded_by_round_id, $con);

			
		}
		return $this->aRoundRelatedByPrecededByRoundId;
	}

	
	public function initRoundsRelatedByPrecededByRoundId()
	{
		if ($this->collRoundsRelatedByPrecededByRoundId === null) {
			$this->collRoundsRelatedByPrecededByRoundId = array();
		}
	}

	
	public function getRoundsRelatedByPrecededByRoundId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRoundPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRoundsRelatedByPrecededByRoundId === null) {
			if ($this->isNew()) {
			   $this->collRoundsRelatedByPrecededByRoundId = array();
			} else {

				$criteria->add(RoundPeer::PRECEDED_BY_ROUND_ID, $this->getId());

				RoundPeer::addSelectColumns($criteria);
				$this->collRoundsRelatedByPrecededByRoundId = RoundPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(RoundPeer::PRECEDED_BY_ROUND_ID, $this->getId());

				RoundPeer::addSelectColumns($criteria);
				if (!isset($this->lastRoundRelatedByPrecededByRoundIdCriteria) || !$this->lastRoundRelatedByPrecededByRoundIdCriteria->equals($criteria)) {
					$this->collRoundsRelatedByPrecededByRoundId = RoundPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRoundRelatedByPrecededByRoundIdCriteria = $criteria;
		return $this->collRoundsRelatedByPrecededByRoundId;
	}

	
	public function countRoundsRelatedByPrecededByRoundId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseRoundPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RoundPeer::PRECEDED_BY_ROUND_ID, $this->getId());

		return RoundPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addRoundRelatedByPrecededByRoundId(Round $l)
	{
		$this->collRoundsRelatedByPrecededByRoundId[] = $l;
		$l->setRoundRelatedByPrecededByRoundId($this);
	}

	
	public function initDebates()
	{
		if ($this->collDebates === null) {
			$this->collDebates = array();
		}
	}

	
	public function getDebates($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseDebatePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDebates === null) {
			if ($this->isNew()) {
			   $this->collDebates = array();
			} else {

				$criteria->add(DebatePeer::ROUND_ID, $this->getId());

				DebatePeer::addSelectColumns($criteria);
				$this->collDebates = DebatePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DebatePeer::ROUND_ID, $this->getId());

				DebatePeer::addSelectColumns($criteria);
				if (!isset($this->lastDebateCriteria) || !$this->lastDebateCriteria->equals($criteria)) {
					$this->collDebates = DebatePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDebateCriteria = $criteria;
		return $this->collDebates;
	}

	
	public function countDebates($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseDebatePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DebatePeer::ROUND_ID, $this->getId());

		return DebatePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addDebate(Debate $l)
	{
		$this->collDebates[] = $l;
		$l->setRound($this);
	}


	
	public function getDebatesJoinVenue($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseDebatePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDebates === null) {
			if ($this->isNew()) {
				$this->collDebates = array();
			} else {

				$criteria->add(DebatePeer::ROUND_ID, $this->getId());

				$this->collDebates = DebatePeer::doSelectJoinVenue($criteria, $con);
			}
		} else {
									
			$criteria->add(DebatePeer::ROUND_ID, $this->getId());

			if (!isset($this->lastDebateCriteria) || !$this->lastDebateCriteria->equals($criteria)) {
				$this->collDebates = DebatePeer::doSelectJoinVenue($criteria, $con);
			}
		}
		$this->lastDebateCriteria = $criteria;

		return $this->collDebates;
	}

	
	public function initTraineeAllocations()
	{
		if ($this->collTraineeAllocations === null) {
			$this->collTraineeAllocations = array();
		}
	}

	
	public function getTraineeAllocations($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTraineeAllocations === null) {
			if ($this->isNew()) {
			   $this->collTraineeAllocations = array();
			} else {

				$criteria->add(TraineeAllocationPeer::ROUND_ID, $this->getId());

				TraineeAllocationPeer::addSelectColumns($criteria);
				$this->collTraineeAllocations = TraineeAllocationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TraineeAllocationPeer::ROUND_ID, $this->getId());

				TraineeAllocationPeer::addSelectColumns($criteria);
				if (!isset($this->lastTraineeAllocationCriteria) || !$this->lastTraineeAllocationCriteria->equals($criteria)) {
					$this->collTraineeAllocations = TraineeAllocationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTraineeAllocationCriteria = $criteria;
		return $this->collTraineeAllocations;
	}

	
	public function countTraineeAllocations($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TraineeAllocationPeer::ROUND_ID, $this->getId());

		return TraineeAllocationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTraineeAllocation(TraineeAllocation $l)
	{
		$this->collTraineeAllocations[] = $l;
		$l->setRound($this);
	}


	
	public function getTraineeAllocationsJoinAdjudicatorRelatedByTraineeId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTraineeAllocations === null) {
			if ($this->isNew()) {
				$this->collTraineeAllocations = array();
			} else {

				$criteria->add(TraineeAllocationPeer::ROUND_ID, $this->getId());

				$this->collTraineeAllocations = TraineeAllocationPeer::doSelectJoinAdjudicatorRelatedByTraineeId($criteria, $con);
			}
		} else {
									
			$criteria->add(TraineeAllocationPeer::ROUND_ID, $this->getId());

			if (!isset($this->lastTraineeAllocationCriteria) || !$this->lastTraineeAllocationCriteria->equals($criteria)) {
				$this->collTraineeAllocations = TraineeAllocationPeer::doSelectJoinAdjudicatorRelatedByTraineeId($criteria, $con);
			}
		}
		$this->lastTraineeAllocationCriteria = $criteria;

		return $this->collTraineeAllocations;
	}


	
	public function getTraineeAllocationsJoinAdjudicatorRelatedByChairId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTraineeAllocations === null) {
			if ($this->isNew()) {
				$this->collTraineeAllocations = array();
			} else {

				$criteria->add(TraineeAllocationPeer::ROUND_ID, $this->getId());

				$this->collTraineeAllocations = TraineeAllocationPeer::doSelectJoinAdjudicatorRelatedByChairId($criteria, $con);
			}
		} else {
									
			$criteria->add(TraineeAllocationPeer::ROUND_ID, $this->getId());

			if (!isset($this->lastTraineeAllocationCriteria) || !$this->lastTraineeAllocationCriteria->equals($criteria)) {
				$this->collTraineeAllocations = TraineeAllocationPeer::doSelectJoinAdjudicatorRelatedByChairId($criteria, $con);
			}
		}
		$this->lastTraineeAllocationCriteria = $criteria;

		return $this->collTraineeAllocations;
	}

} 