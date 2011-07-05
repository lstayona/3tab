<?php


abstract class BaseTeamMargin extends BaseObject  {


	
	protected static $peer;


	
	protected $debate_team_xref_id;


	
	protected $majority_team_score;


	
	protected $team_speaker_score;


	
	protected $margin;

	
	protected $aDebateTeamXref;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getDebateTeamXrefId()
	{

		return $this->debate_team_xref_id;
	}

	
	public function getMajorityTeamScore()
	{

		return $this->majority_team_score;
	}

	
	public function getTeamSpeakerScore()
	{

		return $this->team_speaker_score;
	}

	
	public function getMargin()
	{

		return $this->margin;
	}

	
	public function setDebateTeamXrefId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->debate_team_xref_id !== $v) {
			$this->debate_team_xref_id = $v;
			$this->modifiedColumns[] = TeamMarginPeer::DEBATE_TEAM_XREF_ID;
		}

		if ($this->aDebateTeamXref !== null && $this->aDebateTeamXref->getId() !== $v) {
			$this->aDebateTeamXref = null;
		}

	} 
	
	public function setMajorityTeamScore($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->majority_team_score !== $v) {
			$this->majority_team_score = $v;
			$this->modifiedColumns[] = TeamMarginPeer::MAJORITY_TEAM_SCORE;
		}

	} 
	
	public function setTeamSpeakerScore($v)
	{

		if ($this->team_speaker_score !== $v) {
			$this->team_speaker_score = $v;
			$this->modifiedColumns[] = TeamMarginPeer::TEAM_SPEAKER_SCORE;
		}

	} 
	
	public function setMargin($v)
	{

		if ($this->margin !== $v) {
			$this->margin = $v;
			$this->modifiedColumns[] = TeamMarginPeer::MARGIN;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->debate_team_xref_id = $rs->getInt($startcol + 0);

			$this->majority_team_score = $rs->getInt($startcol + 1);

			$this->team_speaker_score = $rs->getFloat($startcol + 2);

			$this->margin = $rs->getFloat($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating TeamMargin object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TeamMarginPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TeamMarginPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(TeamMarginPeer::DATABASE_NAME);
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TeamMarginPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += TeamMarginPeer::doUpdate($this, $con);
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


			if (($retval = TeamMarginPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TeamMarginPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getDebateTeamXrefId();
				break;
			case 1:
				return $this->getMajorityTeamScore();
				break;
			case 2:
				return $this->getTeamSpeakerScore();
				break;
			case 3:
				return $this->getMargin();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TeamMarginPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getDebateTeamXrefId(),
			$keys[1] => $this->getMajorityTeamScore(),
			$keys[2] => $this->getTeamSpeakerScore(),
			$keys[3] => $this->getMargin(),
		);
		return $result;
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TeamMarginPeer::DATABASE_NAME);

		if ($this->isColumnModified(TeamMarginPeer::DEBATE_TEAM_XREF_ID)) $criteria->add(TeamMarginPeer::DEBATE_TEAM_XREF_ID, $this->debate_team_xref_id);
		if ($this->isColumnModified(TeamMarginPeer::MAJORITY_TEAM_SCORE)) $criteria->add(TeamMarginPeer::MAJORITY_TEAM_SCORE, $this->majority_team_score);
		if ($this->isColumnModified(TeamMarginPeer::TEAM_SPEAKER_SCORE)) $criteria->add(TeamMarginPeer::TEAM_SPEAKER_SCORE, $this->team_speaker_score);
		if ($this->isColumnModified(TeamMarginPeer::MARGIN)) $criteria->add(TeamMarginPeer::MARGIN, $this->margin);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TeamMarginPeer::DATABASE_NAME);


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

		$copyObj->setMajorityTeamScore($this->majority_team_score);

		$copyObj->setTeamSpeakerScore($this->team_speaker_score);

		$copyObj->setMargin($this->margin);


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
			self::$peer = new TeamMarginPeer();
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

} 