<h1>Debater Ranks</h1>
<table class="bordered-table zebra-striped">
<thead>
<tr>
  <th>Rank</th>
  <th>Name</th>
  <th>Team</th>
  <th>Total Speaker Score</th>
</tr>
</thead>
<tbody>
<?php $count = 1 ?>
<?php foreach ($speakerScores as $speakerScore): ?>
<tr>
    <td><?php echo $count++ ?></td>
	<?php $debater = DebaterPeer::retrieveByPk($speakerScore->getDebaterId()); ?>
      <td><?php echo $debater->getName() ?></td>
	  <td><?php echo $debater->getTeam()->getName() ?></td>
      <td><?php echo $speakerScore->getTotalSpeakerScore() ?> </td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
<div id="button">
<?php echo link_to ('Back', 'tournament/index', array("class" => "btn")) ?>
</div>
