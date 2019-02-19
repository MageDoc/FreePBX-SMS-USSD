<?php

/**
 * <this raw module name>_hook_<hooked raw module name>
 *
 * This function allows one to hook html into many different modules' pages to display html/information
 * In this example we have hooked into blacklist
 *
 * @return string The return HTML to send back
 */
function smsussd_hook_blacklist() {
	return;
	$html = '';
	$html = '<tr><td colspan="2"><h5>';
	$html .= _("SMS USSD Hook");
	$html .= '<hr></h5></td></tr>';
	$html .= '<tr><td><a href="#" class="info">';
	$html .= _("This is the Text for the item").'<span>'._("Popup Help Descriptions").'.</span></a>';
	$html .= '</td><td>';
	$html .= 'This is the item';
	$html .= '</td></tr>';

	return $html;
}

/**
 * <this raw module name>_hookProcess_<hooked raw module name>
 *
 * This function allows one to process data that was saved on the hooked raw module page
 * 
 * @param $viewing_itemid string the id of the item being viewed
 * @param $request array php's $_REQUEST array
 * @return bool true successful or false if not
 */
function smsussd_hookProcess_blacklist($viewing_itemid, $request) {
}

function smsussd_configpageinit($pagename) {
	//smsussd_applyhooks();
}

function smsussd_applyhooks() {
    global $currentcomponent;

    // Add the 'process' function - this gets called when the page is loaded, to hook into
    // displaying stuff on the page.
    $currentcomponent->addguifunc('smsussd_configpageload');
}


function smsussd_configpageload() {
	global $currentcomponent, $endpoint, $db;
	$section = _('Hooker');
	$currentcomponent->addguielem($section, new gui_drawselects('hooker_box', 50, '', 'GUI Item Name', 'Gui Item Help Text'), 9);
}

function messages_list($device_id=null, $compound=true) {

  static $initialized=false;
  static $full_list;
  static $filter_list=array();

  if ($initialized) {
    return ($compound ? $full_list : $filter_list);
  }
  $initialized=true;

        $sql = "SELECT * FROM  asteriskcdrdb.message ";
	if($device_id) {
	    $sql .= " WHERE device_id = '{$device_id}'";
	}
	$sql .= " ORDER BY message_id DESC LIMIT 100";
	sql('SET names utf8;');
        $full_list = sql($sql,'getAll',DB_FETCHMODE_ASSOC);

        // Make array backward compatible, put first 4 columns as numeric
        $count = 0;
        foreach($full_list as $item) {
                $full_list[$count][0] = $item['message_id'];
                $full_list[$count][1] = $item['device_id'];
                $full_list[$count][2] = $item['direction'];
                $full_list[$count][3] = $item['type'];
		$full_list[$count][4] = $item['number'];
		$full_list[$count][5] = $item['text'];
		$full_list[$count][6] = $item['created_at'];
                //if (strstr($item['device_id'],'&') == $device_id) {
    		     $filter_list[] = $full_list[$count];
                //}
                $count++;
        }
  return ($compound ? $full_list : $filter_list);
}

function message_send($data = null) {
	global $astman;
        global $db;
        global $amp_conf;
	$columns = array(
	    'device_id', 
	    'direction' => 'outbound', 
	    'type'	=> 'ussd',
	    'number',
	    'text',
	    'created_at' => date('Y-m-d H:i:s'),
	    'recieved_at' => date('Y-m-d H:i:s')
	);
	$values = array();
	foreach ($columns as $key => $value){
	    if (is_numeric($key)){
		$key = $value;
		$value = isset($_REQUEST[$key]) ? $_REQUEST[$key] : '';
	    }
	    $values[$key] = $db->escapeSimple($value);
	}
	$keys = implode(', ', array_keys($values));
	$astman->command("dongle ussd {$values['device_id']} {$values['number']}");
	$values = implode('\', \'', $values);
        $sql = "INSERT INTO asteriskcdrdb.message ( {$keys} ) VALUES ('{$values}')";
        $result = $db->query($sql);
	//die_freepbx($sql);
        if(DB::IsError($result)) {
                die_freepbx($result->getMessage().$sql);
        }
        if(method_exists($db,'insert_id')) {
                $id = $db->insert_id();
        } else {
                $id = $amp_conf["AMPDBENGINE"] == "sqlite3" ? sqlite_last_insert_rowid($db->connection) : mysql_insert_id($db->connection);
        }
        return($id);
}

/**
 * Decode 7-bit packed PDU messages
 */
if ( !function_exists( 'hex2bin' ) ) {
    // pre 5.4 fallback
    function hex2bin( $str ) {
        $sbin = "";
        $len = strlen( $str );
        for ( $i = 0; $i < $len; $i += 2 ) {
            $sbin .= pack( "H*", substr( $str, $i, 2 ) );
        }

        return $sbin;
    }
}

function pdu2str($pdu) {
    // chop and store bytes
    $number = 0;
    $bitcount = 0;
    $output = '';
    while (strlen($pdu)>1) {
        $byte = ord(hex2bin(substr($pdu,0,2)));
        $pdu=substr($pdu, 2);
        $number += ($byte << $bitcount);
        $bitcount++ ;
        $output .= chr($number & 0x7F);
        $number >>= 7;
        if (7 == $bitcount) {
            // save extra char
            $output .= chr($number);
            $bitcount = $number = 0;
        }
    }
    return $output;
}
