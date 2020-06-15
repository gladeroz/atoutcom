<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');

/**
 * Shortcode GENERAL
 * This method return HTML to display in FRONT page with Shortcode
 * [iabstract]
 *
 * @return HTML
 */
function iabstract_shortcode_general($param, $content) {
	global $wpdb, $iabstract_table_name, $iabstract_table_selected;
	// --------------------------------------
	$iabstract_tbl_note         = $wpdb->prefix . $iabstract_table_name;
	$iabstract_tbl_selected     = $wpdb->prefix . $iabstract_table_selected;
	// --- Initialize
	$IABSTRACT_REQUEST_PROTOCOL = (iabstract_is_secure()) ? 'https' : 'http';
	$iabstract_url_current      = "$IABSTRACT_REQUEST_PROTOCOL://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$iabstract_page_used        = basename(parse_url($iabstract_url_current, PHP_URL_PATH)) . '/';
	$iabstract_uri_parts        = explode('?', $_SERVER['REQUEST_URI'], 2);
	$iabstract_get_site_url     = "$IABSTRACT_REQUEST_PROTOCOL://$_SERVER[HTTP_HOST]" . $iabstract_uri_parts[0]; // Without args
	$iabstract_general          = "";
	// --- Actions
	$action = (isset($_GET['a'])) ? trim($_GET['a']) : '';

	// --- Initialize
	$iabstract_options = TitanFramework::getInstance( IABSTRACT_ID );
	// --- Options
	$iabstract_authorized_members = iabstract_get_options( 'authorized_members' );
	$iabstract_introduction       = iabstract_get_options( 'introduction' );
	
	
	switch($action) {
		default:
			// --- Templates path
			$action_default = 'default';
			$iabstract_template = IABSTRACT_PATH . 'templates' . DIRECTORY_SEPARATOR . IABSTRACT_ID . '-template-' . $action_default . '.php';
			// --- Show Template
			$iabstract_general .= include_once($iabstract_template);
		break;
	}
		
}

add_shortcode('iabstract', 'iabstract_shortcode_general');

// --------------------------------------------------------------

?>