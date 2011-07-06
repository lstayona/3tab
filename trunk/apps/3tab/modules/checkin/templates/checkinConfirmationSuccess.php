<?php use_helper("Form"); ?>
<h1>Participant check-in for <?php echo RoundPeer::getCurrentRound()->getName(); ?></h1>
<?php echo form_tag("checkin/confirmCheckin");?>
<h2>Confirm that you are <?php echo $participant->getName(); ?></h2>
<?php echo input_hidden_tag("type", get_class($participant)); ?>
<?php echo input_hidden_tag("participant_id", $participant->getId()); ?>
<div id="button">
    <?php echo link_to("That's not my name", "checkin/index"); ?>
    <?php echo submit_tag("That's me, check me in"); ?>
</div>
</form>
