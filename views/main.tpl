<h2>SMS &amp; USSD</h2>

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