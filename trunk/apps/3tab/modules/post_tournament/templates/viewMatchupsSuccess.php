<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>
<h1>Results for <?php echo $round->getName();?></h1>
<table>
    <thead>
        <tr>
            <th>Venue</th>
            <th>Affirmative</th>
            <th>Negative</th>
            <th>Debate results</th>
			<th>Split?</th>
			<th>Winner</th>
			<th>Majority (Minority) Votes</th>
        </tr>
    </thead>
    <tbody>
<?php
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
                <?php echo link_to("View", "post_tournament/viewScoreSheets?debateId=".$debate->getId()); ?>
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
<div id="button">
<?php echo link_to ('back', 'post_tournament/resultsByRound') ?>
</div>
