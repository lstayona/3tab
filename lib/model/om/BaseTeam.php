<?php


abstract class BaseTeam extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $institution_id;


	
	protected $swing = false;


	
	protected $active = true;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aInstitution;

	
	protected $collDebaters;

	
	protected $lastDebaterCriteria = null;

	
	protected $collDebateTeamXrefs;

	
	protected $lastDebateTeamXrefCriteria = null;

	
	protected $collTeamScores;

	
	protected $lastTeamScoreCriteria = null;

	
	protected $collAdjudicatorConflicts;

	
	protected $lastAdjudicatorConflictCriteria = null;

	
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

	
	public function getInstitutionId()
	{

		return $this->institution_id;
	}

	
	public function getSwing()
	{

		return $this->swing;
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
			$this->modifiedColumns[] = TeamPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = TeamPeer::NAME;
		}

	} 
	
	public function setInstitutionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->institution_id !== $v) {
			$this->institution_id = $v;
			$this->modifiedColumns[] = TeamPeer::INSTITUTION_ID;
		}

		if ($this->aInstitution !== null && $this->aInstitution->getId() !== $v) {
			$this->aInstitution = null;
		}

	} 
	
	public function setSwing($v)
	{

		if ($this->swing !== $v || $v === false) {
			$this->swing = $v;
			$this->modifiedColumns[] = TeamPeer::SWING;
		}

	} 
	
	public function setActive($v)
	{

		if ($this->active !== $v || $v === true) {
			$this->active = $v;
			$this->modifiedColumns[] = TeamPeer::ACTIVE;
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
			$this->modifiedColumns[] = TeamPeer::CREATED_AT;
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
			$this->modifiedColumns[] = TeamPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->institution_id = $rs->getInt($startcol + 2);

			$this->swing = $rs->getBoolean($startcol + 3);

			$this->active = $rs->getBoolean($startcol + 4);

			$this->created_at = $rs->getTimestamp($startcol + 5, null);

			$this->updated_at = $rs->getTimestamp($startcol + 6, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Team object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TeamPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TeamPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(TeamPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(TeamPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TeamPeer::DATABASE_NAME);
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
					$pk = TeamPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TeamPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collDebaters !== null) {
				foreach($this->collDebaters as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDebateTeamXrefs !== null) {
				foreach($this->collDebateTeamXrefs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTeamScores !== null) {
				foreach($this->collTeamScores as $referrerFK) {
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


			if (($retval = TeamPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDebaters !== null) {
					foreach($this->collDebaters as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDebateTeamXrefs !== null) {
					foreach($this->collDebateTeamXrefs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTeamScores !== null) {
					foreach($this->collTeamScores as $referrerFK) {
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


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TeamPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getInstitutionId();
				break;
			case 3:
				return $this->getSwing();
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
		$keys = TeamPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getInstitutionId(),
			$keys[3] => $this->getSwing(),
			$keys[4] => $this->getActive(),
			$keys[5] => $this->getCreatedAt(),
			$keys[6] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TeamPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setInstitutionId($value);
				break;
			case 3:
				$this->setSwing($value);
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
		$keys = TeamPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setInstitutionId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSwing($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setActive($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TeamPeer::DATABASE_NAME);

		if ($this->isColumnModified(TeamPeer::ID)) $criteria->add(TeamPeer::ID, $this->id);
		if ($this->isColumnModified(TeamPeer::NAME)) $criteria->add(TeamPeer::NAME, $this->name);
		if ($this->isColumnModified(TeamPeer::INSTITUTION_ID)) $criteria->add(TeamPeer::INSTITUTION_ID, $this->institution_id);
		if ($this->isColumnModified(TeamPeer::SWING)) $criteria->add(TeamPeer::SWING, $this->swing);
		if ($this->isColumnModified(TeamPeer::ACTIVE)) $criteria->add(TeamPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(TeamPeer::CREATED_AT)) $criteria->add(TeamPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(TeamPeer::UPDATED_AT)) $criteria->add(TeamPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TeamPeer::DATABASE_NAME);

		$criteria->add(TeamPeer::ID, $this->id);

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

		$copyObj->setInstitutionId($this->institution_id);

		$copyObj->setSwing($this->swing);

		$copyObj->setActive($this->active);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getDebaters() as $relObj) {
				$copyObj->addDebater($relObj->copy($deepCopy));
			}

			foreach($this->getDebateTeamXrefs() as $relObj) {
				$copyObj->addDebateTeamXref($relObj->copy($deepCopy));
			}

			foreach($this->getTeamScores() as $relObj) {
				$copyObj->addTeamScore($relObj->copy($deepCopy));
			}

			foreach($this->getAdjudicatorConflicts() as $relObj) {
				$copyObj->addAdjudicatorConflict($relObj->copy($deepCopy));
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
			self::$peer = new TeamPeer();
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

	
	public function initDebaters()
	{
		if ($this->collDebaters === null) {
			$this->collDebaters = array();
		}
	}

	
	public function getDebaters($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseDebaterPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDebaters === null) {
			if ($this->isNew()) {
			   $this->collDebaters = array();
			} else {

				$criteria->add(DebaterPeer::TEAM_ID, $this->getId());

				DebaterPeer::addSelectColumns($criteria);
				$this->collDebaters = DebaterPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DebaterPeer::TEAM_ID, $this->getId());

				DebaterPeer::addSelectColumns($criteria);
				if (!isset($this->lastDebaterCriteria) || !$this->lastDebaterCriteria->equals($criteria)) {
					$this->collDebaters = DebaterPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDebaterCriteria = $criteria;
		return $this->collDebaters;
	}

	
	public function countDebaters($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseDebaterPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DebaterPeer::TEAM_ID, $this->getId());

		return DebaterPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addDebater(Debater $l)
	{
		$this->collDebaters[] = $l;
		$l->setTeam($this);
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

				$criteria->add(DebateTeamXrefPeer::TEAM_ID, $this->getId());

				DebateTeamXrefPeer::addSelectColumns($criteria);
				$this->collDebateTeamXrefs = DebateTeamXrefPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DebateTeamXrefPeer::TEAM_ID, $this->getId());

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

		$criteria->add(DebateTeamXrefPeer::TEAM_ID, $this->getId());

		return DebateTeamXrefPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addDebateTeamXref(DebateTeamXref $l)
	{
		$this->collDebateTeamXrefs[] = $l;
		$l->setTeam($this);
	}


	
	public function getDebateTeamXrefsJoinDebate($criteria = null, $con = null)
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

				$criteria->add(DebateTeamXrefPeer::TEAM_ID, $this->getId());

				$this->collDebateTeamXrefs = DebateTeamXrefPeer::doSelectJoinDebate($criteria, $con);
			}
		} else {
									
			$criteria->add(DebateTeamXrefPeer::TEAM_ID, $this->getId());

			if (!isset($this->lastDebateTeamXrefCriteria) || !$this->lastDebateTeamXrefCriteria->equals($criteria)) {
				$this->collDebateTeamXrefs = DebateTeamXrefPeer::doSelectJoinDebate($criteria, $con);
			}
		}
		$this->lastDebateTeamXrefCriteria = $criteria;

		return $this->collDebateTeamXrefs;
	}

	
	public function initTeamScores()
	{
		if ($this->collTeamScores === null) {
			$this->collTeamScores = array();
		}
	}

	
	public function getTeamScores($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTeamScorePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTeamScores === null) {
			if ($this->isNew()) {
			   $this->collTeamScores = array();
			} else {

				$criteria->add(TeamScorePeer::TEAM_ID, $this->getId());

				TeamScorePeer::addSelectColumns($criteria);
				$this->collTeamScores = TeamScorePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TeamScorePeer::TEAM_ID, $this->getId());

				TeamScorePeer::addSelectColumns($criteria);
				if (!isset($this->lastTeamScoreCriteria) || !$this->lastTeamScoreCriteria->equals($criteria)) {
					$this->collTeamScores = TeamScorePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTeamScoreCriteria = $criteria;
		return $this->collTeamScores;
	}

	
	public function countTeamScores($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseTeamScorePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TeamScorePeer::TEAM_ID, $this->getId());

		return TeamScorePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTeamScore(TeamScore $l)
	{
		$this->collTeamScores[] = $l;
		$l->setTeam($this);
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

				$criteria->add(AdjudicatorConflictPeer::TEAM_ID, $this->getId());

				AdjudicatorConflictPeer::addSelectColumns($criteria);
				$this->collAdjudicatorConflicts = AdjudicatorConflictPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AdjudicatorConflictPeer::TEAM_ID, $this->getId());

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

		$criteria->add(AdjudicatorConflictPeer::TEAM_ID, $this->getId());

		return AdjudicatorConflictPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addAdjudicatorConflict(AdjudicatorConflict $l)
	{
		$this->collAdjudicatorConflicts[] = $l;
		$l->setTeam($this);
	}


	
	public function getAdjudicatorConflictsJoinAdjudicator($criteria = null, $con = null)
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

				$criteria->add(AdjudicatorConflictPeer::TEAM_ID, $this->getId());

				$this->collAdjudicatorConflicts = AdjudicatorConflictPeer::doSelectJoinAdjudicator($criteria, $con);
			}
		} else {
									
			$criteria->add(AdjudicatorConflictPeer::TEAM_ID, $this->getId());

			if (!isset($this->lastAdjudicatorConflictCriteria) || !$this->lastAdjudicatorConflictCriteria->equals($criteria)) {
				$this->collAdjudicatorConflicts = AdjudicatorConflictPeer::doSelectJoinAdjudicator($criteria, $con);
			}
		}
		$this->lastAdjudicatorConflictCriteria = $criteria;

		return $this->collAdjudicatorConflicts;
	}

} 