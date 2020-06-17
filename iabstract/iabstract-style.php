<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Add CSS stylesheet to front           -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
add_action( 'wp_enqueue_scripts', 'iabstract_styles' );
function iabstract_styles() {
  wp_register_style( 'iabstract_css', IABSTRACT_URL . 'css/iabstract-style.css', false, IABSTRACT_VERSION );
  wp_enqueue_style( 'iabstract_css' );
	// --------------------------------------
	wp_register_style( 'iabstract_awesome_css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false, '4.7.0' );
  wp_enqueue_style( 'iabstract_awesome_css' );
	// --------------------------------------
	wp_register_style( 'iabstract_datatable_css', 'https://nightly.datatables.net/css/jquery.dataTables.css', false );
	wp_enqueue_style( 'iabstract_datatable_css' );
	// --------------------------------------
	wp_register_style( 'iabstract_confirm_css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css', false );
	wp_enqueue_style( 'iabstract_confirm_css' );
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Add JS Scripts to front               -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
add_action( 'wp_enqueue_scripts', 'iabstract_script_method' );
function iabstract_script_method() {
	wp_enqueue_script( 'iabstract-script', IABSTRACT_URL . 'js/iabstract-script.js', array( 'jquery' ) );
	// --------------------------------------
	wp_enqueue_script( 'iabstract-script-datatables', 'https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js', array( 'jquery' ) );
	// --------------------------------------
	//wp_enqueue_script( 'iabstract-script-datatables-select', 'https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js', array( 'jquery' ) );
	// --------------------------------------
	wp_enqueue_script( 'iabstract-script-confirm', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js', array( 'jquery' ) );
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Add CSS stylesheet to admin           -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
add_action( 'admin_enqueue_scripts', 'iabstract_admin_styles' );
function iabstract_admin_styles() {
    wp_register_style( 'iabstract_admin_css', IABSTRACT_URL . 'css/iabstract-style-admin.css', false, IABSTRACT_VERSION );
    wp_enqueue_style( 'iabstract_admin_css' );

	// --------------------------------------
	wp_register_style( 'iabstract_admin_bootstrap', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false );
	wp_enqueue_style( 'iabstract_admin_bootstrap' );
	// --------------------------------------
	wp_register_style( 'iabstract_admin_datatable', 'https://nightly.datatables.net/css/jquery.dataTables.css', false );
	wp_enqueue_style( 'iabstract_admin_datatable' );
	// --------------------------------------
	wp_register_style( 'iabstract_confirm_css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css', false );
	wp_enqueue_style( 'iabstract_confirm_css' );
	// --------------------------------------
	wp_register_style( 'iabstract_awesome_css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false, '4.7.0' );
    wp_enqueue_style( 'iabstract_awesome_css' );
}
// ----------------------------------------
add_action( 'admin_enqueue_scripts', 'iabstract_awesome_admin_styles' );
if (!function_exists('iabstract_awesome_admin_styles')) {
	function iabstract_awesome_admin_styles() {
		wp_register_style( 'iabstract_awesome_admin_css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false, '4.7.0' );
		wp_enqueue_style( 'iabstract_awesome_admin_css' );
	}
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Add JS Scripts to admin               -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
add_action( 'admin_enqueue_scripts', 'iabstract_script_admin_method' );
function iabstract_script_admin_method() {
	wp_enqueue_script( 'iabstract-script-admin', IABSTRACT_URL . 'js/iabstract-script-admin.js', array( 'jquery' ) );
	// --------------------------------------
	wp_enqueue_script( 'iabstract-script-datatables', 'https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js', array( 'jquery' ) );
	// --------------------------------------
	//wp_enqueue_script( 'iabstract-script-datatables-select', 'https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'iabstract-script-confirm', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js', array( 'jquery' ) );
}

// <script src="https://code.jquery.com/jquery-3.1.0.js"></script>


?>