<?php


abstract class BaseDebater extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $team_id;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aTeam;

	
	protected $collSpeakerScoreSheets;

	
	protected $lastSpeakerScoreSheetCriteria = null;

	
	protected $collSpeakerScores;

	
	protected $lastSpeakerScoreCriteria = null;

	
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

	
	public function getTeamId()
	{

		return $this->team_id;
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
			$this->modifiedColumns[] = DebaterPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = DebaterPeer::NAME;
		}

	} 
	
	public function setTeamId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->team_id !== $v) {
			$this->team_id = $v;
			$this->modifiedColumns[] = DebaterPeer::TEAM_ID;
		}

		if ($this->aTeam !== null && $this->aTeam->getId() !== $v) {
			$this->aTeam = null;
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
			$this->modifiedColumns[] = DebaterPeer::CREATED_AT;
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
			$this->modifiedColumns[] = DebaterPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->team_id = $rs->getInt($startcol + 2);

			$this->created_at = $rs->getTimestamp($startcol + 3, null);

			$this->updated_at = $rs->getTimestamp($startcol + 4, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Debater object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DebaterPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			DebaterPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(DebaterPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(DebaterPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DebaterPeer::DATABASE_NAME);
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


												
			if ($this->aTeam !== null) {
				if ($this->aTeam->isModified()) {
					$affectedRows += $this->aTeam->save($con);
				}
				$this->setTeam($this->aTeam);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DebaterPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += DebaterPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collSpeakerScoreSheets !== null) {
				foreach($this->collSpeakerScoreSheets as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSpeakerScores !== null) {
				foreach($this->collSpeakerScores as $referrerFK) {
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


												
			if ($this->aTeam !== null) {
				if (!$this->aTeam->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTeam->getValidationFailures());
				}
			}


			if (($retval = DebaterPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collSpeakerScoreSheets !== null) {
					foreach($this->collSpeakerScoreSheets as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSpeakerScores !== null) {
					foreach($this->collSpeakerScores as $referrerFK) {
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
		$pos = DebaterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getTeamId();
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
		$keys = DebaterPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getTeamId(),
			$keys[3] => $this->getCreatedAt(),
			$keys[4] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DebaterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setTeamId($value);
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
		$keys = DebaterPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTeamId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUpdatedAt($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(DebaterPeer::DATABASE_NAME);

		if ($this->isColumnModified(DebaterPeer::ID)) $criteria->add(DebaterPeer::ID, $this->id);
		if ($this->isColumnModified(DebaterPeer::NAME)) $criteria->add(DebaterPeer::NAME, $this->name);
		if ($this->isColumnModified(DebaterPeer::TEAM_ID)) $criteria->add(DebaterPeer::TEAM_ID, $this->team_id);
		if ($this->isColumnModified(DebaterPeer::CREATED_AT)) $criteria->add(DebaterPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(DebaterPeer::UPDATED_AT)) $criteria->add(DebaterPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(DebaterPeer::DATABASE_NAME);

		$criteria->add(DebaterPeer::ID, $this->id);

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

		$copyObj->setTeamId($this->team_id);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getSpeakerScoreSheets() as $relObj) {
				$copyObj->addSpeakerScoreSheet($relObj->copy($deepCopy));
			}

			foreach($this->getSpeakerScores() as $relObj) {
				$copyObj->addSpeakerScore($relObj->copy($deepCopy));
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
			self::$peer = new DebaterPeer();
		}
		return self::$peer;
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

				$criteria->add(SpeakerScoreSheetPeer::DEBATER_ID, $this->getId());

				SpeakerScoreSheetPeer::addSelectColumns($criteria);
				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SpeakerScoreSheetPeer::DEBATER_ID, $this->getId());

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

		$criteria->add(SpeakerScoreSheetPeer::DEBATER_ID, $this->getId());

		return SpeakerScoreSheetPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSpeakerScoreSheet(SpeakerScoreSheet $l)
	{
		$this->collSpeakerScoreSheets[] = $l;
		$l->setDebater($this);
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

				$criteria->add(SpeakerScoreSheetPeer::DEBATER_ID, $this->getId());

				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		} else {
									
			$criteria->add(SpeakerScoreSheetPeer::DEBATER_ID, $this->getId());

			if (!isset($this->lastSpeakerScoreSheetCriteria) || !$this->lastSpeakerScoreSheetCriteria->equals($criteria)) {
				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelectJoinAdjudicatorAllocation($criteria, $con);
			}
		}
		$this->lastSpeakerScoreSheetCriteria = $criteria;

		return $this->collSpeakerScoreSheets;
	}


	
	public function getSpeakerScoreSheetsJoinDebateTeamXref($criteria = null, $con = null)
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

				$criteria->add(SpeakerScoreSheetPeer::DEBATER_ID, $this->getId());

				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelectJoinDebateTeamXref($criteria, $con);
			}
		} else {
									
			$criteria->add(SpeakerScoreSheetPeer::DEBATER_ID, $this->getId());

			if (!isset($this->lastSpeakerScoreSheetCriteria) || !$this->lastSpeakerScoreSheetCriteria->equals($criteria)) {
				$this->collSpeakerScoreSheets = SpeakerScoreSheetPeer::doSelectJoinDebateTeamXref($criteria, $con);
			}
		}
		$this->lastSpeakerScoreSheetCriteria = $criteria;

		return $this->collSpeakerScoreSheets;
	}

	
	public function initSpeakerScores()
	{
		if ($this->collSpeakerScores === null) {
			$this->collSpeakerScores = array();
		}
	}

	
	public function getSpeakerScores($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSpeakerScorePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSpeakerScores === null) {
			if ($this->isNew()) {
			   $this->collSpeakerScores = array();
			} else {

				$criteria->add(SpeakerScorePeer::DEBATER_ID, $this->getId());

				SpeakerScorePeer::addSelectColumns($criteria);
				$this->collSpeakerScores = SpeakerScorePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SpeakerScorePeer::DEBATER_ID, $this->getId());

				SpeakerScorePeer::addSelectColumns($criteria);
				if (!isset($this->lastSpeakerScoreCriteria) || !$this->lastSpeakerScoreCriteria->equals($criteria)) {
					$this->collSpeakerScores = SpeakerScorePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSpeakerScoreCriteria = $criteria;
		return $this->collSpeakerScores;
	}

	
	public function countSpeakerScores($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSpeakerScorePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SpeakerScorePeer::DEBATER_ID, $this->getId());

		return SpeakerScorePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSpeakerScore(SpeakerScore $l)
	{
		$this->collSpeakerScores[] = $l;
		$l->setDebater($this);
	}

} 