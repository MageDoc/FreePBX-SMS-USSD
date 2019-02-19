<h2>SMS &amp; USSD</h2>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <fieldset>
	<input type="hidden" name="display" value="smsussd" />
	<table>
	    <tbody>
	        <tr>
        	    <td>Dongle</td>
		    <td>
	<select name="device_id" onchange="form.submit();">
	    <option value="">All</option>
	    <?php foreach (core_trunks_listbyid() as $trunk): ?>
		<?php if(strpos($trunk['channelid'], 'Dongle/') === 0): ?>
		<?php $deviceid = explode('/', $trunk['channelid']); $deviceid[1]; ?>
		<option <?php if ($device_id == $deviceid[1]) echo 'selected="selected"' ?> value="<?php echo $deviceid[1] ?>"><?php echo $trunk['name'] . " ({$deviceid[1]})"?></option>
		<?php endif; ?>
	    <?php endforeach; ?>
	</select>
		    </td>
		</tr>
	<?php if ($device_id):?>
		<tr>
                    <td>Number</td>
                    <td><input type="text" name="number"/></td>
                </tr>
		<tr>
                    <td>Text</td>
                    <td><textarea name="text"></textarea></td>
                </tr>
		<tr>
		    <td colspan="2">
			<input name="Send" type="submit" value="Send" tabindex="53" class="ui-button ui-widget ui-state-default ui-corner-all" role="button">
		    </td>
		</tr>
	<?php endif; ?>
	    </tbody>
	</table>
    </fieldset>
</form>

<h5>Message History</h5>
<table>
    <thead>
	<tr>
	    <th>Created At</th>
	    <th>Device</th>
	    <th>Direction</th>
	    <th>Type</th>
	    <th>Number</th>
	    <th>Text</th>
	</tr>
    </thead>
    <tbody>
<?php foreach (messages_list($device_id) as $message):?>
	<tr>
	    <td><?php echo $message['created_at']; ?></td>
	    <td><?php echo $message['device_id']; ?></td>
	    <td><?php echo $message['direction']; ?></td>
	    <td><?php echo $message['type']; ?></td>
	    <td><?php echo $message['number']; ?></td>
	    <td><?php echo $message['text']; ?></td>
	</tr>
<?php endforeach; ?>
    </tbody>
</table>
<!--
<h5>Is Asterisk Manager Connected? <?php echo ($astmanconnected) ? 'Yes' : 'No';?></h5>

<h5>Available Asterisk Manager Commands?<hr></h5>
<textarea rows="20" cols="180">
<?php foreach($listcommands as $command => $description) {?>
<?php echo $command?>=><?php echo $description . "\n"?>
<?php } ?>
</textarea>

<h5>Full Asterisk Internal Database?<hr></h5>
<textarea rows="20" cols="180">
<?php foreach($astdatabase as $family => $value) {?>
<?php echo $family?>=><?php echo $value . "\n"?>
<?php } ?>
</textarea>

<h5>Available AMP Configuration Globals?<hr></h5>
<textarea rows="20" cols="180">
<?php foreach($amp_conf as $command => $description) {?>
<?php echo $command?>=><?php echo $description . "\n"?>
<?php } ?>
</textarea>
-->