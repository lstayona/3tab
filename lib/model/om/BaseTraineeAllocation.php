<?php


abstract class BaseTraineeAllocation extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $trainee_id;


	
	protected $chair_id;


	
	protected $round_id;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aAdjudicatorRelatedByTraineeId;

	
	protected $aAdjudicatorRelatedByChairId;

	
	protected $aRound;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTraineeId()
	{

		return $this->trainee_id;
	}

	
	public function getChairId()
	{

		return $this->chair_id;
	}

	
	public function getRoundId()
	{

		return $this->round_id;
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
			$this->modifiedColumns[] = TraineeAllocationPeer::ID;
		}

	} 
	
	public function setTraineeId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->trainee_id !== $v) {
			$this->trainee_id = $v;
			$this->modifiedColumns[] = TraineeAllocationPeer::TRAINEE_ID;
		}

		if ($this->aAdjudicatorRelatedByTraineeId !== null && $this->aAdjudicatorRelatedByTraineeId->getId() !== $v) {
			$this->aAdjudicatorRelatedByTraineeId = null;
		}

	} 
	
	public function setChairId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->chair_id !== $v) {
			$this->chair_id = $v;
			$this->modifiedColumns[] = TraineeAllocationPeer::CHAIR_ID;
		}

		if ($this->aAdjudicatorRelatedByChairId !== null && $this->aAdjudicatorRelatedByChairId->getId() !== $v) {
			$this->aAdjudicatorRelatedByChairId = null;
		}

	} 
	
	public function setRoundId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->round_id !== $v) {
			$this->round_id = $v;
			$this->modifiedColumns[] = TraineeAllocationPeer::ROUND_ID;
		}

		if ($this->aRound !== null && $this->aRound->getId() !== $v) {
			$this->aRound = null;
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
			$this->modifiedColumns[] = TraineeAllocationPeer::CREATED_AT;
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
			$this->modifiedColumns[] = TraineeAllocationPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->trainee_id = $rs->getInt($startcol + 1);

			$this->chair_id = $rs->getInt($startcol + 2);

			$this->round_id = $rs->getInt($startcol + 3);

			$this->created_at = $rs->getTimestamp($startcol + 4, null);

			$this->updated_at = $rs->getTimestamp($startcol + 5, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating TraineeAllocation object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TraineeAllocationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TraineeAllocationPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(TraineeAllocationPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(TraineeAllocationPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TraineeAllocationPeer::DATABASE_NAME);
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


												
			if ($this->aAdjudicatorRelatedByTraineeId !== null) {
				if ($this->aAdjudicatorRelatedByTraineeId->isModified()) {
					$affectedRows += $this->aAdjudicatorRelatedByTraineeId->save($con);
				}
				$this->setAdjudicatorRelatedByTraineeId($this->aAdjudicatorRelatedByTraineeId);
			}

			if ($this->aAdjudicatorRelatedByChairId !== null) {
				if ($this->aAdjudicatorRelatedByChairId->isModified()) {
					$affectedRows += $this->aAdjudicatorRelatedByChairId->save($con);
				}
				$this->setAdjudicatorRelatedByChairId($this->aAdjudicatorRelatedByChairId);
			}

			if ($this->aRound !== null) {
				if ($this->aRound->isModified()) {
					$affectedRows += $this->aRound->save($con);
				}
				$this->setRound($this->aRound);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TraineeAllocationPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TraineeAllocationPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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


												
			if ($this->aAdjudicatorRelatedByTraineeId !== null) {
				if (!$this->aAdjudicatorRelatedByTraineeId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aAdjudicatorRelatedByTraineeId->getValidationFailures());
				}
			}

			if ($this->aAdjudicatorRelatedByChairId !== null) {
				if (!$this->aAdjudicatorRelatedByChairId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aAdjudicatorRelatedByChairId->getValidationFailures());
				}
			}

			if ($this->aRound !== null) {
				if (!$this->aRound->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRound->getValidationFailures());
				}
			}


			if (($retval = TraineeAllocationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TraineeAllocationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTraineeId();
				break;
			case 2:
				return $this->getChairId();
				break;
			case 3:
				return $this->getRoundId();
				break;
			case 4:
				return $this->getCreatedAt();
				break;
			case 5:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TraineeAllocationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTraineeId(),
			$keys[2] => $this->getChairId(),
			$keys[3] => $this->getRoundId(),
			$keys[4] => $this->getCreatedAt(),
			$keys[5] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TraineeAllocationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTraineeId($value);
				break;
			case 2:
				$this->setChairId($value);
				break;
			case 3:
				$this->setRoundId($value);
				break;
			case 4:
				$this->setCreatedAt($value);
				break;
			case 5:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TraineeAllocationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTraineeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setChairId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRoundId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUpdatedAt($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TraineeAllocationPeer::DATABASE_NAME);

		if ($this->isColumnModified(TraineeAllocationPeer::ID)) $criteria->add(TraineeAllocationPeer::ID, $this->id);
		if ($this->isColumnModified(TraineeAllocationPeer::TRAINEE_ID)) $criteria->add(TraineeAllocationPeer::TRAINEE_ID, $this->trainee_id);
		if ($this->isColumnModified(TraineeAllocationPeer::CHAIR_ID)) $criteria->add(TraineeAllocationPeer::CHAIR_ID, $this->chair_id);
		if ($this->isColumnModified(TraineeAllocationPeer::ROUND_ID)) $criteria->add(TraineeAllocationPeer::ROUND_ID, $this->round_id);
		if ($this->isColumnModified(TraineeAllocationPeer::CREATED_AT)) $criteria->add(TraineeAllocationPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(TraineeAllocationPeer::UPDATED_AT)) $criteria->add(TraineeAllocationPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TraineeAllocationPeer::DATABASE_NAME);

		$criteria->add(TraineeAllocationPeer::ID, $this->id);

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

		$copyObj->setTraineeId($this->trainee_id);

		$copyObj->setChairId($this->chair_id);

		$copyObj->setRoundId($this->round_id);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


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
			self::$peer = new TraineeAllocationPeer();
		}
		return self::$peer;
	}

	
	public function setAdjudicatorRelatedByTraineeId($v)
	{


		if ($v === null) {
			$this->setTraineeId(NULL);
		} else {
			$this->setTraineeId($v->getId());
		}


		$this->aAdjudicatorRelatedByTraineeId = $v;
	}


	
	public function getAdjudicatorRelatedByTraineeId($con = null)
	{
		if ($this->aAdjudicatorRelatedByTraineeId === null && ($this->trainee_id !== null)) {
						include_once 'lib/model/om/BaseAdjudicatorPeer.php';

			$this->aAdjudicatorRelatedByTraineeId = AdjudicatorPeer::retrieveByPK($this->trainee_id, $con);

			
		}
		return $this->aAdjudicatorRelatedByTraineeId;
	}

	
	public function setAdjudicatorRelatedByChairId($v)
	{


		if ($v === null) {
			$this->setChairId(NULL);
		} else {
			$this->setChairId($v->getId());
		}


		$this->aAdjudicatorRelatedByChairId = $v;
	}


	
	public function getAdjudicatorRelatedByChairId($con = null)
	{
		if ($this->aAdjudicatorRelatedByChairId === null && ($this->chair_id !== null)) {
						include_once 'lib/model/om/BaseAdjudicatorPeer.php';

			$this->aAdjudicatorRelatedByChairId = AdjudicatorPeer::retrieveByPK($this->chair_id, $con);

			
		}
		return $this->aAdjudicatorRelatedByChairId;
	}

	
	public function setRound($v)
	{


		if ($v === null) {
			$this->setRoundId(NULL);
		} else {
			$this->setRoundId($v->getId());
		}


		$this->aRound = $v;
	}


	
	public function getRound($con = null)
	{
		if ($this->aRound === null && ($this->round_id !== null)) {
						include_once 'lib/model/om/BaseRoundPeer.php';

			$this->aRound = RoundPeer::retrieveByPK($this->round_id, $con);

			
		}
		return $this->aRound;
	}

} 