<?php use_helper("Form"); ?>
<h1>Participant check-in for <?php echo RoundPeer::getCurrentRound()->getName(); ?></h1>
<?php echo form_tag("checkin/participantConfirmation", array("method"=>"GET")); ?>
<table id="form">
    <tbody>
        <tr>
            <td>Enter your name</td>
            <td>
                <?php echo input_tag("participant_name", null, array("size" => 60)); ?>
                <span class="error"><?php echo $sf_request->getError("participant_name"); ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2"><?php echo submit_tag("Find me"); ?></td>
        </tr>
    </tbody>
</table>
</form>
