<?php
// ------------------------------------------------
// if uninstall.php is not called by WordPress, die
// ------------------------------------------------
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
// ------------------------------------------------

// ----------------------------
// Initialization
// ----------------------------
global $wpdb;
$iabstract_tbl_note = $wpdb->prefix . "iabstract";

// ----------------------------
// Drop database table
// ----------------------------
// Tables
$wpdb->query("DROP TABLE IF EXISTS $iabstract_tbl_note");
// ----------------------------

// -------------- 
// Delete Options
// --------------
$options = [
	 'iabstract_authorized_members'
	,'iabstract_form_gf_id'
	,'iabstract_note_max'
	,'iabstract_introduction'
	,'iabstract_db_version'
	,'iabstract_credits'
];
// --------------
foreach ( $options as $option ) {
	if ( get_option( $option ) ) {
		delete_option( $option );
	}
}

?>