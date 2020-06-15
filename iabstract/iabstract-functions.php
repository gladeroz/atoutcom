<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

/**
 * Show date ISO in various format (Pixel Stat)
 * This method return string to display
 *
 * @param	$date		Date ISO Format from MySQL
 * @param	$format		Format to return (ISO, US, UST, FR, FRT, FRH, YEAR)
 *
 * @return converted string
 */
if (!function_exists('iabstract_convert_date')) {
	function iabstract_convert_date($date, $format = 'ISO') {
		//date_default_timezone_set('Europe/Paris');
		//setlocale(LC_ALL, array('fr_FR.UTF-8','fr_FR@euro','fr_FR','french'));
		iabstract_get_locale();
		switch(strtoupper($format)) {
			// Format ISO (AAAA-MM-DD)
			default: return strftime("%F", strtotime($date)); break;
			// Format US (MM-DD-AAAA)
			case "US": return strftime("%m/%d/%Y", strtotime($date)); break;
			// Format US (MM-DD-AAAA HH:mm:ss)
			case "UST": return strftime("%m/%d/%Y %T", strtotime($date)); break;
			// Format FR (DD-MM-AAAA)
			case "FR": return strftime("%d/%m/%Y", strtotime($date)); break;
			// Format FR (DD-MM-AAAA HH:mm:ss) with time
			case "FRT": return strftime("%d-%m-%Y %T", strtotime($date)); break;
			// Format FRH (DD MM AAAA) Human readable
			case "FRH": return strftime("%e %B %Y", strtotime($date)); break;
			// Year (AAAA)
			case "YEAR": return strftime("%Y", strtotime($date)); break;
		}
	}
}

/**
 * Get all lists from Database (Pixel Stat)
 * This method return Array to display
 *
 * @param	$where	Where SQL clause
 *
 * @return array
 */
if (!function_exists('iabstract_get_lists_limit')) {
	function iabstract_get_lists_limit($limit = 5) {
		global $wpdb, $iabstract_table_name;
		
		// --- Initialize
		$all_lists       = false;
		$table_name_list = $wpdb->prefix . $iabstract_table_name;
		// Get all list from user_id
		$sql_request =
			"SELECT t1.id, t1.date, t1.name, count(t2.id) AS count_products
			 FROM $table_name_list AS t1
			 LEFT JOIN $table_name_data AS t2 ON (t1.id = t2.list_id)
			 WHERE t1.active = '1'
			 GROUP BY t1.id, t1.date, t1.name
			 LIMIT $limit";
		$all_lists = $wpdb->get_results( $sql_request );

		return $all_lists;
	}
}

/**
* Return a string to truncate
* @param string $string
* @param int $max
* @param string $replacement
* @return string truncated
*/
if (!function_exists('iabstract_truncate')) {
	function iabstract_truncate($string, $max = 20, $replacement = '...') {
		if (strlen($string) <= $max) {
			return $string;
		}
		$leave = $max - strlen ($replacement);
		return substr_replace($string, $replacement, $leave);
	}
}

/**
* Searches text for unwanted tags and removes them
* @param string $text String to purify
* @return string $text The purified text
*/
if (!function_exists('iabstract_stop_XSS')) {
	function iabstract_stop_XSS($text) {
		if (!is_array($text)) {
			$text = preg_replace("/\(\)/si", "", $text);
			$text = strip_tags($text);
			$text = str_replace(array("\"",">","<","\\"), "", $text);
		} else {
			foreach($text as $k=>$t) {
				if (is_array($t)) {
					StopXSS($t);
				} else {
					$t = preg_replace("/\(\)/si", "", $t);
					$t = strip_tags($t);
					$t = str_replace(array("\"",">","<","\\"), "", $t);
					$text[$k] = $t;
				}
			}
		}
		return $text;
	}
}

/**
 * Check whether URL is HTTPS/HTTP
 * @return boolean [description]
 */
if (!function_exists('iabstract_is_secure')) {
	function iabstract_is_secure() {
		if (
			( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
			|| ( ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
			|| ( ! empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
			|| (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
			|| (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
			|| (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
		) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Bar links plugin IABSTRACT
 * @return html
 */
if (!function_exists('iabstract_bar_links')) {
	function iabstract_bar_links($active = '') {
		// ---------------------------------------
		$iabstract_bar_links  = '<div class="iabstract-bar-links">';
		// ---------------------------------------
		$iabstract_bar_links .= '<a class="button" href="' . get_admin_url(get_current_blog_id(), 'admin.php?page=iabstract') . '">' . __('Dashboard', IABSTRACT_ID_LANGUAGES) . '</a>' . IABSTRACT_BAR_LINK_SEPARATOR;
		// ---------------------------------------
		$iabstract_bar_links .= '<a class="button" href="' . get_admin_url(get_current_blog_id(), 'admin.php?page=iabstract&tab=steps') . '">' . __('Steps', IABSTRACT_ID_LANGUAGES) . '</a>' . IABSTRACT_BAR_LINK_SEPARATOR;
		// ---------------------------------------
		$iabstract_bar_links .= '<a class="button" href="' . get_admin_url(get_current_blog_id(), 'admin.php?page=iabstract&tab=spaces') . '">' . __('Spaces', IABSTRACT_ID_LANGUAGES) . '</a>' . IABSTRACT_BAR_LINK_SEPARATOR;
		// ---------------------------------------
		$iabstract_active     = ($active == 'Orders') ? ' active': '';
		$iabstract_bar_links .= '<a class="button'.$iabstract_active.'" href="' . get_admin_url(get_current_blog_id(), 'admin.php?page=iabstract_order') . '">' . __('Orders', IABSTRACT_ID_LANGUAGES) . '</a>' . IABSTRACT_BAR_LINK_SEPARATOR;
		// ---------------------------------------
		$iabstract_active     = ($active == 'Menus') ? ' active': '';
		$iabstract_bar_links .= '<a class="button'.$iabstract_active.'" href="' . get_admin_url(get_current_blog_id(), 'admin.php?page=iabstract_menu') . '">' . __('Menus', IABSTRACT_ID_LANGUAGES) . '</a>' . IABSTRACT_BAR_LINK_SEPARATOR;
		// ---------------------------------------
		$iabstract_active     = ($active == 'Plats') ? ' active': '';
		$iabstract_bar_links .= '<a class="button'.$iabstract_active.'" href="' . get_admin_url(get_current_blog_id(), 'admin.php?page=iabstract_plat') . '">' . __('Plats', IABSTRACT_ID_LANGUAGES) . '</a>' . IABSTRACT_BAR_LINK_SEPARATOR;
		// ---------------------------------------
		$iabstract_active     = ($active == 'Plat types') ? ' active': '';
		$iabstract_bar_links .= '<a class="button'.$iabstract_active.'" href="' . get_admin_url(get_current_blog_id(), 'admin.php?page=iabstract_type') . '">' . __('Plat types', IABSTRACT_ID_LANGUAGES) . '</a>' . IABSTRACT_BAR_LINK_SEPARATOR;
		// ---------------------------------------
		$iabstract_active     = ($active == 'Transports') ? ' active': '';
		$iabstract_bar_links .= '<a class="button'.$iabstract_active.'"href="' . get_admin_url(get_current_blog_id(), 'admin.php?page=iabstract_transport') . '">' . __('Transports', IABSTRACT_ID_LANGUAGES) . '</a>';
		$iabstract_bar_links .= '</div>';
		echo $iabstract_bar_links;
	}
}

/**
* Replace in string invalid characters for JSON format
* @param string $text String to purify
* @return string $text The purified text
*/
if (!function_exists("iabstract_htmlconvert")) {
	function iabstract_htmlconvert($string) {
		//$first   = strip_tags($string);
		$search  = ["’", "'", ",", "<", ">", "<br>", "<br />", "<br/>", "\r",  "\n",  "\r\n",  "\n\r"];
		$replace = ["'", "'", ",", "<", ">", " ",    " ",      " ",     " ",   " ",   " "  ,   " "];
		$return  = str_replace($search, $replace, $string);
		
		return $return;
	}
}

/**
 * Check locale WP Site
 * @return LC_TIME (setlocale)
 */
if (!function_exists("iabstract_get_locale")) {
	function iabstract_get_locale() {
		$iabstract_locale_wp = get_locale();
		if ($iabstract_locale_wp == 'fr_FR')
			setlocale(LC_TIME, "fr_FR.utf8", "fra");
		else {
			setlocale(LC_TIME, "$iabstract_locale_wp.utf8", "fra");
		}
	}
}

/**
 * Encode / Decode a key with salt
 * @return encode/decode key (string)
 */
function iabstract_rand_key($string, $action = 'encode') {
	if ($action == 'encode')
		return base64_encode($string);
	else
		return base64_decode($string);
}

/**
 * Get time from WP
 * @return unixtime with GMT
 */
function iabstract_time() {
    $gmt_offset_in_hours = +1; // for GMT-+1 (EDIT this value) 
    return time() + $gmt_offset_in_hours * HOUR_IN_SECONDS;     
}

/**
 * Get option from DB WP
 * @return string
 */
if (!function_exists("iabstract_get_options")) {
	function iabstract_get_options($option_name) {
		$iabstract_options = TitanFramework::getInstance( IABSTRACT_ID );
		return $iabstract_options->getOption( $option_name );
	}
}


?>