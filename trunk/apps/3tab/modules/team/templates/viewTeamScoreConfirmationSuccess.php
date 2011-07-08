<h1>Team Rankings</h1>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Team name</th>
        <th>Wins</th>
    </tr>
</thead>
<tbody>
<?php $count = 1 ?>

<?php foreach ($teams as $team): ?>

    <tr>
        <td><?php echo $count++ ?></td>
        <td style="font-size: 150%"><?php echo $team->getName() ?></td>
        <td style="font-size: 150%"><?php echo $team->getTotalTeamScore() ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>
<div id="button">
<?php echo link_to ('Back', 'tournament/index') ?>
</div>
