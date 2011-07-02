<?php


abstract class BaseDebaterResult extends BaseObject  {


	
	protected static $peer;


	
	protected $debate_team_xref_id;


	
	protected $debater_id;


	
	protected $speaking_position;


	
	protected $averaged_score;

	
	protected $aDebateTeamXref;

	
	protected $aDebater;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getDebateTeamXrefId()
	{

		return $this->debate_team_xref_id;
	}

	
	public function getDebaterId()
	{

		return $this->debater_id;
	}

	
	public function getSpeakingPosition()
	{

		return $this->speaking_position;
	}

	
	public function getAveragedScore()
	{

		return $this->averaged_score;
	}

	
	public function setDebateTeamXrefId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->debate_team_xref_id !== $v) {
			$this->debate_team_xref_id = $v;
			$this->modifiedColumns[] = DebaterResultPeer::DEBATE_TEAM_XREF_ID;
		}

		if ($this->aDebateTeamXref !== null && $this->aDebateTeamXref->getId() !== $v) {
			$this->aDebateTeamXref = null;
		}

	} 
	
	public function setDebaterId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->debater_id !== $v) {
			$this->debater_id = $v;
			$this->modifiedColumns[] = DebaterResultPeer::DEBATER_ID;
		}

		if ($this->aDebater !== null && $this->aDebater->getId() !== $v) {
			$this->aDebater = null;
		}

	} 
	
	public function setSpeakingPosition($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->speaking_position !== $v) {
			$this->speaking_position = $v;
			$this->modifiedColumns[] = DebaterResultPeer::SPEAKING_POSITION;
		}

	} 
	
	public function setAveragedScore($v)
	{

		if ($this->averaged_score !== $v) {
			$this->averaged_score = $v;
			$this->modifiedColumns[] = DebaterResultPeer::AVERAGED_SCORE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->debate_team_xref_id = $rs->getInt($startcol + 0);

			$this->debater_id = $rs->getInt($startcol + 1);

			$this->speaking_position = $rs->getInt($startcol + 2);

			$this->averaged_score = $rs->getFloat($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating DebaterResult object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DebaterResultPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			DebaterResultPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DebaterResultPeer::DATABASE_NAME);
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


												
			if ($this->aDebateTeamXref !== null) {
				if ($this->aDebateTeamXref->isModified()) {
					$affectedRows += $this->aDebateTeamXref->save($con);
				}
				$this->setDebateTeamXref($this->aDebateTeamXref);
			}

			if ($this->aDebater !== null) {
				if ($this->aDebater->isModified()) {
					$affectedRows += $this->aDebater->save($con);
				}
				$this->setDebater($this->aDebater);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DebaterResultPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += DebaterResultPeer::doUpdate($this, $con);
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


												
			if ($this->aDebateTeamXref !== null) {
				if (!$this->aDebateTeamXref->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDebateTeamXref->getValidationFailures());
				}
			}

			if ($this->aDebater !== null) {
				if (!$this->aDebater->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDebater->getValidationFailures());
				}
			}


			if (($retval = DebaterResultPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DebaterResultPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getDebateTeamXrefId();
				break;
			case 1:
				return $this->getDebaterId();
				break;
			case 2:
				return $this->getSpeakingPosition();
				break;
			case 3:
				return $this->getAveragedScore();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DebaterResultPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getDebateTeamXrefId(),
			$keys[1] => $this->getDebaterId(),
			$keys[2] => $this->getSpeakingPosition(),
			$keys[3] => $this->getAveragedScore(),
		);
		return $result;
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(DebaterResultPeer::DATABASE_NAME);

		if ($this->isColumnModified(DebaterResultPeer::DEBATE_TEAM_XREF_ID)) $criteria->add(DebaterResultPeer::DEBATE_TEAM_XREF_ID, $this->debate_team_xref_id);
		if ($this->isColumnModified(DebaterResultPeer::DEBATER_ID)) $criteria->add(DebaterResultPeer::DEBATER_ID, $this->debater_id);
		if ($this->isColumnModified(DebaterResultPeer::SPEAKING_POSITION)) $criteria->add(DebaterResultPeer::SPEAKING_POSITION, $this->speaking_position);
		if ($this->isColumnModified(DebaterResultPeer::AVERAGED_SCORE)) $criteria->add(DebaterResultPeer::AVERAGED_SCORE, $this->averaged_score);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(DebaterResultPeer::DATABASE_NAME);


		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return null;
	}

	
	 public function setPrimaryKey($pk)
	 {
		 	 }

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setDebateTeamXrefId($this->debate_team_xref_id);

		$copyObj->setDebaterId($this->debater_id);

		$copyObj->setSpeakingPosition($this->speaking_position);

		$copyObj->setAveragedScore($this->averaged_score);


		$copyObj->setNew(true);

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
			self::$peer = new DebaterResultPeer();
		}
		return self::$peer;
	}

	
	public function setDebateTeamXref($v)
	{


		if ($v === null) {
			$this->setDebateTeamXrefId(NULL);
		} else {
			$this->setDebateTeamXrefId($v->getId());
		}


		$this->aDebateTeamXref = $v;
	}


	
	public function getDebateTeamXref($con = null)
	{
		if ($this->aDebateTeamXref === null && ($this->debate_team_xref_id !== null)) {
						include_once 'lib/model/om/BaseDebateTeamXrefPeer.php';

			$this->aDebateTeamXref = DebateTeamXrefPeer::retrieveByPK($this->debate_team_xref_id, $con);

			
		}
		return $this->aDebateTeamXref;
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