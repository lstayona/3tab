<script language="JavaScript1.2">

/*
Top-Down scrolling window Script- © Dynamic Drive (www.dynamicdrive.com)
For full source code, visit http://www.dynamicdrive.com
This notice MUST stay intact for use
*/

//change 1 to another integer to alter the scroll speed. Greater is faster
var speed=1
var currentpos=0,alt=1,curpos1=0,curpos2=-1
function initialize(){
startit()
}

function iecompattest(){
return (document.compatMode!="BackCompat")? document.documentElement : document.body
}

function scrollwindow(){
if (document.all)
temp=iecompattest().scrollTop
else
temp=window.pageYOffset
if (alt==0)
alt=1
else
alt=0
if (alt==0)
curpos1=temp
else
curpos2=temp
if (curpos1!=curpos2){
if (document.all)
currentpos=iecompattest().scrollTop+speed
else
currentpos=window.pageYOffset+speed
window.scroll(0,currentpos)
}
else{
currentpos=0
window.scroll(0,currentpos)
}
}
function startit(){
setInterval("scrollwindow()",10)
}
window.onload=initialize
</script>
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

