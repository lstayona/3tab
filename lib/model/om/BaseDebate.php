<?php


abstract class BaseDebate extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $round_id;


	
	protected $venue_id;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aRound;

	
	protected $aVenue;

	
	protected $collDebateTeamXrefs;

	
	protected $lastDebateTeamXrefCriteria = null;

	
	protected $collAdjudicatorAllocations;

	
	protected $lastAdjudicatorAllocationCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getRoundId()
	{

		return $this->round_id;
	}

	
	public function getVenueId()
	{

		return $this->venue_id;
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
			$this->modifiedColumns[] = DebatePeer::ID;
		}

	} 
	
	public function setRoundId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->round_id !== $v) {
			$this->round_id = $v;
			$this->modifiedColumns[] = DebatePeer::ROUND_ID;
		}

		if ($this->aRound !== null && $this->aRound->getId() !== $v) {
			$this->aRound = null;
		}

	} 
	
	public function setVenueId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->venue_id !== $v) {
			$this->venue_id = $v;
			$this->modifiedColumns[] = DebatePeer::VENUE_ID;
		}

		if ($this->aVenue !== null && $this->aVenue->getId() !== $v) {
			$this->aVenue = null;
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
			$this->modifiedColumns[] = DebatePeer::CREATED_AT;
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
			$this->modifiedColumns[] = DebatePeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->round_id = $rs->getInt($startcol + 1);

			$this->venue_id = $rs->getInt($startcol + 2);

			$this->created_at = $rs->getTimestamp($startcol + 3, null);

			$this->updated_at = $rs->getTimestamp($startcol + 4, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Debate object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DebatePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			DebatePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(DebatePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(DebatePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DebatePeer::DATABASE_NAME);
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


												
			if ($this->aRound !== null) {
				if ($this->aRound->isModified()) {
					$affectedRows += $this->aRound->save($con);
				}
				$this->setRound($this->aRound);
			}

			if ($this->aVenue !== null) {
				if ($this->aVenue->isModified()) {
					$affectedRows += $this->aVenue->save($con);
				}
				$this->setVenue($this->aVenue);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DebatePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += DebatePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collDebateTeamXrefs !== null) {
				foreach($this->collDebateTeamXrefs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAdjudicatorAllocations !== null) {
				foreach($this->collAdjudicatorAllocations as $referrerFK) {
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


												
			if ($this->aRound !== null) {
				if (!$this->aRound->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRound->getValidationFailures());
				}
			}

			if ($this->aVenue !== null) {
				if (!$this->aVenue->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aVenue->getValidationFailures());
				}
			}


			if (($retval = DebatePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDebateTeamXrefs !== null) {
					foreach($this->collDebateTeamXrefs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAdjudicatorAllocations !== null) {
					foreach($this->collAdjudicatorAllocations as $referrerFK) {
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
		$pos = DebatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getRoundId();
				break;
			case 2:
				return $this->getVenueId();
				break;
			case 3:
				return $this->getCreatedAt();
				break;
			case 4:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DebatePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getRoundId(),
			$keys[2] => $this->getVenueId(),
			$keys[3] => $this->getCreatedAt(),
			$keys[4] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DebatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setRoundId($value);
				break;
			case 2:
				$this->setVenueId($value);
				break;
			case 3:
				$this->setCreatedAt($value);
				break;
			case 4:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DebatePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setRoundId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setVenueId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUpdatedAt($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(DebatePeer::DATABASE_NAME);

		if ($this->isColumnModified(DebatePeer::ID)) $criteria->add(DebatePeer::ID, $this->id);
		if ($this->isColumnModified(DebatePeer::ROUND_ID)) $criteria->add(DebatePeer::ROUND_ID, $this->round_id);
		if ($this->isColumnModified(DebatePeer::VENUE_ID)) $criteria->add(DebatePeer::VENUE_ID, $this->venue_id);
		if ($this->isColumnModified(DebatePeer::CREATED_AT)) $criteria->add(DebatePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(DebatePeer::UPDATED_AT)) $criteria->add(DebatePeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(DebatePeer::DATABASE_NAME);

		$criteria->add(DebatePeer::ID, $this->id);

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

		$copyObj->setRoundId($this->round_id);

		$copyObj->setVenueId($this->venue_id);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getDebateTeamXrefs() as $relObj) {
				$copyObj->addDebateTeamXref($relObj->copy($deepCopy));
			}

			foreach($this->getAdjudicatorAllocations() as $relObj) {
				$copyObj->addAdjudicatorAllocation($relObj->copy($deepCopy));
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
			self::$peer = new DebatePeer();
		}
		return self::$peer;
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

	
	public function setVenue($v)
	{


		if ($v === null) {
			$this->setVenueId(NULL);
		} else {
			$this->setVenueId($v->getId());
		}


		$this->aVenue = $v;
	}


	
	public function getVenue($con = null)
	{
		if ($this->aVenue === null && ($this->venue_id !== null)) {
						include_once 'lib/model/om/BaseVenuePeer.php';

			$this->aVenue = VenuePeer::retrieveByPK($this->venue_id, $con);

			
		}
		return $this->aVenue;
	}

	
	public function initDebateTeamXrefs()
	{
		if ($this->collDebateTeamXrefs === null) {
			$this->collDebateTeamXrefs = array();
		}
	}

	
	public function getDebateTeamXrefs($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseDebateTeamXrefPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDebateTeamXrefs === null) {
			if ($this->isNew()) {
			   $this->collDebateTeamXrefs = array();
			} else {

				$criteria->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());

				DebateTeamXrefPeer::addSelectColumns($criteria);
				$this->collDebateTeamXrefs = DebateTeamXrefPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());

				DebateTeamXrefPeer::addSelectColumns($criteria);
				if (!isset($this->lastDebateTeamXrefCriteria) || !$this->lastDebateTeamXrefCriteria->equals($criteria)) {
					$this->collDebateTeamXrefs = DebateTeamXrefPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDebateTeamXrefCriteria = $criteria;
		return $this->collDebateTeamXrefs;
	}

	
	public function countDebateTeamXrefs($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseDebateTeamXrefPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());

		return DebateTeamXrefPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addDebateTeamXref(DebateTeamXref $l)
	{
		$this->collDebateTeamXrefs[] = $l;
		$l->setDebate($this);
	}


	
	public function getDebateTeamXrefsJoinTeam($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseDebateTeamXrefPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDebateTeamXrefs === null) {
			if ($this->isNew()) {
				$this->collDebateTeamXrefs = array();
			} else {

				$criteria->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());

				$this->collDebateTeamXrefs = DebateTeamXrefPeer::doSelectJoinTeam($criteria, $con);
			}
		} else {
									
			$criteria->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());

			if (!isset($this->lastDebateTeamXrefCriteria) || !$this->lastDebateTeamXrefCriteria->equals($criteria)) {
				$this->collDebateTeamXrefs = DebateTeamXrefPeer::doSelectJoinTeam($criteria, $con);
			}
		}
		$this->lastDebateTeamXrefCriteria = $criteria;

		return $this->collDebateTeamXrefs;
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

				$criteria->add(AdjudicatorAllocationPeer::DEBATE_ID, $this->getId());

				AdjudicatorAllocationPeer::addSelectColumns($criteria);
				$this->collAdjudicatorAllocations = AdjudicatorAllocationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AdjudicatorAllocationPeer::DEBATE_ID, $this->getId());

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

		$criteria->add(AdjudicatorAllocationPeer::DEBATE_ID, $this->getId());

		return AdjudicatorAllocationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addAdjudicatorAllocation(AdjudicatorAllocation $l)
	{
		$this->collAdjudicatorAllocations[] = $l;
		$l->setDebate($this);
	}


	
	public function getAdjudicatorAllocationsJoinAdjudicator($criteria = null, $con = null)
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

				$criteria->add(AdjudicatorAllocationPeer::DEBATE_ID, $this->getId());

				$this->collAdjudicatorAllocations = AdjudicatorAllocationPeer::doSelectJoinAdjudicator($criteria, $con);
			}
		} else {
									
			$criteria->add(AdjudicatorAllocationPeer::DEBATE_ID, $this->getId());

			if (!isset($this->lastAdjudicatorAllocationCriteria) || !$this->lastAdjudicatorAllocationCriteria->equals($criteria)) {
				$this->collAdjudicatorAllocations = AdjudicatorAllocationPeer::doSelectJoinAdjudicator($criteria, $con);
			}
		}
		$this->lastAdjudicatorAllocationCriteria = $criteria;

		return $this->collAdjudicatorAllocations;
	}

} 