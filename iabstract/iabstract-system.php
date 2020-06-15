<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Plugin DB Version / Table name       -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
global $iabstract_db_version;
$iabstract_db_version     = '2.0';
$iabstract_table_name     = "iabstract";
$iabstract_table_selected = "iabstract_selected";

/**
* Install the plugin DB
* @return DB Insert/Upgrade
*/
register_activation_hook( __FILE__, 'iabstract_install' );
if ( ! function_exists('iabstract_install') ) {
	function iabstract_install() {
		global $wpdb, $iabstract_db_version, $iabstract_table_name, $iabstract_table_selected;
	
		$iabstract_tbl_note     = $wpdb->prefix . $iabstract_table_name;
		$iabstract_tbl_selected = $wpdb->prefix . $iabstract_table_selected;
		
		$charset_collate = $wpdb->get_charset_collate();
	
		$sql = "CREATE TABLE $iabstract_tbl_note (
				id int(11) NOT NULL AUTO_INCREMENT,
				form_id int(11) NOT NULL,
				entry_id int(11) NOT NULL,
				user_id int(11) NOT NULL,
				date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				note tinyint(4) DEFAULT NULL,
				PRIMARY KEY (id)
			   ) $charset_collate;
			   CREATE TABLE $iabstract_tbl_selected (
				id int(11) NOT NULL AUTO_INCREMENT,
				form_id int(11) NOT NULL,
				entry_id int(11) NOT NULL,
				user_id int(11) NOT NULL,
				date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				selected tinyint(4) NOT NULL DEFAULT '1',
				PRIMARY KEY (id)
			   ) $charset_collate;
		";
	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	
		add_option( 'iabstract_db_version', $iabstract_db_version );
		
		/**
		 * [OPTIONAL] Example of updating to x.x.x version
		 *
		 * If you develop new version of plugin
		 * just increment $iabstract_db_version variable
		 * and add following block of code
		 */
		$installed_ver = get_option('iabstract_db_version');
		if ($installed_ver != $iabstract_db_version) {
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			// notice that we are updating option, rather than adding it
			update_option('iabstract_db_version', $iabstract_db_version);
		}
	}
}

/**
* Insert Post Pages
* @return Insert POST
*/
register_activation_hook( __FILE__, 'iabstract_install_post' );
if ( ! function_exists('iabstract_install_post') ) {
	function iabstract_install_post() {
		global $iabstract_db_version;
		/**
		 * [POST] Create POST IAbstract Main
		 * Create array
		 * Insert POST in DB
		 */
		$iabstract_post_main_guid = site_url() . "/iabstract";
		$iabstract_post_main = array( 'post_title' => wp_strip_all_tags( __('IAbstract', IABSTRACT_ID_LANGUAGES) ),
								  'post_type'      => 'page',
								  'post_name'      => 'iabstract',
								  'post_content'   => '[iabstract]',
								  'post_status'    => 'publish',
								  'comment_status' => 'closed',
								  'ping_status'    => 'closed',
								  'post_author'    => get_current_user_id(),
								  'menu_order'     => 0,
								  'guid'           => $iabstract_post_main_guid );
		// Get Post ID - FALSE to return 0 instead of wp_error / Insert the post
		//$iabstract_post_main_ID = wp_insert_post( $iabstract_post_main, FALSE );
		// Save IAbstract main page url ID
		add_option( 'iabstract_url_complete_id', $iabstract_post_main_ID);
	}
}
	

/**
* Trick to update plugin database
* @return DB Insert/Upgrade DB datas
*/
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Trick to update plugin database       -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
add_action('plugins_loaded', 'iabstract_update_db_check');
if ( ! function_exists('iabstract_update_db_check') ) {
	function iabstract_update_db_check(){
		global $iabstract_db_version;
		if (get_option('iabstract_db_version') != $iabstract_db_version) {
			iabstract_install();
			iabstract_install_post();
		}
	}
}

/**
* Desactivation scheduled Jobs
* @return Clear scheduled Hooks
*/
register_deactivation_hook(__FILE__, 'iabstract_deactivation');
function iabstract_deactivation() {
	wp_clear_scheduled_hook('iabstract_iabstract_changes');
}

?>