<h1>Tournament Management</h1>
<table class="zebra-striped bordered-table">
    <thead>
        <tr>
            <th>Round</th>
            <th>Type</th>
            <th>Status</th>
            <th>Action</th>
            <th>View</th>
			<th>Feedback</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach($rounds as $round)
{
?>
    <tr>
        <td><?php echo $round->getName(); ?></td>
        <td><?php echo $round->getTypeText(); ?></td>
        <td><?php echo $round->getStatusText(); ?></td>
        <td>
            <?php
            if($round->isCurrentRound())
            {
                if($round->getStatus() == Round::ROUND_STATUS_DRAFT)
                {
					$link = "tournament/createMatchups?id=".$round->getId();
                    echo link_to("Team matchups", $link);
                }
                else if($round->getStatus() == Round::ROUND_STATUS_MATCHUPS_CONFIRMED)
                {
					$link = "tournament/preAdjudicatorAllocation?id=".$round->getId();
                    echo link_to("Allocate Adjudicators", $link);
                }
				else if($round->getStatus() == Round::ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_CONFIRMED)
                {
					$link = "tournament/traineeAllocation?id=".$round->getId();
                    echo link_to("Allocate Trainees", $link);
                }
				else if($round->getStatus() == Round::ROUND_STATUS_TRAINEE_ALLOCATIONS_CONFIRMED)
                {
					$link = "tournament/resultsEntry?id=".$round->getId();
                    echo link_to("Enter results", $link);
                }
            }
            ?>
        </td>
        <td>
            <?php
            if($round->getStatus() == Round::ROUND_STATUS_MATCHUPS_CONFIRMED)
            {
				$link = "tournament/viewMatchups?id=".$round->getId();
                echo link_to("View matchups", $link);
                echo ' | ';
                echo link_to("View matchups (Briefing room)", "tournament/viewMatchupsWithAdjudicatorsLess?id=" . $round->getId());
            }
			else if($round->getStatus() > Round::ROUND_STATUS_MATCHUPS_CONFIRMED)
            {
				$link = "tournament/viewMatchupsWithAdjudicators?id=".$round->getId();
                echo link_to("View matchups", $link);
                echo ' | ';
                echo link_to("View matchups (Briefing room)", "tournament/viewMatchupsWithAdjudicatorsLess?id=" . $round->getId());
            }
            ?>
        </td>
		<td>
			<?php
				if($round->getStatus() >= Round::ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_CONFIRMED)
                {
					$link = "tournament/feedbackEntry?id=".$round->getId();
                    echo link_to("Enter Adjudicator Feedback", $link);			
                }
				if($round->getStatus() >= Round::ROUND_STATUS_TRAINEE_ALLOCATIONS_CONFIRMED)
                {					
					echo " | ";
					$link = "tournament/traineeFeedbackEntry?id=".$round->getId();
					echo link_to("Enter Trainee Feedback", $link);		
                }
			?>
    </tr>
<?php
}
?>
    </tbody>
</table>
