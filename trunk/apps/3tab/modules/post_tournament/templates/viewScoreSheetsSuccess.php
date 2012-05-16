<?php 
$c = new Criteria();
$c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE, Criteria::NOT_EQUAL);
$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::TYPE);
$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::ID);
$adjudicatorAllocations = $debate->getAdjudicatorAllocations($c); 
$errors = $sf_request->getErrors();
?>
<h1><?php echo $debate->getRound()->getName(); ?> - <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName();?> (Affirmative) - <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName();?> (Negative)</h1>
<hr />

<?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
<?php 
	$affTotal = $adjudicatorAllocation->getTeamTotalSpeakerScore($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)); 
	$negTotal = $adjudicatorAllocation->getTeamTotalSpeakerScore($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)); 
?>
<table id="display">
	<tbody>
		<tr>
			<td>Adjudicator</td>
			<td><?php echo $adjudicatorAllocation->getAdjudicator()->getName(); ?></td>
		</tr>
		<tr>
			<td>Winner</td>
			<td><?php echo $adjudicatorAllocation->getTeamByScore(1)->getName() ?></td>
		</tr>
		<tr>
			<td>Margin</td>
			<td><?php echo abs($affTotal - $negTotal) ?></td>
		</tr>
	</tbody>
</table>
<table>
	<thead>
        <tr>
            <th colspan = "3">AFFIRMATIVE</th>
            <th colspan = "3">NEGATIVE</th>
        </tr>
        <tr>
            <th><?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName();?></th>
            <th>Speaker</th>
            <th>Score</th> 
            <th><?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName();?></th>
            <th>Speaker</th>
            <th>Score</th> 
        </tr>
    </thead>
	<tbody>
    <?php foreach(SpeakerScoreSheet::getSpeakerPositions() as $speakerPosition => $description): ?>    
		<tr>
			<td>Aff <?php echo $description ?></td>
			<td><?php echo $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getSpeaker($speakerPosition)->getName(); ?></td>
			<td><?php echo $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getSpeakerScoreSheet($speakerPosition, $adjudicatorAllocation)->getScore() ?></td>
			<td>Neg <?php echo $description ?></td>
			<td><?php echo $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getSpeaker($speakerPosition)->getName(); ?></td>
			<td><?php echo $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getSpeakerScoreSheet($speakerPosition, $adjudicatorAllocation)->getScore() ?></td>
		</tr>    
    <?php endforeach; ?>
        <tr>
            <td colspan="2">TOTAL AFF SCORES</td>
            <td><?php echo $affTotal ?></td>
            
            <td colspan="2">TOTAL NEG SCORES</td>
            <td><?php echo $negTotal ?></td>
        </tr>		
    </tbody>
</table>
<br><br>

<?php endforeach; ?>
<div id="button">
<?php echo link_to ('Scores By Team', 'post_tournament/resultsByTeam') ?>&nbsp
<?php echo link_to ('Scores By Round', 'post_tournament/resultsByRound') ?>
</div>

