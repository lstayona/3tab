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
            	<?php $resultsEntered = $debate->resultsEntered(); ?>
                <?php echo $resultsEntered ? "Yes" : "No"; ?>
				<?php $resultsEntered ? $completedCount++ : null ?>
            </td>
            <td>
                <?php echo link_to($resultsEntered ? "Edit" : "Enter", "tournament/debateResultsEntry?id=".$debate->getId()); ?>
            </td>
			<td>
				<?php 
					$split = $debate->isSplitDecision();
					if(is_null($split))
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
					if(is_null($winnerXref))
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
					if(is_null($majorityAllocations) and is_null($minorityAllocations))
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

							echo "(";
							foreach ($minorityAllocations as $allocation)
							{
								if ($allocation->getType() == AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR)
								{
				?>
								<strong><?php echo $allocation->getAdjudicator()->getName(); ?></strong>
				<?php
								}
								else
								{
									echo $allocation->getAdjudicator()->getName();
								}
							}
						    echo ")";
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
		if($completedCount == $round->countDebates(null, true))
		{	
			echo submit_tag("Confirm", array('class' => 'btn large primary'));
		}
	?>
</form>