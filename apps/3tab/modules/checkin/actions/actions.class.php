<?php

/**
 * checkin actions.
 *
 * @package    3tab
 * @subpackage checkin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class checkinActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    return sfView::SUCCESS;
  }

  public function executeParticipantConfirmation()
  {
      if (strlen($this->getRequest()->getParameter("participant_name")) < 1) {
          $this->getRequest()->setError("participant_name", "Participant name is required.");
          $this->forward("checkin", "index");
      }

      $participantName = $this->getRequest()->getParameter("participant_name");

      $c = new Criteria();
      $c->add(DebaterPeer::NAME, "%".$participantName."%", Criteria::ILIKE);
      $debaters = DebaterPeer::doSelect($c);

      $c = new Criteria();
      $c->add(AdjudicatorPeer::NAME, "%".$participantName."%", Criteria::ILIKE);
      $adjudicators = AdjudicatorPeer::doSelect($c);

      $this->adjudicators = $adjudicators;
      $this->debaters = $debaters;

      return sfView::SUCCESS;
  }

  public function executeCheckinConfirmation()
  {
      if ($this->hasRequestParameter("check_in_debater")) {
          $this->participant = DebaterPeer::retrieveByPK($this->getRequest()->getParameter('check_in_debater'));
      } else if ($this->hasRequestParameter("check_in_adjudicator")) {
          $this->participant = AdjudicatorPeer::retrieveByPK($this->getRequest()->getParameter('check_in_adjudicator'));
      }
      
      return sfView::SUCCESS;
  }

  public function executeConfirmCheckin()
  {
      $con = Propel::getConnection();
      try {
        $con->begin();
        $c = new Criteria();
        $round = RoundPeer::getCurrentRound($con);
        if ($this->getRequestParameter("type") == "Adjudicator") {
            $adjudicator = AdjudicatorPeer::retrieveByPK($this->getRequestParameter("participant_id"), $con);
            $c->add(AdjudicatorCheckinPeer::ROUND_ID, $round->getId());
            $c->add(AdjudicatorCheckinPeer::ADJUDICATOR_ID, $adjudicator->getId());
            AdjudicatorCheckinPeer::doDelete($c, $con);

            $adjudicatorCheckin = new AdjudicatorCheckin();
            $adjudicatorCheckin->setAdjudicator($adjudicator);
            $adjudicatorCheckin->setRound($round);
            $adjudicatorCheckin->save($con);
        } else if ($this->getRequestParameter("type") == "Debater") {
            $debater = DebaterPeer::retrieveByPK($this->getRequestParameter("participant_id"), $con);
            $c->add(DebaterCheckinPeer::ROUND_ID, $round->getId());
            $c->add(DebaterCheckinPeer::DEBATER_ID, $debater->getId());
            DebaterCheckinPeer::doDelete($c, $con);

            $debaterCheckin = new DebaterCheckin();
            $debaterCheckin->setDebater($debater);
            $debaterCheckin->setRound($round);
            $debaterCheckin->save($con);
        }
        $con->commit();

        $this->redirect('checkin/index');
      } catch (Exception $e) {
        $con->rollback();
        throw $e;
      }
  }

  public function executeListAbsent()
  {
      $con = Propel::getConnection();
      $sql = "SELECT debaters.* FROM debaters ".
      "JOIN teams ON teams.id = debaters.team_id ".
      "LEFT JOIN debater_checkins ON debater_checkins.debater_id = debaters.id AND debater_checkins.round_id = ? ".
      "WHERE debater_checkins.id IS NULL AND teams.active = true";
      $statement = $con->prepareStatement($sql);
      $statement->setInt(1, RoundPeer::getCurrentRound()->getId());
      $rs = $statement->executeQuery(ResultSet::FETCHMODE_NUM);
      $this->debaters = DebaterPeer::populateObjects($rs);

      $sql = "SELECT adjudicators.* FROM adjudicators " .
      "LEFT JOIN adjudicator_checkins ON adjudicator_checkins.adjudicator_id = adjudicators.id AND adjudicator_checkins.round_id = ? ".
      "WHERE adjudicator_checkins.id IS NULL AND adjudicators.active = true";
      $statement = $con->prepareStatement($sql);
      $statement->setInt(1, RoundPeer::getCurrentRound()->getId());
      $rs = $statement->executeQuery(ResultSet::FETCHMODE_NUM);
      $this->adjudicators = AdjudicatorPeer::populateObjects($rs);

      return sfView::SUCCESS;
  }
}
