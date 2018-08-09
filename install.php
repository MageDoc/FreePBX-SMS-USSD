<?php
/* FreePBX installer file
 * This file is run when the module is installed through module admin
 *
 * Note: install.sql is depreciated and may not work. Its recommended to use this file instead.
 * 
 * If this file returns false then the module will not install
 * EX:
 * return false;
 *
 */
$sql = "CREATE TABLE IF NOT EXISTS magedoc_smsussd_settings (
`key` varchar(255) NOT NULL default '',
`value` varchar(255) NOT NULL default '',
PRIMARY KEY (`key`)
);";

$check = sql($sql);
if (DB::IsError($check)) {
        die_freepbx( "Can not create `SmsUssd` table: " . $check->getMessage() .  "\n");
}

$sql = "CREATE TABLE IF NOT EXISTS `message` (
 `message_id` int(11) NOT NULL AUTO_INCREMENT,
 `device_id` varchar(20) NOT NULL,
 `type` varchar(10) NOT NULL,
 `number` varchar(16) DEFAULT NULL,
 `text` varchar(255) NOT NULL,
 `recieved_at` datetime NOT NULL,
 `notified_at` datetime DEFAULT NULL,
 `direction` varchar(40) NOT NULL DEFAULT 'inbound',
 `status` varchar(40) NOT NULL DEFAULT 'received',
 `created_at` datetime NOT NULL,
 PRIMARY KEY (`message_id`),
 KEY `device_id` (`device_id`),
 KEY `type` (`type`),
 KEY `number` (`number`),
 KEY `direction` (`direction`)
) ENGINE=InnoDB AUTO_INCREMENT=33760 DEFAULT CHARSET=utf8;";

$check = sql($sql);
if (DB::IsError($check)) {
        die_freepbx( "Can not create `message` table: " . $check->getMessage() .  "\n");
}