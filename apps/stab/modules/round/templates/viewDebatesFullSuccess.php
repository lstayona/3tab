<?php
// auto-generated by sfPropelCrud
// date: 2008/04/20 19:00:01
?>

<?php use_helper('Object') ?>

<?php echo form_tag('round/viewDebatesFull') ?>

<h1> Select a round </h1>
<table>
<tbody>
<tr>
	<td>
		
		<?php echo select_tag('round', objects_for_select($rounds, 'getId', 'getName')) ?>

	</td>
</tr>


</tbody>
</table>
<?php echo submit_tag('select') ?>

