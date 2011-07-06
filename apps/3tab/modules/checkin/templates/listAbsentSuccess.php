<h1>Participants not checked-in for <?php echo RoundPeer::getCurrentRound()->getName(); ?></h1>
<table>
    <thead>
        <tr>
            <th>Participant name</th>
            <th>Institution</th>
            <th>Type</th>
            <th>Team</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($debaters as $debater): ?>
        <tr>
            <td><?php echo $debater->getName(); ?></td>
            <td><?php echo $debater->getTeam()->getInstitution()->getName(); ?></td>
            <td>Debater</td>
            <td><?php echo $debater->getTeam()->getName(); ?></td>
        </tr>
<?php endforeach; ?>
<?php foreach($adjudicators as $adjudicator): ?>
        <tr>
            <td><?php echo $adjudicator->getName(); ?></td>
            <td><?php echo $adjudicator->getInstitution()->getName(); ?></td>
            <td>Adjudicator</td>
            <td>-</td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>                

