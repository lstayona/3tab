<?php


abstract class BaseTeamScore extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $team_id;


	
	protected $total_team_score = 0;


	
	protected $total_speaker_score = 0;


	
	protected $total_margin = 0;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aTeam;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTeamId()
	{

		return $this->team_id;
	}

	
	public function getTotalTeamScore()
	{

		return $this->total_team_score;
	}

	
	public function getTotalSpeakerScore()
	{

		return $this->total_speaker_score;
	}

	
	public function getTotalMargin()
	{

		return $this->total_margin;
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
			$this->modifiedColumns[] = TeamScorePeer::ID;
		}

	} 
	
	public function setTeamId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->team_id !== $v) {
			$this->team_id = $v;
			$this->modifiedColumns[] = TeamScorePeer::TEAM_ID;
		}

		if ($this->aTeam !== null && $this->aTeam->getId() !== $v) {
			$this->aTeam = null;
		}

	} 
	
	public function setTotalTeamScore($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total_team_score !== $v || $v === 0) {
			$this->total_team_score = $v;
			$this->modifiedColumns[] = TeamScorePeer::TOTAL_TEAM_SCORE;
		}

	} 
	
	public function setTotalSpeakerScore($v)
	{

		if ($this->total_speaker_score !== $v || $v === 0) {
			$this->total_speaker_score = $v;
			$this->modifiedColumns[] = TeamScorePeer::TOTAL_SPEAKER_SCORE;
		}

	} 
	
	public function setTotalMargin($v)
	{

		if ($this->total_margin !== $v || $v === 0) {
			$this->total_margin = $v;
			$this->modifiedColumns[] = TeamScorePeer::TOTAL_MARGIN;
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
			$this->modifiedColumns[] = TeamScorePeer::CREATED_AT;
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
			$this->modifiedColumns[] = TeamScorePeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->team_id = $rs->getInt($startcol + 1);

			$this->total_team_score = $rs->getInt($startcol + 2);

			$this->total_speaker_score = $rs->getFloat($startcol + 3);

			$this->total_margin = $rs->getFloat($startcol + 4);

			$this->created_at = $rs->getTimestamp($startcol + 5, null);

			$this->updated_at = $rs->getTimestamp($startcol + 6, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating TeamScore object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TeamScorePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TeamScorePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(TeamScorePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(TeamScorePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TeamScorePeer::DATABASE_NAME);
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
					$pk = TeamScorePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TeamScorePeer::doUpdate($this, $con);
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


												
			if ($this->aTeam !== null) {
				if (!$this->aTeam->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTeam->getValidationFailures());
				}
			}


			if (($retval = TeamScorePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TeamScorePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTeamId();
				break;
			case 2:
				return $this->getTotalTeamScore();
				break;
			case 3:
				return $this->getTotalSpeakerScore();
				break;
			case 4:
				return $this->getTotalMargin();
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
		$keys = TeamScorePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTeamId(),
			$keys[2] => $this->getTotalTeamScore(),
			$keys[3] => $this->getTotalSpeakerScore(),
			$keys[4] => $this->getTotalMargin(),
			$keys[5] => $this->getCreatedAt(),
			$keys[6] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TeamScorePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTeamId($value);
				break;
			case 2:
				$this->setTotalTeamScore($value);
				break;
			case 3:
				$this->setTotalSpeakerScore($value);
				break;
			case 4:
				$this->setTotalMargin($value);
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
		$keys = TeamScorePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTeamId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTotalTeamScore($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTotalSpeakerScore($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTotalMargin($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TeamScorePeer::DATABASE_NAME);

		if ($this->isColumnModified(TeamScorePeer::ID)) $criteria->add(TeamScorePeer::ID, $this->id);
		if ($this->isColumnModified(TeamScorePeer::TEAM_ID)) $criteria->add(TeamScorePeer::TEAM_ID, $this->team_id);
		if ($this->isColumnModified(TeamScorePeer::TOTAL_TEAM_SCORE)) $criteria->add(TeamScorePeer::TOTAL_TEAM_SCORE, $this->total_team_score);
		if ($this->isColumnModified(TeamScorePeer::TOTAL_SPEAKER_SCORE)) $criteria->add(TeamScorePeer::TOTAL_SPEAKER_SCORE, $this->total_speaker_score);
		if ($this->isColumnModified(TeamScorePeer::TOTAL_MARGIN)) $criteria->add(TeamScorePeer::TOTAL_MARGIN, $this->total_margin);
		if ($this->isColumnModified(TeamScorePeer::CREATED_AT)) $criteria->add(TeamScorePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(TeamScorePeer::UPDATED_AT)) $criteria->add(TeamScorePeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TeamScorePeer::DATABASE_NAME);

		$criteria->add(TeamScorePeer::ID, $this->id);

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

		$copyObj->setTeamId($this->team_id);

		$copyObj->setTotalTeamScore($this->total_team_score);

		$copyObj->setTotalSpeakerScore($this->total_speaker_score);

		$copyObj->setTotalMargin($this->total_margin);

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
			self::$peer = new TeamScorePeer();
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

} 