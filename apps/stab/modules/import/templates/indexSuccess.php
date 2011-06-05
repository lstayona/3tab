<h1>Import <?php echo $sf_request->getParameter("target_model", null); ?></h1>
<hr />
<?php if($sf_request->hasParameter("messages")): ?>
<div id="messages">
    <?php foreach($sf_request->getParameter("messages", array()) as $id => $message): ?>
    <div id="<?php echo $id;?>"><?php echo $message;?></div>
    <?php endforeach; ?>
</div>

<?php endif; ?>
<?php if($sf_request->hasErrors()): ?>

<div id="errors">
    <?php foreach($sf_request->getErrors() as $id => $error): ?>
    <div id="<?php echo $id;?>"><?php echo $error;?></div>
    <?php endforeach; ?>
</div>

<?php endif; ?>
<?php echo form_tag ('import/import', array ('multipart' => true)); ?>
    <table id="form">
		<tbody>
			<tr>
				<th>Data</th>
				<td>
				<?php echo select_tag("target_model", options_for_select(
					array('Institution' => 'Institution', 'Team' => 'Team', 
					'Debater' => 'Debater', 'Adjudicator' => 'Adjudicator', 
					'Venue' => 'Venue'), 
					$sf_request->getParameter("target_model")),
					array('width' => '200px'));
				?>				
				</td>
			</tr>
			
			<tr>
				<th>CSV file</th>
				<td><?php echo input_file_tag('csv_file', array ())?></td>
			</tr>
			
			<tr>
				<th>Update</th>
				<td><?php echo checkbox_tag("update", true, true); ?></td>
			</tr>
		</tbody>
	</table>

<hr />	
	<div id="button">
	<?php echo submit_tag("Import", array('id' => 'import', 'name' => 'import')); ?>
	</div>
</form>
