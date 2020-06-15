<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');

// ----------------------------------------
// ---------------- AJAX ------------------
// ----------------------------------------
add_action('wp_print_scripts', 'iabstract_ajax_load_scripts');
function iabstract_ajax_load_scripts() {
	if (!is_admin()) {
		$iabstract_options = TitanFramework::getInstance( IABSTRACT_ID );
		// load our jquery file that sends the $.post request
		wp_enqueue_script( "iabstract-ajax-script", IABSTRACT_URL . 'js/iabstract-script.js', array( 'jquery' ) );
		// --- Initialize infos to pass
		$iabstract_note_max = iabstract_get_options( 'note_max' );
		// make the ajaxurl var available to the above script
		$iabstract_option_to_ajax = [
				'iabstract_note_max'  => $iabstract_note_max,  // Get this value in JS like " iabstract_ajax_script.iabstract_note_max "
				//'iabstract_email_infos'   => $iabstract_email,         // Get this value in JS like " iabstract_ajax_script.iabstract_email_infos "
				//'iabstract_child_menu_id' => $iabstract_menu_child_id, // Get this value in JS like " iabstract_ajax_script.iabstract_child_menu_id "
				'ajaxurl'             => admin_url( 'admin-ajax.php'),
		];
		wp_localize_script( 'iabstract-ajax-script', 'iabstract_ajax_script', $iabstract_option_to_ajax );
	}
}
// ----------------------------------------

function iabstract_ajax_process_request() {
	global $wpdb, $iabstract_table_name, $iabstract_table_selected;
	
	// --- Initialization
	$iabstract_tbl_note     = $wpdb->prefix . $iabstract_table_name;
	$iabstract_tbl_selected = $wpdb->prefix . $iabstract_table_selected;
	
	switch($_POST['switch_p']) {
		default:
			echo 'No action';
		break;
		case "user_note":
			// Initialisation
			$user_note   = $_POST['user_note'];
			$user_id     = $_POST['user_id'];
			$form_id     = $_POST['form_id'];
			$abstract_id = $_POST['abstract_id'];
			$note_max    = $_POST['note_max'];
			$first_note  = $_POST['first_note'];
			// --- Check if all variable are OK
			if ( (isset($user_note) && $user_note >= 0)
				&& (isset($user_id) && $user_id > 0)
				&& (isset($form_id) && $form_id > 0)
				&& (isset($abstract_id) && $abstract_id > 0)
				) {
				if ($first_note == 'Y') {
					// --- Insert DB Note
					$insert_note = $wpdb->insert( 
						$iabstract_tbl_note,
						array( 
							'form_id'  => $form_id,     // integer (number)
							'entry_id' => $abstract_id, // integer (number)
							'user_id'  => $user_id,     // integer (number)
							'note'     => $user_note,   // integer (number)
						), 
						array( 
							'%d', // value1
							'%d', // value2
							'%d', // value2
							'%d', // value2
						) 
					);
	
					if ($insert_note) {
						// Updated Note
						echo 'Votre note ('.$user_note.'/'.$note_max.') a été enregistré et attribué à cet abstract.<br>Merci pour votre participation';
					} else {
						// DB Error
						echo "L'enregistrement de votre note a rencontré un problème.<br>Veuillez réessayer ou bien contactez un administrateur.";
					}
				} else {
					// Update DB Note
					$update_note = $wpdb->update( 
						$iabstract_tbl_note, 
						array( 
							'note' => $user_note,   // integer (number) Value 1
						), 
						array(
							'form_id'  => $form_id,     // integer (number)
							'entry_id' => $abstract_id, // integer (number)
							'user_id'  => $user_id,     // integer (number)
						), 
						array( 
							'%d',  // Value 1
						), 
						array(
							'%d',
							'%d',
							'%d',
						) 
					);
					if ($update_note) {
						// Updated Note
						echo 'Votre note ('.$user_note.'/'.$note_max.') a été enregistré et modifié pour cet abstract.<br>Merci pour votre participation';
					} else {
						// DB Error
						echo "La modification de votre note a rencontré un problème.<br>Veuillez réessayer ou bien contactez un administrateur.";
					}
				}
			} else {
				// Error Missing Variables
				echo 'Erreur de traitement';
			}
		break;
		case "user_select":
			// Initialisation
			$user_id     = $_POST['user_id'];
			$form_id     = $_POST['form_id'];
			$abstract_id = $_POST['abstract_id'];
			// --- Check if all variable are OK
			if ( (isset($user_id) && $user_id > 0)
				&& (isset($form_id) && $form_id > 0)
				&& (isset($abstract_id) && $abstract_id > 0)
				) {
				// --- Insert DB Note
				$insert_select = $wpdb->insert( 
					$iabstract_tbl_selected,
					array( 
						'form_id'  => $form_id,     // integer (number)
						'entry_id' => $abstract_id, // integer (number)
						'user_id'  => $user_id,     // integer (number)
					), 
					array( 
						'%d', // value1
						'%d', // value2
						'%d', // value2
					) 
				);

				if ($insert_select) {
					// Updated Note
					echo 'Vous venez de sélectionner cet abstract.<br>Merci pour votre participation';
				} else {
					// DB Error
					echo "L'enregistrement de la sélection a rencontré un problème.<br>Veuillez réessayer ou bien contactez un administrateur.";
				}
			} else {
				// Error Missing Variables
				echo 'Erreur de traitement';
			}
		break;
	}

	// ----------
	die();
	// ----------
}
add_action( 'wp_ajax_iabstract_response', 'iabstract_ajax_process_request' );         // ADMIN
add_action( 'wp_ajax_nopriv_iabstract_response', 'iabstract_ajax_process_request' );  // FRONT

?>