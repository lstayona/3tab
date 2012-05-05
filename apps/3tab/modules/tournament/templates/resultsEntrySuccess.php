<h1>Results entry for <?php echo $round->getName();?></h1>
<?php echo form_tag('tournament/confirmRoundResults'); ?>
<table class="zebra-striped bordered-table">
    <thead>
        <tr>
            <th>Venue</th>
            <th>Affirmative</th>
            <th>Negative</th>
			<th>Bracket</th>
            <th>Complete?</th>
            <th>Debate results</th>
			<th>Split?</th>
			<th>Winner</th>
			<th>Majority (Minority) Votes</th>
        </tr>
    </thead>
    <tbody>
<?php
$completedCount = 0;
foreach($round->getDebates() as $number => $debate):
?>
        <tr>
            <td>
                <?php echo $debate->getVenue()->getName();?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName();?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName(); ?>
            </td>
			<td>
                <?php echo $debate->getBracket(); ?>
            </td>
            <td>
                <?php echo $debate->resultsEntered() ? "Yes" : "No"; ?>
				<?php $debate->resultsEntered() ? $completedCount++ : null ?>
            </td>
            <td>
                <?php echo link_to($debate->resultsEntered() ? "Edit" : "Enter", "tournament/debateResultsEntry?id=".$debate->getId()); ?>
            </td>
			<td>
				<?php 
					$split = $debate->isSplitDecision();
					if(strcmp($split, "No Results Yet") == 0)
					{
						echo "No Results Yet";
					}
					else
					{
						echo $split ? "Yes" : "No"; 
					}
				?>
			</td>
			<td>
				<?php 
					$winnerXref = $debate->getWinningDebateTeamXref();
					if($winnerXref == "No Results Yet")
					{
						echo "No Results Yet";
					}
					else
					{
						echo $winnerXref->getTeam()->getName();
					}
				?>
			</td>
			<td>
				<?php 
					$majorityAllocations= $debate->getAdjudicatorAllocationsInMajority();
					$minorityAllocations = $debate->getAdjudicatorAllocationsInMajority(false);
					if($majorityAllocations == "No Results Yet" && $minorityAllocations == "No Results Yet")
					{
						echo "No Results Yet";
					}
					else
					{
						foreach($majorityAllocations as $anAllocation)
						{
							echo $anAllocation->getAdjudicator()->getName().",  ";
						}
						if($minorityAllocations)
						{
							echo "(".$minorityAllocations[0]->getAdjudicator()->getName().")";
						}
					}
				?>
			</td>
        </tr>
<?php
endforeach;
?>
    </tbody>
</table>
    <?php echo input_hidden_tag('id', $round->getId()); ?>
	<?php
		if($completedCount == count($round->getDebates()))
		{	
			echo submit_tag("Confirm", array('class' => 'btn large primary'));
		}
	?>
</form>
