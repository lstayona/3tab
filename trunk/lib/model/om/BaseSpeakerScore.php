<?php


abstract class BaseSpeakerScore extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $debater_id;


	
	protected $total_speaker_score = 0;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aDebater;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getDebaterId()
	{

		return $this->debater_id;
	}

	
	public function getTotalSpeakerScore()
	{

		return $this->total_speaker_score;
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
			$this->modifiedColumns[] = SpeakerScorePeer::ID;
		}

	} 
	
	public function setDebaterId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->debater_id !== $v) {
			$this->debater_id = $v;
			$this->modifiedColumns[] = SpeakerScorePeer::DEBATER_ID;
		}

		if ($this->aDebater !== null && $this->aDebater->getId() !== $v) {
			$this->aDebater = null;
		}

	} 
	
	public function setTotalSpeakerScore($v)
	{

		if ($this->total_speaker_score !== $v || $v === 0) {
			$this->total_speaker_score = $v;
			$this->modifiedColumns[] = SpeakerScorePeer::TOTAL_SPEAKER_SCORE;
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
			$this->modifiedColumns[] = SpeakerScorePeer::CREATED_AT;
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
			$this->modifiedColumns[] = SpeakerScorePeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->debater_id = $rs->getInt($startcol + 1);

			$this->total_speaker_score = $rs->getFloat($startcol + 2);

			$this->created_at = $rs->getTimestamp($startcol + 3, null);

			$this->updated_at = $rs->getTimestamp($startcol + 4, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating SpeakerScore object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SpeakerScorePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SpeakerScorePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(SpeakerScorePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(SpeakerScorePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SpeakerScorePeer::DATABASE_NAME);
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


												
			if ($this->aDebater !== null) {
				if ($this->aDebater->isModified()) {
					$affectedRows += $this->aDebater->save($con);
				}
				$this->setDebater($this->aDebater);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SpeakerScorePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += SpeakerScorePeer::doUpdate($this, $con);
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


												
			if ($this->aDebater !== null) {
				if (!$this->aDebater->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDebater->getValidationFailures());
				}
			}


			if (($retval = SpeakerScorePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SpeakerScorePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getDebaterId();
				break;
			case 2:
				return $this->getTotalSpeakerScore();
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
		$keys = SpeakerScorePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getDebaterId(),
			$keys[2] => $this->getTotalSpeakerScore(),
			$keys[3] => $this->getCreatedAt(),
			$keys[4] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SpeakerScorePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setDebaterId($value);
				break;
			case 2:
				$this->setTotalSpeakerScore($value);
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
		$keys = SpeakerScorePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDebaterId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTotalSpeakerScore($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUpdatedAt($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SpeakerScorePeer::DATABASE_NAME);

		if ($this->isColumnModified(SpeakerScorePeer::ID)) $criteria->add(SpeakerScorePeer::ID, $this->id);
		if ($this->isColumnModified(SpeakerScorePeer::DEBATER_ID)) $criteria->add(SpeakerScorePeer::DEBATER_ID, $this->debater_id);
		if ($this->isColumnModified(SpeakerScorePeer::TOTAL_SPEAKER_SCORE)) $criteria->add(SpeakerScorePeer::TOTAL_SPEAKER_SCORE, $this->total_speaker_score);
		if ($this->isColumnModified(SpeakerScorePeer::CREATED_AT)) $criteria->add(SpeakerScorePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(SpeakerScorePeer::UPDATED_AT)) $criteria->add(SpeakerScorePeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SpeakerScorePeer::DATABASE_NAME);

		$criteria->add(SpeakerScorePeer::ID, $this->id);

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

		$copyObj->setDebaterId($this->debater_id);

		$copyObj->setTotalSpeakerScore($this->total_speaker_score);

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
			self::$peer = new SpeakerScorePeer();
		}
		return self::$peer;
	}

	
	public function setDebater($v)
	{


		if ($v === null) {
			$this->setDebaterId(NULL);
		} else {
			$this->setDebaterId($v->getId());
		}


		$this->aDebater = $v;
	}


	
	public function getDebater($con = null)
	{
		if ($this->aDebater === null && ($this->debater_id !== null)) {
						include_once 'lib/model/om/BaseDebaterPeer.php';

			$this->aDebater = DebaterPeer::retrieveByPK($this->debater_id, $con);

			
		}
		return $this->aDebater;
	}

} 