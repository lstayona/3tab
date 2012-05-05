<h1>Draft matchups for <?php echo $round->getName();?></h1>
<?php 
if ($sf_request->hasErrors()): 
?>
<ul id="errors">
<?php
    foreach ($sf_request->getErrors() as $id => $message):
?>
    <li id="<?php echo $id;?>"><?php echo $message; ?></li>
<?php
    endforeach;
?>
</ul>
<?php 
endif;
?>
<?php echo form_tag('tournament/confirmMatchups'); ?>
<table class="bordered-table zebra-striped">
    <thead>
        <tr>
            <th>Venue</th>
            <th>Affirmative</th>
            <th>Negative</th>
			<th>Bracket</th>
        </tr>
    </thead>
    <tbody>
<?php
$c = new Criteria();
$c->add(TeamPeer::ACTIVE, true);
$c->addAscendingOrderByColumn(TeamPeer::NAME);
$teams = TeamPeer::doSelect($c);
foreach($debates as $number => $debate):
?>
        <tr>
            <td>
                <?php echo $debate->getVenue()->getName();?>
                <?php echo input_hidden_tag("debates[$number][venue_id]", $debate->getVenue()->getId());?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName();?>
                <?php echo input_hidden_tag("debates[$number][affirmative_team_id]", $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getId()); ?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName(); ?>
                <?php echo input_hidden_tag("debates[$number][negative_team_id]", $debate->getTeam(DebateTeamXref::NEGATIVE)->getId()); ?>
            </td>
			<td>
                <?php echo $debate->getBracket(); ?>
            </td>
        </tr>
<?php
endforeach;
?>
    </tbody>
</table>
<div id="button">
    <?php echo input_hidden_tag('id', $round->getId()); ?>
    <?php echo submit_tag("Confirm", array("class" => "btn primary"));?>
</div>
</form>
