<?php
/**
 * IResa
 *
 * @package     IAbstract
 * @author      INFORMATUX (Patrice BOUTHIER)
 * @copyright   2018 INFORMATUX
 * @license     GPL-3.0+
 *
 * @iabstract
 * Plugin Name: IAbstract
 * Description: Gestion des Abstracts
 * Version:     1.0.1
 * Author:      Patrice BOUTHIER
 * Author URI:  https://informatux.com
 * Text Domain: iabstract
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

/* --- Session Start --- */
@session_start();

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Define constants                      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('IABSTRACT_PATH') or define('IABSTRACT_PATH', plugin_dir_path(__FILE__));
defined('IABSTRACT_URL') or define('IABSTRACT_URL', plugin_dir_url(__FILE__));
defined('IABSTRACT_BASE') or define('IABSTRACT_BASE', plugin_basename(__FILE__));
defined('IABSTRACT_ID') or define('IABSTRACT_ID', 'iabstract');
defined('IABSTRACT_ID_LANGUAGES') or define('IABSTRACT_ID_LANGUAGES', 'iabstract-translate');
defined('IABSTRACT_COOKIE') or define('IABSTRACT_COOKIE', 'iabstract_cookie');
defined('IABSTRACT_CRON_SCHEDULE') or define('IABSTRACT_CRON_SCHEDULE', 'daily');
defined('IABSTRACT_VERSION') or define('IABSTRACT_VERSION', '1.0.1');
defined('IABSTRACT_BAR_LINK_SEPARATOR') or define('IABSTRACT_BAR_LINK_SEPARATOR', '&nbsp;&nbsp;');

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Load plugin translations              -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
add_action( 'plugins_loaded', 'iabstract_translate_load_textdomain', 1 );
if ( ! function_exists( 'iabstract_translate_load_textdomain' ) ) {
	function iabstract_translate_load_textdomain() {
		$path = basename( dirname( __FILE__ ) ) . '/languages/';
		load_plugin_textdomain( IABSTRACT_ID_LANGUAGES, false, $path );
	}
}

defined('IABSTRACT_NAME') or define('IABSTRACT_NAME', 'IAbstract');

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Load plugin files                     -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
if ( ! function_exists( 'is_plugin_active' ) )
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Include Titan Framework               -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$titan_check_framework_install = 'titan-framework/titan-framework.php';
// --- Check if plugin titan framework is installed
if (is_plugin_active($titan_check_framework_install)) {
	require_once(WP_CONTENT_DIR . '/plugins/titan-framework/titan-framework-embedder.php');
} else {
	require_once(IABSTRACT_PATH . 'lib/titan-framework/titan-framework-embedder.php');
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Initialize plugin SQL Debug Mode      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('_IABSTRACT_DEBUG') or define('_IABSTRACT_DEBUG', true);

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Initialize plugin Files               -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$iabstractClasses = ['lists', 'type', 'plat', 'transport', 'order', 'cron', 'widget'];
foreach ($iabstractClasses as $iabstractClass) {
	$class = IABSTRACT_PATH . 'class' . DIRECTORY_SEPARATOR . IABSTRACT_ID . '-class-' . $iabstractClass . '.php';
    if (file_exists($class)) require_once($class);
}
$iabstractFiles = ['system', 'interface', 'style', 'functions', 'ajax'];
foreach ($iabstractFiles as $iabstractFile) {
	$file = IABSTRACT_PATH . IABSTRACT_ID . '-' . $iabstractFile . '.php';
    if (file_exists($file)) require_once($file);
}
$iabstractShortcodes = ['general'];
foreach ($iabstractShortcodes as $iabstractShortcode) {
	$shortcode = IABSTRACT_PATH . 'shortcodes' . DIRECTORY_SEPARATOR .  IABSTRACT_ID . '-shortcode-' . $iabstractShortcode . '.php';
    if (file_exists($shortcode)) require_once($shortcode);
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//         Pixel Stat Meta links         -=
//            in plugins page            -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
if ( ! function_exists( 'iabstract_plugin_row_meta' ) ) {
    function iabstract_plugin_row_meta( $links, $file ) {
        if (strpos($file, IABSTRACT_BASE) !== false) {
            $new_links = array(
                'donate' => '<a href="https://paypal.me/informatux/25" target="_blank"><span class="dashicons dashicons-star-filled"></span>' . __( 'Donate', IABSTRACT_ID_LANGUAGES ) . '</a>',
                'cv' => '<a href="https://cv.informatux.com/" target="_blank"><span class="dashicons dashicons-id-alt"></span>' . __( 'About', IABSTRACT_ID_LANGUAGES ) . '</a>'
            );
            
            $links = array_merge($links, $new_links);
        }
        
        return $links;
    }
}
add_filter( 'plugin_row_meta', 'iabstract_plugin_row_meta', 10, 2 );
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//        Pixel Stat Get Infos           -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( ! function_exists( 'iabstract_get_version' ) ) {
    function iabstract_get_version( $iabstract_infos = 'Version' ) {
    
        /* *************************************************************************************
         *
         * 'Name' - Name of the plugin, must be unique.
         * 'Title' - Title of the plugin and the link to the plugin's web site.
         * 'Description' - Description of what the plugin does and/or notes from the author.
         * 'Author' - The author's name
         * 'AuthorURI' - The authors web site address.
         * 'Version' - The plugin version number.
         * 'PluginURI' - Plugin web site address.
         * 'TextDomain' - Plugin's text domain for localization.
         * 'DomainPath' - Plugin's relative directory path to .mo files.
         * 'Network' - Boolean. Whether the plugin can only be activated network wide.
         *
         * ********************************************************************************** */
    
        $plugin_data = get_plugin_data( __FILE__ );
        $plugin_version = $plugin_data[ "$iabstract_infos" ];
        return $plugin_version;
    }
}
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

?>