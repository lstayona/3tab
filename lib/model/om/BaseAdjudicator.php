<?php


abstract class BaseAdjudicator extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $test_score;


	
	protected $institution_id;


	
	protected $active = true;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aInstitution;

	
	protected $collAdjudicatorAllocations;

	
	protected $lastAdjudicatorAllocationCriteria = null;

	
	protected $collTraineeAllocationsRelatedByTraineeId;

	
	protected $lastTraineeAllocationRelatedByTraineeIdCriteria = null;

	
	protected $collTraineeAllocationsRelatedByChairId;

	
	protected $lastTraineeAllocationRelatedByChairIdCriteria = null;

	
	protected $collAdjudicatorFeedbackSheets;

	
	protected $lastAdjudicatorFeedbackSheetCriteria = null;

	
	protected $collAdjudicatorConflicts;

	
	protected $lastAdjudicatorConflictCriteria = null;

	
	protected $collAdjudicatorCheckins;

	
	protected $lastAdjudicatorCheckinCriteria = null;

	
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

	
	public function getTestScore()
	{

		return $this->test_score;
	}

	
	public function getInstitutionId()
	{

		return $this->institution_id;
	}

	
	public function getActive()
	{

		return $this->active;
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
			$this->modifiedColumns[] = AdjudicatorPeer::ID;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = AdjudicatorPeer::NAME;
		}

	} 
	
	public function setTestScore($v)
	{

		if ($this->test_score !== $v) {
			$this->test_score = $v;
			$this->modifiedColumns[] = AdjudicatorPeer::TEST_SCORE;
		}

	} 
	
	public function setInstitutionId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->institution_id !== $v) {
			$this->institution_id = $v;
			$this->modifiedColumns[] = AdjudicatorPeer::INSTITUTION_ID;
		}

		if ($this->aInstitution !== null && $this->aInstitution->getId() !== $v) {
			$this->aInstitution = null;
		}

	} 
	
	public function setActive($v)
	{

		if ($this->active !== $v || $v === true) {
			$this->active = $v;
			$this->modifiedColumns[] = AdjudicatorPeer::ACTIVE;
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
			$this->modifiedColumns[] = AdjudicatorPeer::CREATED_AT;
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
			$this->modifiedColumns[] = AdjudicatorPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->test_score = $rs->getFloat($startcol + 2);

			$this->institution_id = $rs->getInt($startcol + 3);

			$this->active = $rs->getBoolean($startcol + 4);

			$this->created_at = $rs->getTimestamp($startcol + 5, null);

			$this->updated_at = $rs->getTimestamp($startcol + 6, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Adjudicator object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AdjudicatorPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			AdjudicatorPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(AdjudicatorPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(AdjudicatorPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AdjudicatorPeer::DATABASE_NAME);
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


												
			if ($this->aInstitution !== null) {
				if ($this->aInstitution->isModified()) {
					$affectedRows += $this->aInstitution->save($con);
				}
				$this->setInstitution($this->aInstitution);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AdjudicatorPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += AdjudicatorPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collAdjudicatorAllocations !== null) {
				foreach($this->collAdjudicatorAllocations as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTraineeAllocationsRelatedByTraineeId !== null) {
				foreach($this->collTraineeAllocationsRelatedByTraineeId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTraineeAllocationsRelatedByChairId !== null) {
				foreach($this->collTraineeAllocationsRelatedByChairId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAdjudicatorFeedbackSheets !== null) {
				foreach($this->collAdjudicatorFeedbackSheets as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAdjudicatorConflicts !== null) {
				foreach($this->collAdjudicatorConflicts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAdjudicatorCheckins !== null) {
				foreach($this->collAdjudicatorCheckins as $referrerFK) {
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


												
			if ($this->aInstitution !== null) {
				if (!$this->aInstitution->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aInstitution->getValidationFailures());
				}
			}


			if (($retval = AdjudicatorPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collAdjudicatorAllocations !== null) {
					foreach($this->collAdjudicatorAllocations as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTraineeAllocationsRelatedByTraineeId !== null) {
					foreach($this->collTraineeAllocationsRelatedByTraineeId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTraineeAllocationsRelatedByChairId !== null) {
					foreach($this->collTraineeAllocationsRelatedByChairId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAdjudicatorFeedbackSheets !== null) {
					foreach($this->collAdjudicatorFeedbackSheets as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAdjudicatorConflicts !== null) {
					foreach($this->collAdjudicatorConflicts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAdjudicatorCheckins !== null) {
					foreach($this->collAdjudicatorCheckins as $referrerFK) {
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
		$pos = AdjudicatorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getTestScore();
				break;
			case 3:
				return $this->getInstitutionId();
				break;
			case 4:
				return $this->getActive();
				break;
			case 5:
				return $this->getCreatedAt();
				break;
			case 6:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = AdjudicatorPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getTestScore(),
			$keys[3] => $this->getInstitutionId(),
			$keys[4] => $this->getActive(),
			$keys[5] => $this->getCreatedAt(),
			$keys[6] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = AdjudicatorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setTestScore($value);
				break;
			case 3:
				$this->setInstitutionId($value);
				break;
			case 4:
				$this->setActive($value);
				break;
			case 5:
				$this->setCreatedAt($value);
				break;
			case 6:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = AdjudicatorPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTestScore($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setInstitutionId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setActive($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(AdjudicatorPeer::DATABASE_NAME);

		if ($this->isColumnModified(AdjudicatorPeer::ID)) $criteria->add(AdjudicatorPeer::ID, $this->id);
		if ($this->isColumnModified(AdjudicatorPeer::NAME)) $criteria->add(AdjudicatorPeer::NAME, $this->name);
		if ($this->isColumnModified(AdjudicatorPeer::TEST_SCORE)) $criteria->add(AdjudicatorPeer::TEST_SCORE, $this->test_score);
		if ($this->isColumnModified(AdjudicatorPeer::INSTITUTION_ID)) $criteria->add(AdjudicatorPeer::INSTITUTION_ID, $this->institution_id);
		if ($this->isColumnModified(AdjudicatorPeer::ACTIVE)) $criteria->add(AdjudicatorPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(AdjudicatorPeer::CREATED_AT)) $criteria->add(AdjudicatorPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(AdjudicatorPeer::UPDATED_AT)) $criteria->add(AdjudicatorPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(AdjudicatorPeer::DATABASE_NAME);

		$criteria->add(AdjudicatorPeer::ID, $this->id);

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

		$copyObj->setTestScore($this->test_score);

		$copyObj->setInstitutionId($this->institution_id);

		$copyObj->setActive($this->active);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getAdjudicatorAllocations() as $relObj) {
				$copyObj->addAdjudicatorAllocation($relObj->copy($deepCopy));
			}

			foreach($this->getTraineeAllocationsRelatedByTraineeId() as $relObj) {
				$copyObj->addTraineeAllocationRelatedByTraineeId($relObj->copy($deepCopy));
			}

			foreach($this->getTraineeAllocationsRelatedByChairId() as $relObj) {
				$copyObj->addTraineeAllocationRelatedByChairId($relObj->copy($deepCopy));
			}

			foreach($this->getAdjudicatorFeedbackSheets() as $relObj) {
				$copyObj->addAdjudicatorFeedbackSheet($relObj->copy($deepCopy));
			}

			foreach($this->getAdjudicatorConflicts() as $relObj) {
				$copyObj->addAdjudicatorConflict($relObj->copy($deepCopy));
			}

			foreach($this->getAdjudicatorCheckins() as $relObj) {
				$copyObj->addAdjudicatorCheckin($relObj->copy($deepCopy));
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
			self::$peer = new AdjudicatorPeer();
		}
		return self::$peer;
	}

	
	public function setInstitution($v)
	{


		if ($v === null) {
			$this->setInstitutionId(NULL);
		} else {
			$this->setInstitutionId($v->getId());
		}


		$this->aInstitution = $v;
	}


	
	public function getInstitution($con = null)
	{
		if ($this->aInstitution === null && ($this->institution_id !== null)) {
						include_once 'lib/model/om/BaseInstitutionPeer.php';

			$this->aInstitution = InstitutionPeer::retrieveByPK($this->institution_id, $con);

			
		}
		return $this->aInstitution;
	}

	
	public function initAdjudicatorAllocations()
	{
		if ($this->collAdjudicatorAllocations === null) {
			$this->collAdjudicatorAllocations = array();
		}
	}

	
	public function getAdjudicatorAllocations($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdjudicatorAllocations === null) {
			if ($this->isNew()) {
			   $this->collAdjudicatorAllocations = array();
			} else {

				$criteria->add(AdjudicatorAllocationPeer::ADJUDICATOR_ID, $this->getId());

				AdjudicatorAllocationPeer::addSelectColumns($criteria);
				$this->collAdjudicatorAllocations = AdjudicatorAllocationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AdjudicatorAllocationPeer::ADJUDICATOR_ID, $this->getId());

				AdjudicatorAllocationPeer::addSelectColumns($criteria);
				if (!isset($this->lastAdjudicatorAllocationCriteria) || !$this->lastAdjudicatorAllocationCriteria->equals($criteria)) {
					$this->collAdjudicatorAllocations = AdjudicatorAllocationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAdjudicatorAllocationCriteria = $criteria;
		return $this->collAdjudicatorAllocations;
	}

	
	public function countAdjudicatorAllocations($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AdjudicatorAllocationPeer::ADJUDICATOR_ID, $this->getId());

		return AdjudicatorAllocationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addAdjudicatorAllocation(AdjudicatorAllocation $l)
	{
		$this->collAdjudicatorAllocations[] = $l;
		$l->setAdjudicator($this);
	}


	
	public function getAdjudicatorAllocationsJoinDebate($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdjudicatorAllocations === null) {
			if ($this->isNew()) {
				$this->collAdjudicatorAllocations = array();
			} else {

				$criteria->add(AdjudicatorAllocationPeer::ADJUDICATOR_ID, $this->getId());

				$this->collAdjudicatorAllocations = AdjudicatorAllocationPeer::doSelectJoinDebate($criteria, $con);
			}
		} else {
									
			$criteria->add(AdjudicatorAllocationPeer::ADJUDICATOR_ID, $this->getId());

			if (!isset($this->lastAdjudicatorAllocationCriteria) || !$this->lastAdjudicatorAllocationCriteria->equals($criteria)) {
				$this->collAdjudicatorAllocations = AdjudicatorAllocationPeer::doSelectJoinDebate($criteria, $con);
			}
		}
		$this->lastAdjudicatorAllocationCriteria = $criteria;

		return $this->collAdjudicatorAllocations;
	}

	
	public function initTraineeAllocationsRelatedByTraineeId()
	{
		if ($this->collTraineeAllocationsRelatedByTraineeId === null) {
			$this->collTraineeAllocationsRelatedByTraineeId = array();
		}
	}

	
	public function getTraineeAllocationsRelatedByTraineeId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTraineeAllocationsRelatedByTraineeId === null) {
			if ($this->isNew()) {
			   $this->collTraineeAllocationsRelatedByTraineeId = array();
			} else {

				$criteria->add(TraineeAllocationPeer::TRAINEE_ID, $this->getId());

				TraineeAllocationPeer::addSelectColumns($criteria);
				$this->collTraineeAllocationsRelatedByTraineeId = TraineeAllocationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TraineeAllocationPeer::TRAINEE_ID, $this->getId());

				TraineeAllocationPeer::addSelectColumns($criteria);
				if (!isset($this->lastTraineeAllocationRelatedByTraineeIdCriteria) || !$this->lastTraineeAllocationRelatedByTraineeIdCriteria->equals($criteria)) {
					$this->collTraineeAllocationsRelatedByTraineeId = TraineeAllocationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTraineeAllocationRelatedByTraineeIdCriteria = $criteria;
		return $this->collTraineeAllocationsRelatedByTraineeId;
	}

	
	public function countTraineeAllocationsRelatedByTraineeId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TraineeAllocationPeer::TRAINEE_ID, $this->getId());

		return TraineeAllocationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTraineeAllocationRelatedByTraineeId(TraineeAllocation $l)
	{
		$this->collTraineeAllocationsRelatedByTraineeId[] = $l;
		$l->setAdjudicatorRelatedByTraineeId($this);
	}


	
	public function getTraineeAllocationsRelatedByTraineeIdJoinRound($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTraineeAllocationsRelatedByTraineeId === null) {
			if ($this->isNew()) {
				$this->collTraineeAllocationsRelatedByTraineeId = array();
			} else {

				$criteria->add(TraineeAllocationPeer::TRAINEE_ID, $this->getId());

				$this->collTraineeAllocationsRelatedByTraineeId = TraineeAllocationPeer::doSelectJoinRound($criteria, $con);
			}
		} else {
									
			$criteria->add(TraineeAllocationPeer::TRAINEE_ID, $this->getId());

			if (!isset($this->lastTraineeAllocationRelatedByTraineeIdCriteria) || !$this->lastTraineeAllocationRelatedByTraineeIdCriteria->equals($criteria)) {
				$this->collTraineeAllocationsRelatedByTraineeId = TraineeAllocationPeer::doSelectJoinRound($criteria, $con);
			}
		}
		$this->lastTraineeAllocationRelatedByTraineeIdCriteria = $criteria;

		return $this->collTraineeAllocationsRelatedByTraineeId;
	}

	
	public function initTraineeAllocationsRelatedByChairId()
	{
		if ($this->collTraineeAllocationsRelatedByChairId === null) {
			$this->collTraineeAllocationsRelatedByChairId = array();
		}
	}

	
	public function getTraineeAllocationsRelatedByChairId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTraineeAllocationsRelatedByChairId === null) {
			if ($this->isNew()) {
			   $this->collTraineeAllocationsRelatedByChairId = array();
			} else {

				$criteria->add(TraineeAllocationPeer::CHAIR_ID, $this->getId());

				TraineeAllocationPeer::addSelectColumns($criteria);
				$this->collTraineeAllocationsRelatedByChairId = TraineeAllocationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TraineeAllocationPeer::CHAIR_ID, $this->getId());

				TraineeAllocationPeer::addSelectColumns($criteria);
				if (!isset($this->lastTraineeAllocationRelatedByChairIdCriteria) || !$this->lastTraineeAllocationRelatedByChairIdCriteria->equals($criteria)) {
					$this->collTraineeAllocationsRelatedByChairId = TraineeAllocationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTraineeAllocationRelatedByChairIdCriteria = $criteria;
		return $this->collTraineeAllocationsRelatedByChairId;
	}

	
	public function countTraineeAllocationsRelatedByChairId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TraineeAllocationPeer::CHAIR_ID, $this->getId());

		return TraineeAllocationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTraineeAllocationRelatedByChairId(TraineeAllocation $l)
	{
		$this->collTraineeAllocationsRelatedByChairId[] = $l;
		$l->setAdjudicatorRelatedByChairId($this);
	}


	
	public function getTraineeAllocationsRelatedByChairIdJoinRound($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTraineeAllocationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTraineeAllocationsRelatedByChairId === null) {
			if ($this->isNew()) {
				$this->collTraineeAllocationsRelatedByChairId = array();
			} else {

				$criteria->add(TraineeAllocationPeer::CHAIR_ID, $this->getId());

				$this->collTraineeAllocationsRelatedByChairId = TraineeAllocationPeer::doSelectJoinRound($criteria, $con);
			}
		} else {
									
			$criteria->add(TraineeAllocationPeer::CHAIR_ID, $this->getId());

			if (!isset($this->lastTraineeAllocationRelatedByChairIdCriteria) || !$this->lastTraineeAllocationRelatedByChairIdCriteria->equals($criteria)) {
				$this->collTraineeAllocationsRelatedByChairId = TraineeAllocationPeer::doSelectJoinRound($criteria, $con);
			}
		}
		$this->lastTraineeAllocationRelatedByChairIdCriteria = $criteria;

		return $this->collTraineeAllocationsRelatedByChairId;
	}

	
	public function initAdjudicatorFeedbackSheets()
	{
		if ($this->collAdjudicatorFeedbackSheets === null) {
			$this->collAdjudicatorFeedbackSheets = array();
		}
	}

	
	public function getAdjudicatorFeedbackSheets($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorFeedbackSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdjudicatorFeedbackSheets === null) {
			if ($this->isNew()) {
			   $this->collAdjudicatorFeedbackSheets = array();
			} else {

				$criteria->add(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, $this->getId());

				AdjudicatorFeedbackSheetPeer::addSelectColumns($criteria);
				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, $this->getId());

				AdjudicatorFeedbackSheetPeer::addSelectColumns($criteria);
				if (!isset($this->lastAdjudicatorFeedbackSheetCriteria) || !$this->lastAdjudicatorFeedbackSheetCriteria->equals($criteria)) {
					$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAdjudicatorFeedbackSheetCriteria = $criteria;
		return $this->collAdjudicatorFeedbackSheets;
	}

	
	public function countAdjudicatorFeedbackSheets($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorFeedbackSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, $this->getId());

		return AdjudicatorFeedbackSheetPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addAdjudicatorFeedbackSheet(AdjudicatorFeedbackSheet $l)
	{
		$this->collAdjudicatorFeedbackSheets[] = $l;
		$l->setAdjudicator($this);
	}


	
	public function getAdjudicatorFeedbackSheetsJoinAdjudicatorAllocation($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorFeedbackSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdjudicatorFeedbackSheets === null) {
			if ($this->isNew()) {
				$this->collAdjudicatorFeedbackSheets = array();
			} else {

				$criteria->add(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, $this->getId());

				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		} else {
									
			$criteria->add(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, $this->getId());

			if (!isset($this->lastAdjudicatorFeedbackSheetCriteria) || !$this->lastAdjudicatorFeedbackSheetCriteria->equals($criteria)) {
				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		}
		$this->lastAdjudicatorFeedbackSheetCriteria = $criteria;

		return $this->collAdjudicatorFeedbackSheets;
	}


	
	public function getAdjudicatorFeedbackSheetsJoinDebateTeamXref($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorFeedbackSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdjudicatorFeedbackSheets === null) {
			if ($this->isNew()) {
				$this->collAdjudicatorFeedbackSheets = array();
			} else {

				$criteria->add(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, $this->getId());

				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelectJoinDebateTeamXref($criteria, $con);
			}
		} else {
									
			$criteria->add(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, $this->getId());

			if (!isset($this->lastAdjudicatorFeedbackSheetCriteria) || !$this->lastAdjudicatorFeedbackSheetCriteria->equals($criteria)) {
				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelectJoinDebateTeamXref($criteria, $con);
			}
		}
		$this->lastAdjudicatorFeedbackSheetCriteria = $criteria;

		return $this->collAdjudicatorFeedbackSheets;
	}

	
	public function initAdjudicatorConflicts()
	{
		if ($this->collAdjudicatorConflicts === null) {
			$this->collAdjudicatorConflicts = array();
		}
	}

	
	public function getAdjudicatorConflicts($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorConflictPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdjudicatorConflicts === null) {
			if ($this->isNew()) {
			   $this->collAdjudicatorConflicts = array();
			} else {

				$criteria->add(AdjudicatorConflictPeer::ADJUDICATOR_ID, $this->getId());

				AdjudicatorConflictPeer::addSelectColumns($criteria);
				$this->collAdjudicatorConflicts = AdjudicatorConflictPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AdjudicatorConflictPeer::ADJUDICATOR_ID, $this->getId());

				AdjudicatorConflictPeer::addSelectColumns($criteria);
				if (!isset($this->lastAdjudicatorConflictCriteria) || !$this->lastAdjudicatorConflictCriteria->equals($criteria)) {
					$this->collAdjudicatorConflicts = AdjudicatorConflictPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAdjudicatorConflictCriteria = $criteria;
		return $this->collAdjudicatorConflicts;
	}

	
	public function countAdjudicatorConflicts($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorConflictPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AdjudicatorConflictPeer::ADJUDICATOR_ID, $this->getId());

		return AdjudicatorConflictPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addAdjudicatorConflict(AdjudicatorConflict $l)
	{
		$this->collAdjudicatorConflicts[] = $l;
		$l->setAdjudicator($this);
	}


	
	public function getAdjudicatorConflictsJoinTeam($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorConflictPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdjudicatorConflicts === null) {
			if ($this->isNew()) {
				$this->collAdjudicatorConflicts = array();
			} else {

				$criteria->add(AdjudicatorConflictPeer::ADJUDICATOR_ID, $this->getId());

				$this->collAdjudicatorConflicts = AdjudicatorConflictPeer::doSelectJoinTeam($criteria, $con);
			}
		} else {
									
			$criteria->add(AdjudicatorConflictPeer::ADJUDICATOR_ID, $this->getId());

			if (!isset($this->lastAdjudicatorConflictCriteria) || !$this->lastAdjudicatorConflictCriteria->equals($criteria)) {
				$this->collAdjudicatorConflicts = AdjudicatorConflictPeer::doSelectJoinTeam($criteria, $con);
			}
		}
		$this->lastAdjudicatorConflictCriteria = $criteria;

		return $this->collAdjudicatorConflicts;
	}

	
	public function initAdjudicatorCheckins()
	{
		if ($this->collAdjudicatorCheckins === null) {
			$this->collAdjudicatorCheckins = array();
		}
	}

	
	public function getAdjudicatorCheckins($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorCheckinPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdjudicatorCheckins === null) {
			if ($this->isNew()) {
			   $this->collAdjudicatorCheckins = array();
			} else {

				$criteria->add(AdjudicatorCheckinPeer::ADJUDICATOR_ID, $this->getId());

				AdjudicatorCheckinPeer::addSelectColumns($criteria);
				$this->collAdjudicatorCheckins = AdjudicatorCheckinPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AdjudicatorCheckinPeer::ADJUDICATOR_ID, $this->getId());

				AdjudicatorCheckinPeer::addSelectColumns($criteria);
				if (!isset($this->lastAdjudicatorCheckinCriteria) || !$this->lastAdjudicatorCheckinCriteria->equals($criteria)) {
					$this->collAdjudicatorCheckins = AdjudicatorCheckinPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAdjudicatorCheckinCriteria = $criteria;
		return $this->collAdjudicatorCheckins;
	}

	
	public function countAdjudicatorCheckins($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorCheckinPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AdjudicatorCheckinPeer::ADJUDICATOR_ID, $this->getId());

		return AdjudicatorCheckinPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addAdjudicatorCheckin(AdjudicatorCheckin $l)
	{
		$this->collAdjudicatorCheckins[] = $l;
		$l->setAdjudicator($this);
	}


	
	public function getAdjudicatorCheckinsJoinRound($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdjudicatorCheckinPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdjudicatorCheckins === null) {
			if ($this->isNew()) {
				$this->collAdjudicatorCheckins = array();
			} else {

				$criteria->add(AdjudicatorCheckinPeer::ADJUDICATOR_ID, $this->getId());

				$this->collAdjudicatorCheckins = AdjudicatorCheckinPeer::doSelectJoinRound($criteria, $con);
			}
		} else {
									
			$criteria->add(AdjudicatorCheckinPeer::ADJUDICATOR_ID, $this->getId());

			if (!isset($this->lastAdjudicatorCheckinCriteria) || !$this->lastAdjudicatorCheckinCriteria->equals($criteria)) {
				$this->collAdjudicatorCheckins = AdjudicatorCheckinPeer::doSelectJoinRound($criteria, $con);
			}
		}
		$this->lastAdjudicatorCheckinCriteria = $criteria;

		return $this->collAdjudicatorCheckins;
	}

} 