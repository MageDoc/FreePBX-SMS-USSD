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
	smsussd_applyhooks();
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
