<?php


abstract class BaseTeamResult extends BaseObject  {


	
	protected static $peer;


	
	protected $debate_team_xref_id;


	
	protected $team_vote_count;


	
	protected $opponent_debate_team_xref_id;


	
	protected $opponent_team_vote_count;


	
	protected $majority_team_score;


	
	protected $winning_debate_team_xref_id;

	
	protected $aDebateTeamXrefRelatedByDebateTeamXrefId;

	
	protected $aDebateTeamXrefRelatedByOpponentDebateTeamXrefId;

	
	protected $aDebateTeamXrefRelatedByWinningDebateTeamXrefId;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getDebateTeamXrefId()
	{

		return $this->debate_team_xref_id;
	}

	
	public function getTeamVoteCount()
	{

		return $this->team_vote_count;
	}

	
	public function getOpponentDebateTeamXrefId()
	{

		return $this->opponent_debate_team_xref_id;
	}

	
	public function getOpponentTeamVoteCount()
	{

		return $this->opponent_team_vote_count;
	}

	
	public function getMajorityTeamScore()
	{

		return $this->majority_team_score;
	}

	
	public function getWinningDebateTeamXrefId()
	{

		return $this->winning_debate_team_xref_id;
	}

	
	public function setDebateTeamXrefId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->debate_team_xref_id !== $v) {
			$this->debate_team_xref_id = $v;
			$this->modifiedColumns[] = TeamResultPeer::DEBATE_TEAM_XREF_ID;
		}

		if ($this->aDebateTeamXrefRelatedByDebateTeamXrefId !== null && $this->aDebateTeamXrefRelatedByDebateTeamXrefId->getId() !== $v) {
			$this->aDebateTeamXrefRelatedByDebateTeamXrefId = null;
		}

	} 
	
	public function setTeamVoteCount($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->team_vote_count !== $v) {
			$this->team_vote_count = $v;
			$this->modifiedColumns[] = TeamResultPeer::TEAM_VOTE_COUNT;
		}

	} 
	
	public function setOpponentDebateTeamXrefId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->opponent_debate_team_xref_id !== $v) {
			$this->opponent_debate_team_xref_id = $v;
			$this->modifiedColumns[] = TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID;
		}

		if ($this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId !== null && $this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId->getId() !== $v) {
			$this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId = null;
		}

	} 
	
	public function setOpponentTeamVoteCount($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->opponent_team_vote_count !== $v) {
			$this->opponent_team_vote_count = $v;
			$this->modifiedColumns[] = TeamResultPeer::OPPONENT_TEAM_VOTE_COUNT;
		}

	} 
	
	public function setMajorityTeamScore($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->majority_team_score !== $v) {
			$this->majority_team_score = $v;
			$this->modifiedColumns[] = TeamResultPeer::MAJORITY_TEAM_SCORE;
		}

	} 
	
	public function setWinningDebateTeamXrefId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->winning_debate_team_xref_id !== $v) {
			$this->winning_debate_team_xref_id = $v;
			$this->modifiedColumns[] = TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID;
		}

		if ($this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId !== null && $this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId->getId() !== $v) {
			$this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->debate_team_xref_id = $rs->getInt($startcol + 0);

			$this->team_vote_count = $rs->getInt($startcol + 1);

			$this->opponent_debate_team_xref_id = $rs->getInt($startcol + 2);

			$this->opponent_team_vote_count = $rs->getInt($startcol + 3);

			$this->majority_team_score = $rs->getInt($startcol + 4);

			$this->winning_debate_team_xref_id = $rs->getInt($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating TeamResult object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TeamResultPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TeamResultPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(TeamResultPeer::DATABASE_NAME);
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


												
			if ($this->aDebateTeamXrefRelatedByDebateTeamXrefId !== null) {
				if ($this->aDebateTeamXrefRelatedByDebateTeamXrefId->isModified()) {
					$affectedRows += $this->aDebateTeamXrefRelatedByDebateTeamXrefId->save($con);
				}
				$this->setDebateTeamXrefRelatedByDebateTeamXrefId($this->aDebateTeamXrefRelatedByDebateTeamXrefId);
			}

			if ($this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId !== null) {
				if ($this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId->isModified()) {
					$affectedRows += $this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId->save($con);
				}
				$this->setDebateTeamXrefRelatedByOpponentDebateTeamXrefId($this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId);
			}

			if ($this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId !== null) {
				if ($this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId->isModified()) {
					$affectedRows += $this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId->save($con);
				}
				$this->setDebateTeamXrefRelatedByWinningDebateTeamXrefId($this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TeamResultPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += TeamResultPeer::doUpdate($this, $con);
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


												
			if ($this->aDebateTeamXrefRelatedByDebateTeamXrefId !== null) {
				if (!$this->aDebateTeamXrefRelatedByDebateTeamXrefId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDebateTeamXrefRelatedByDebateTeamXrefId->getValidationFailures());
				}
			}

			if ($this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId !== null) {
				if (!$this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId->getValidationFailures());
				}
			}

			if ($this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId !== null) {
				if (!$this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId->getValidationFailures());
				}
			}


			if (($retval = TeamResultPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TeamResultPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getDebateTeamXrefId();
				break;
			case 1:
				return $this->getTeamVoteCount();
				break;
			case 2:
				return $this->getOpponentDebateTeamXrefId();
				break;
			case 3:
				return $this->getOpponentTeamVoteCount();
				break;
			case 4:
				return $this->getMajorityTeamScore();
				break;
			case 5:
				return $this->getWinningDebateTeamXrefId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TeamResultPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getDebateTeamXrefId(),
			$keys[1] => $this->getTeamVoteCount(),
			$keys[2] => $this->getOpponentDebateTeamXrefId(),
			$keys[3] => $this->getOpponentTeamVoteCount(),
			$keys[4] => $this->getMajorityTeamScore(),
			$keys[5] => $this->getWinningDebateTeamXrefId(),
		);
		return $result;
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TeamResultPeer::DATABASE_NAME);

		if ($this->isColumnModified(TeamResultPeer::DEBATE_TEAM_XREF_ID)) $criteria->add(TeamResultPeer::DEBATE_TEAM_XREF_ID, $this->debate_team_xref_id);
		if ($this->isColumnModified(TeamResultPeer::TEAM_VOTE_COUNT)) $criteria->add(TeamResultPeer::TEAM_VOTE_COUNT, $this->team_vote_count);
		if ($this->isColumnModified(TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID)) $criteria->add(TeamResultPeer::OPPONENT_DEBATE_TEAM_XREF_ID, $this->opponent_debate_team_xref_id);
		if ($this->isColumnModified(TeamResultPeer::OPPONENT_TEAM_VOTE_COUNT)) $criteria->add(TeamResultPeer::OPPONENT_TEAM_VOTE_COUNT, $this->opponent_team_vote_count);
		if ($this->isColumnModified(TeamResultPeer::MAJORITY_TEAM_SCORE)) $criteria->add(TeamResultPeer::MAJORITY_TEAM_SCORE, $this->majority_team_score);
		if ($this->isColumnModified(TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID)) $criteria->add(TeamResultPeer::WINNING_DEBATE_TEAM_XREF_ID, $this->winning_debate_team_xref_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TeamResultPeer::DATABASE_NAME);

		$criteria->add(TeamResultPeer::DEBATE_TEAM_XREF_ID, $this->debate_team_xref_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getDebateTeamXrefId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setDebateTeamXrefId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTeamVoteCount($this->team_vote_count);

		$copyObj->setOpponentDebateTeamXrefId($this->opponent_debate_team_xref_id);

		$copyObj->setOpponentTeamVoteCount($this->opponent_team_vote_count);

		$copyObj->setMajorityTeamScore($this->majority_team_score);

		$copyObj->setWinningDebateTeamXrefId($this->winning_debate_team_xref_id);


		$copyObj->setNew(true);

		$copyObj->setDebateTeamXrefId(NULL); 
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
			self::$peer = new TeamResultPeer();
		}
		return self::$peer;
	}

	
	public function setDebateTeamXrefRelatedByDebateTeamXrefId($v)
	{


		if ($v === null) {
			$this->setDebateTeamXrefId(NULL);
		} else {
			$this->setDebateTeamXrefId($v->getId());
		}


		$this->aDebateTeamXrefRelatedByDebateTeamXrefId = $v;
	}


	
	public function getDebateTeamXrefRelatedByDebateTeamXrefId($con = null)
	{
		if ($this->aDebateTeamXrefRelatedByDebateTeamXrefId === null && ($this->debate_team_xref_id !== null)) {
						include_once 'lib/model/om/BaseDebateTeamXrefPeer.php';

			$this->aDebateTeamXrefRelatedByDebateTeamXrefId = DebateTeamXrefPeer::retrieveByPK($this->debate_team_xref_id, $con);

			
		}
		return $this->aDebateTeamXrefRelatedByDebateTeamXrefId;
	}

	
	public function setDebateTeamXrefRelatedByOpponentDebateTeamXrefId($v)
	{


		if ($v === null) {
			$this->setOpponentDebateTeamXrefId(NULL);
		} else {
			$this->setOpponentDebateTeamXrefId($v->getId());
		}


		$this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId = $v;
	}


	
	public function getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con = null)
	{
		if ($this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId === null && ($this->opponent_debate_team_xref_id !== null)) {
						include_once 'lib/model/om/BaseDebateTeamXrefPeer.php';

			$this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId = DebateTeamXrefPeer::retrieveByPK($this->opponent_debate_team_xref_id, $con);

			
		}
		return $this->aDebateTeamXrefRelatedByOpponentDebateTeamXrefId;
	}

	
	public function setDebateTeamXrefRelatedByWinningDebateTeamXrefId($v)
	{


		if ($v === null) {
			$this->setWinningDebateTeamXrefId(NULL);
		} else {
			$this->setWinningDebateTeamXrefId($v->getId());
		}


		$this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId = $v;
	}


	
	public function getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con = null)
	{
		if ($this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId === null && ($this->winning_debate_team_xref_id !== null)) {
						include_once 'lib/model/om/BaseDebateTeamXrefPeer.php';

			$this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId = DebateTeamXrefPeer::retrieveByPK($this->winning_debate_team_xref_id, $con);

			
		}
		return $this->aDebateTeamXrefRelatedByWinningDebateTeamXrefId;
	}

} 