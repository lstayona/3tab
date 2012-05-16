<h1>Matchups for <?php echo $round->getName();?></h1>
<table id="big" class="zebra-striped bordered-table">
    <thead>
        <tr>
            <th>Venue</th>
            <th>Affirmative</th>
            <th>Negative</th>
			<th>Bracket</th>
			<th>Chair</th>
			<th>Panel 1</th>
			<th>Panel 2</th>
			<th>Trainee 1</th>
			<th>Trainee 2</th>
			<th>Trainee 3</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach($round->getDebates() as $number => $debate):
?>
        <tr>
            <td>
                <?php echo $debate->getVenue()->getName(); ?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(); ?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName(); ?>
            </td>			
            <td>
                <?php echo $debate->getBracket(); ?>
            </td>
			<?php 
				$c = new Criteria();
				$c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE, Criteria::NOT_EQUAL);
				$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::TYPE);
				$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::ID);
				$adjudicatorAllocations = $debate->getAdjudicatorAllocations($c); 
			?>
			<td>
				<?php echo $adjudicatorAllocations[0]->getAdjudicator()->getInfo(); ?>
			</td>
			<td>
				<?php 
					if(count($adjudicatorAllocations) > 1)
					{
						echo $adjudicatorAllocations[1]->getAdjudicator()->getInfo(); 
					}
				?>
			</td>
			<td>
				<?php 
					if(count($adjudicatorAllocations) > 1)
					{
						echo $adjudicatorAllocations[2]->getAdjudicator()->getInfo(); 
					}
				?>
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
						echo $trainees[0]->getAdjudicator()->getInfo();
					}
				?>
			</td>
			<td>
				<?php
					if(count($trainees) > 1)
					{
						echo $trainees[1]->getAdjudicator()->getInfo();
					}
				?>
			</td>
			<td>
				<?php
					if(count($trainees) > 2)
					{
						echo $trainees[2]->getAdjudicator()->getInfo();
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
<?php echo link_to("Back", 'tournament/index', array('class' => 'btn')); ?>
</div>
