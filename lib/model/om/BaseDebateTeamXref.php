<?php


abstract class BaseDebateTeamXref extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $debate_id;


	
	protected $team_id;


	
	protected $position;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aDebate;

	
	protected $aTeam;

	
	protected $collTeamScoreSheets;

	
	protected $lastTeamScoreSheetCriteria = null;

	
	protected $collSpeakerScoreSheets;

	
	protected $lastSpeakerScoreSheetCriteria = null;

	
	protected $collAdjudicatorFeedbackSheets;

	
	protected $lastAdjudicatorFeedbackSheetCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getDebateId()
	{

		return $this->debate_id;
	}

	
	public function getTeamId()
	{

		return $this->team_id;
	}

	
	public function getPosition()
	{

		return $this->position;
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
			$this->modifiedColumns[] = DebateTeamXrefPeer::ID;
		}

	} 
	
	public function setDebateId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->debate_id !== $v) {
			$this->debate_id = $v;
			$this->modifiedColumns[] = DebateTeamXrefPeer::DEBATE_ID;
		}

		if ($this->aDebate !== null && $this->aDebate->getId() !== $v) {
			$this->aDebate = null;
		}

	} 
	
	public function setTeamId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->team_id !== $v) {
			$this->team_id = $v;
			$this->modifiedColumns[] = DebateTeamXrefPeer::TEAM_ID;
		}

		if ($this->aTeam !== null && $this->aTeam->getId() !== $v) {
			$this->aTeam = null;
		}

	} 
	
	public function setPosition($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->position !== $v) {
			$this->position = $v;
			$this->modifiedColumns[] = DebateTeamXrefPeer::POSITION;
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
			$this->modifiedColumns[] = DebateTeamXrefPeer::CREATED_AT;
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
			$this->modifiedColumns[] = DebateTeamXrefPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->debate_id = $rs->getInt($startcol + 1);

			$this->team_id = $rs->getInt($startcol + 2);

			$this->position = $rs->getInt($startcol + 3);

			$this->created_at = $rs->getTimestamp($startcol + 4, null);

			$this->updated_at = $rs->getTimestamp($startcol + 5, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating DebateTeamXref object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DebateTeamXrefPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			DebateTeamXrefPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(DebateTeamXrefPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(DebateTeamXrefPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DebateTeamXrefPeer::DATABASE_NAME);
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


												
			if ($this->aDebate !== null) {
				if ($this->aDebate->isModified()) {
					$affectedRows += $this->aDebate->save($con);
				}
				$this->setDebate($this->aDebate);
			}

			if ($this->aTeam !== null) {
				if ($this->aTeam->isModified()) {
					$affectedRows += $this->aTeam->save($con);
				}
				$this->setTeam($this->aTeam);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DebateTeamXrefPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += DebateTeamXrefPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collTeamScoreSheets !== null) {
				foreach($this->collTeamScoreSheets as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSpeakerScoreSheets !== null) {
				foreach($this->collSpeakerScoreSheets as $referrerFK) {
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


												
			if ($this->aDebate !== null) {
				if (!$this->aDebate->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDebate->getValidationFailures());
				}
			}

			if ($this->aTeam !== null) {
				if (!$this->aTeam->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTeam->getValidationFailures());
				}
			}


			if (($retval = DebateTeamXrefPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTeamScoreSheets !== null) {
					foreach($this->collTeamScoreSheets as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSpeakerScoreSheets !== null) {
					foreach($this->collSpeakerScoreSheets as $referrerFK) {
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


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DebateTeamXrefPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getDebateId();
				break;
			case 2:
				return $this->getTeamId();
				break;
			case 3:
				return $this->getPosition();
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
		$keys = DebateTeamXrefPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getDebateId(),
			$keys[2] => $this->getTeamId(),
			$keys[3] => $this->getPosition(),
			$keys[4] => $this->getCreatedAt(),
			$keys[5] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DebateTeamXrefPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setDebateId($value);
				break;
			case 2:
				$this->setTeamId($value);
				break;
			case 3:
				$this->setPosition($value);
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
		$keys = DebateTeamXrefPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDebateId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTeamId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPosition($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUpdatedAt($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(DebateTeamXrefPeer::DATABASE_NAME);

		if ($this->isColumnModified(DebateTeamXrefPeer::ID)) $criteria->add(DebateTeamXrefPeer::ID, $this->id);
		if ($this->isColumnModified(DebateTeamXrefPeer::DEBATE_ID)) $criteria->add(DebateTeamXrefPeer::DEBATE_ID, $this->debate_id);
		if ($this->isColumnModified(DebateTeamXrefPeer::TEAM_ID)) $criteria->add(DebateTeamXrefPeer::TEAM_ID, $this->team_id);
		if ($this->isColumnModified(DebateTeamXrefPeer::POSITION)) $criteria->add(DebateTeamXrefPeer::POSITION, $this->position);
		if ($this->isColumnModified(DebateTeamXrefPeer::CREATED_AT)) $criteria->add(DebateTeamXrefPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(DebateTeamXrefPeer::UPDATED_AT)) $criteria->add(DebateTeamXrefPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(DebateTeamXrefPeer::DATABASE_NAME);

		$criteria->add(DebateTeamXrefPeer::ID, $this->id);

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

		$copyObj->setDebateId($this->debate_id);

		$copyObj->setTeamId($this->team_id);

		$copyObj->setPosition($this->position);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getTeamScoreSheets() as $relObj) {
				$copyObj->addTeamScoreSheet($relObj->copy($deepCopy));
			}

			foreach($this->getSpeakerScoreSheets() as $relObj) {
				$copyObj->addSpeakerScoreSheet($relObj->copy($deepCopy));
			}

			foreach($this->getAdjudicatorFeedbackSheets() as $relObj) {
				$copyObj->addAdjudicatorFeedbackSheet($relObj->copy($deepCopy));
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
			self::$peer = new DebateTeamXrefPeer();
		}
		return self::$peer;
	}

	
	public function setDebate($v)
	{


		if ($v === null) {
			$this->setDebateId(NULL);
		} else {
			$this->setDebateId($v->getId());
		}


		$this->aDebate = $v;
	}


	
	public function getDebate($con = null)
	{
		if ($this->aDebate === null && ($this->debate_id !== null)) {
						include_once 'lib/model/om/BaseDebatePeer.php';

			$this->aDebate = DebatePeer::retrieveByPK($this->debate_id, $con);

			
		}
		return $this->aDebate;
	}

	
	public function setTeam($v)
	{


		if ($v === null) {
			$this->setTeamId(NULL);
		} else {
			$this->setTeamId($v->getId());
		}


		$this->aTeam = $v;
	}


	
	public function getTeam($con = null)
	{
		if ($this->aTeam === null && ($this->team_id !== null)) {
						include_once 'lib/model/om/BaseTeamPeer.php';

			$this->aTeam = TeamPeer::retrieveByPK($this->team_id, $con);

			
		}
		return $this->aTeam;
	}

	
	public function initTeamScoreSheets()
	{
		if ($this->collTeamScoreSheets === null) {
			$this->collTeamScoreSheets = array();
		}
	}

	
	public function getTeamScoreSheets($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTeamScoreSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTeamScoreSheets === null) {
			if ($this->isNew()) {
			   $this->collTeamScoreSheets = array();
			} else {

				$criteria->add(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				TeamScoreSheetPeer::addSelectColumns($criteria);
				$this->collTeamScoreSheets = TeamScoreSheetPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				TeamScoreSheetPeer::addSelectColumns($criteria);
				if (!isset($this->lastTeamScoreSheetCriteria) || !$this->lastTeamScoreSheetCriteria->equals($criteria)) {
					$this->collTeamScoreSheets = TeamScoreSheetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTeamScoreSheetCriteria = $criteria;
		return $this->collTeamScoreSheets;
	}

	
	public function countTeamScoreSheets($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseTeamScoreSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

		return TeamScoreSheetPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTeamScoreSheet(TeamScoreSheet $l)
	{
		$this->collTeamScoreSheets[] = $l;
		$l->setDebateTeamXref($this);
	}


	
	public function getTeamScoreSheetsJoinAdjudicatorAllocation($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTeamScoreSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTeamScoreSheets === null) {
			if ($this->isNew()) {
				$this->collTeamScoreSheets = array();
			} else {

				$criteria->add(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				$this->collTeamScoreSheets = TeamScoreSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		} else {
									
			$criteria->add(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

			if (!isset($this->lastTeamScoreSheetCriteria) || !$this->lastTeamScoreSheetCriteria->equals($criteria)) {
				$this->collTeamScoreSheets = TeamScoreSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		}
		$this->lastTeamScoreSheetCriteria = $criteria;

		return $this->collTeamScoreSheets;
	}

	
	public function initSpeakerScoreSheets()
	{
		if ($this->collSpeakerScoreSheets === null) {
			$this->collSpeakerScoreSheets = array();
		}
	}

	
	public function getSpeakerScoreSheets($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSpeakerScoreSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSpeakerScoreSheets === null) {
			if ($this->isNew()) {
			   $this->collSpeakerScoreSheets = array();
			} else {

				$criteria->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				SpeakerScoreSheetPeer::addSelectColumns($criteria);
				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				SpeakerScoreSheetPeer::addSelectColumns($criteria);
				if (!isset($this->lastSpeakerScoreSheetCriteria) || !$this->lastSpeakerScoreSheetCriteria->equals($criteria)) {
					$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSpeakerScoreSheetCriteria = $criteria;
		return $this->collSpeakerScoreSheets;
	}

	
	public function countSpeakerScoreSheets($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSpeakerScoreSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

		return SpeakerScoreSheetPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSpeakerScoreSheet(SpeakerScoreSheet $l)
	{
		$this->collSpeakerScoreSheets[] = $l;
		$l->setDebateTeamXref($this);
	}


	
	public function getSpeakerScoreSheetsJoinAdjudicatorAllocation($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSpeakerScoreSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSpeakerScoreSheets === null) {
			if ($this->isNew()) {
				$this->collSpeakerScoreSheets = array();
			} else {

				$criteria->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		} else {
									
			$criteria->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

			if (!isset($this->lastSpeakerScoreSheetCriteria) || !$this->lastSpeakerScoreSheetCriteria->equals($criteria)) {
				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		}
		$this->lastSpeakerScoreSheetCriteria = $criteria;

		return $this->collSpeakerScoreSheets;
	}


	
	public function getSpeakerScoreSheetsJoinDebater($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSpeakerScoreSheetPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSpeakerScoreSheets === null) {
			if ($this->isNew()) {
				$this->collSpeakerScoreSheets = array();
			} else {

				$criteria->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelectJoinDebater($criteria, $con);
			}
		} else {
									
			$criteria->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

			if (!isset($this->lastSpeakerScoreSheetCriteria) || !$this->lastSpeakerScoreSheetCriteria->equals($criteria)) {
				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelectJoinDebater($criteria, $con);
			}
		}
		$this->lastSpeakerScoreSheetCriteria = $criteria;

		return $this->collSpeakerScoreSheets;
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

				$criteria->add(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				AdjudicatorFeedbackSheetPeer::addSelectColumns($criteria);
				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

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

		$criteria->add(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

		return AdjudicatorFeedbackSheetPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addAdjudicatorFeedbackSheet(AdjudicatorFeedbackSheet $l)
	{
		$this->collAdjudicatorFeedbackSheets[] = $l;
		$l->setDebateTeamXref($this);
	}


	
	public function getAdjudicatorFeedbackSheetsJoinAdjudicator($criteria = null, $con = null)
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

				$criteria->add(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelectJoinAdjudicator($criteria, $con);
			}
		} else {
									
			$criteria->add(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

			if (!isset($this->lastAdjudicatorFeedbackSheetCriteria) || !$this->lastAdjudicatorFeedbackSheetCriteria->equals($criteria)) {
				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelectJoinAdjudicator($criteria, $con);
			}
		}
		$this->lastAdjudicatorFeedbackSheetCriteria = $criteria;

		return $this->collAdjudicatorFeedbackSheets;
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

				$criteria->add(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		} else {
									
			$criteria->add(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());

			if (!isset($this->lastAdjudicatorFeedbackSheetCriteria) || !$this->lastAdjudicatorFeedbackSheetCriteria->equals($criteria)) {
				$this->collAdjudicatorFeedbackSheets = AdjudicatorFeedbackSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		}
		$this->lastAdjudicatorFeedbackSheetCriteria = $criteria;

		return $this->collAdjudicatorFeedbackSheets;
	}

} 