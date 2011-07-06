<?php use_helper("Form"); ?>
<h1>Participant check-in for <?php echo RoundPeer::getCurrentRound()->getName(); ?></h1>
<?php echo form_tag("checkin/checkinConfirmation", array('method' => 'GET')); ?>
<table>
    <thead>
        <tr>
            <th>Participant name</th>
            <th>Institution</th>
            <th>Type</th>
            <th>Team</th>
            <th>Check-in</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($debaters as $debater): ?>
        <tr>
            <td><?php echo $debater->getName(); ?></td>
            <td><?php echo $debater->getTeam()->getInstitution()->getName(); ?></td>
            <td>Debater</td>
            <td><?php echo $debater->getTeam()->getName(); ?></td>
            <td><?php echo !$debater->hasCheckedIn(RoundPeer::getCurrentRound()) ? radiobutton_tag("check_in_debater", $debater->getId()) : "Checked-in already"; ?></td>
        </tr>
<?php endforeach; ?>
<?php foreach($adjudicators as $adjudicator): ?>
        <tr>
            <td><?php echo $adjudicator->getName(); ?></td>
            <td><?php echo $adjudicator->getInstitution()->getName(); ?></td>
            <td>Adjudicator</td>
            <td>-</td>
            <td><?php echo !$adjudicator->hasCheckedIn(RoundPeer::getCurrentRound()) ? radiobutton_tag("check_in_adjudicator", $adjudicator->getId()) : "Checked-in already"; ?></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>                
<div id="button">
    <?php echo link_to("Back", "checkin/index"); ?>
    <?php echo submit_tag("Check me in"); ?>
</div>
</form>
