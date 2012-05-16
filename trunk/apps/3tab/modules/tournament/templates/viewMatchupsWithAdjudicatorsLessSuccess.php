<h1>Matchups for <?php echo $round->getName();?></h1>
<table id="big" class="zebra-striped bordered-table">
    <thead>
        <tr>
            <th>Venue</th>
            <th>Affirmative</th>
            <th>Negative</th>
			<th>Panel</th>
			<th>Trainees</th>
        </tr>
    </thead>
    <tbody>
<?php
$c = new Criteria();
$c->addAscendingOrderByColumn("RANDOM()");
foreach($round->getDebates($c) as $number => $debate):
?>
        <tr>
            <td style="font-size: 140%">
                <?php echo $debate->getVenue()->getName(); ?>
            </td>
            <td style="font-size: 140%">
                <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(); ?>
            </td>
            <td style="font-size: 140%">
                <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName(); ?>
            </td>
			<?php 
				$c = new Criteria();
                $c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE, Criteria::NOT_EQUAL);
				$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::TYPE);
                $c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::ID);
				$adjudicatorAllocations = $debate->getAdjudicatorAllocations($c); 
				$chair = $adjudicatorAllocations[0]->getAdjudicator();
			?>
			<td>
                <ul>
                <?php
                foreach ($adjudicatorAllocations as $adjudicatorAllocation):
                    if ($adjudicatorAllocation->getType() == AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR) {
                ?>
                    <li style="font-weight: bold; font-size: 120%"><?php echo $adjudicatorAllocation->getAdjudicator()->getName(); ?></li>
                <?php
                    } elseif ($adjudicatorAllocation->getType() == AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST) {
                ?>
                    <li style="font-size: 120%"><?php echo $adjudicatorAllocation->getAdjudicator()->getName(); ?></li>
                <?php
                    }
                endforeach;
                ?>
                </ul>
			</td>
			<?php
                $c = new Criteria();
                $c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE);
                $c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::ID);
                $trainees = $debate->getAdjudicatorAllocations($c); 
			?>
			<td>
				<?php
					if(count($trainees) > 0)
					{
                ?>
                <ul>
                <?php
                        foreach ($trainees as $trainee)
                        {
                ?>
						<li><?php echo $trainee->getAdjudicator()->getName(); ?></li>
                <?php
                        }
                ?>
                </ul>
                <?php
					}
				?>
			</td>
        </tr>
<?php
endforeach;

?>
    </tbody>
</table>
