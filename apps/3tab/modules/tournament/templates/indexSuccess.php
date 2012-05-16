<?php
function options_for_action_select($round)
{
    $actions = array();
    if($round->getStatus() == Round::ROUND_STATUS_DRAFT)
    {
        $actions[url_for("tournament/createMatchups?id=".$round->getId(), true)] = "Draw matchups";
    }
    
    if($round->getStatus() >= Round::ROUND_STATUS_MATCHUPS_CONFIRMED and !$round->hasResultsEntered())
    {
        $actions[url_for("tournament/preAdjudicatorAllocation?id=".$round->getId(), true)] = "Allocate adjudicators";
    }

    if($round->getStatus() >= Round::ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_CONFIRMED)
    {
        $actions[url_for("tournament/traineeAllocation?id=".$round->getId(), true)] = "Allocate trainees";
    }

    if($round->getStatus() >= Round::ROUND_STATUS_TRAINEE_ALLOCATIONS_CONFIRMED)
    {
        $actions[url_for("tournament/resultsEntry?id=".$round->getId(), true)] = "Enter results";
    }

    return $actions; 
}

function default_for_action_select($round)
{
    if($round->getStatus() == Round::ROUND_STATUS_DRAFT)
    {
        return url_for("tournament/createMatchups?id=".$round->getId(), true);
    }
    else if($round->getStatus() == Round::ROUND_STATUS_MATCHUPS_CONFIRMED)
    {
        return url_for("tournament/preAdjudicatorAllocation?id=".$round->getId(), true);
    }
    else if($round->getStatus() == Round::ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_CONFIRMED)
    {
        return url_for("tournament/traineeAllocation?id=".$round->getId(), true);
    }
    else if($round->getStatus() == Round::ROUND_STATUS_TRAINEE_ALLOCATIONS_CONFIRMED)
    {
        return url_for("tournament/resultsEntry?id=".$round->getId(), true);
    }
}

?>
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
                echo select_tag('thing_to_do', options_for_select(options_for_action_select($round), default_for_action_select($round)));
                echo link_to('Go', '#', array('class' => 'btn primary', 'id' => 'go_button'));
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
