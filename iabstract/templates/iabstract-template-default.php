<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');

// ------------------------------------
// --- Sets locale information (FR)
// ------------------------------------
iabstract_get_locale();

// ------------------------------------
// --- Get current user id
// ------------------------------------
//var_dump(get_current_user_id());die();
$iabstract_get_current_user_id = get_current_user_id();
//echo 'user ID: '.$iabstract_get_current_user_id;

// ------------------------------------
// --- Check if User is an Authorized member to view/note the abstracts
// ------------------------------------
if ($iabstract_get_current_user_id > 0 && in_array($iabstract_get_current_user_id, $iabstract_authorized_members)) {
	// ------------------------------------
	// --- User infos
	// ------------------------------------
	$iabstract_user_infos = get_userdata($iabstract_get_current_user_id);
	// ------------------------------------
	// --- Show TITLE
	// ------------------------------------
	echo '<h3>';
	echo "Bienvenue " . $iabstract_user_infos->display_name;
	echo '</h3>';
	// ------------------------------------
	if (isset($iabstract_introduction) && $iabstract_introduction != '') {
		echo '<div class="iabstract_header">';
		echo $iabstract_introduction;
		echo '</div>';
	}
	// ------------------------------------
	// Show entries DataTable
	// ------------------------------------
	$iabstract_gf_form_id               = iabstract_get_options( 'form_gf_id' );
	$iabstract_gf_search_criteria       = array('status' => 'active');
	$iabstract_gf_sorting               = array();
	$iabstract_gf_paging                = array( 'offset' => 0, 'page_size' => 200 );
	$iabstract_gf_entries               = GFAPI::get_entries( $iabstract_gf_form_id, $iabstract_gf_search_criteria, $iabstract_gf_sorting, $iabstract_gf_paging );
	$iabstract_gf_entries_count         = count( $iabstract_gf_entries );
	$iabstract_note_max                 = iabstract_get_options( 'note_max' );
	$iabstract_authorized_members       = iabstract_get_options( 'authorized_members' );
	$iabstract_opening_selection        = iabstract_get_options( 'opening_selection' );
	$iabstract_authorized_members_count = count( $iabstract_authorized_members );
	// ------------------------------------
	// Create option select
	// ------------------------------------
	$iabstract_datas = "";
	if ($iabstract_gf_entries_count > 0) {
		foreach($iabstract_gf_entries as $form) {
			// Check if members in project
			$members = array_keys( $iabstract_authorized_members, true );
			if ($members) {
				$iabstract_users      = "";
				$iabstract_nb_votant  = 0;
				$iabstract_total_note = 0;
				foreach($iabstract_authorized_members as $k => $v) {
					// Get note from member
					$iabstract_note_info = $wpdb->get_row( "SELECT * FROM $iabstract_tbl_note WHERE entry_id = " . $form['id'] . " AND user_id = " . $v );
					//echo "QUERY: SELECT * FROM $iabstract_tbl_note WHERE entry_id = " . $form['id'] . " AND user_id = " . $v . "<br>";
					// Get user infos
					$iabstract_user      = get_userdata($v);
					// Construct results
					$iabstract_users    .= $iabstract_user->display_name . ' (' . $iabstract_user->user_email . ') : ';
					$iabstract_users    .= (@$iabstract_note_info->note) ? "<em style='color: green;'>" . $iabstract_note_info->note . '/' . $iabstract_note_max . "</em>" : "<em style='color: red;'>Pas encore noté</em>";
					$iabstract_users    .= '<br>';
					if (isset($iabstract_note_info->note) && $iabstract_note_info->note >= 0) {
						// Increase nb votants
						$iabstract_nb_votant++;
						// Increase total note
						$iabstract_total_note = $iabstract_total_note + $iabstract_note_info->note;
					}
				}
			}
			// Moyenne de la note
			@$iabstract_moyenne = $iabstract_total_note / $iabstract_nb_votant;
			// Affichage de la note moyenne
			if ( !is_nan($iabstract_moyenne) ) {
				$iabstract_number_format = number_format($iabstract_moyenne, 2);
				if (!strstr($iabstract_number_format, '0'))
					$iabstract_show_moyenne = number_format($iabstract_moyenne, 2);
				else
					$iabstract_show_moyenne = $iabstract_moyenne;
			} else {
				$iabstract_show_moyenne = "--";
			}			
			//( (strpos(number_format($iabstract_moyenne, 2), "00", -1) === false) ? number_format($iabstract_moyenne, 2) : $iabstract_moyenne )
			//$iabstract_show_moyenne = (!is_nan($iabstract_moyenne)) ? number_format($iabstract_moyenne, 2) . '/' . $iabstract_note_max : "--";

			// Abstract selectionne ou pas
			$iabstract_selected_info = $wpdb->get_row( "SELECT selected FROM $iabstract_tbl_selected WHERE entry_id = " . $form['id'] );
			if ($iabstract_selected_info->selected == '1') {			
				//Cas où l'abstract a été noté et déjà été selectionné
				//var_dump($form['id']);
				$iabstract_selected = '<form method=\"post\" onclick=\"return false;\"><input type=\"submit\" class=\"iabstract-select\" style=\"width:111px;\" value=\"Sélectionné\"></form>';
			} else {
				// Check if members count EQUAL nb votants
				if ( ($iabstract_authorized_members_count == $iabstract_nb_votant) && (isset($iabstract_selected_info->selected)) || ($iabstract_opening_selection === true)) {
					// Select abstract is possible again
					
					if ($iabstract_selected_info->selected == '2') {
						$iabstract_selected = '<form method=\"post\" onclick=\"return false;\"><input type=\"submit\" class=\"iabstract-reject\" style=\"width:111px;\" value=\"Rejeté\"></form>';
					}else{
                        $iabstract_selected = '--';
					}
				} else {
					if( ($iabstract_authorized_members_count == $iabstract_nb_votant) && (!isset($iabstract_selected_info->selected)) ){
						if ($iabstract_selected_info->selected == '2') {
						    $iabstract_selected = '<form method=\"post\" onclick=\"return false;\"><input type=\"submit\" class=\"iabstract-reject\" style=\"width:111px;\" value=\"Rejeté\"></form>';
						}else{
                            $iabstract_selected = '<form method=\"post\" onclick=\"return false;\"><input type=\"submit\" class=\"iabstract-select\" style=\"width:111px;\" value=\"Sélectionné\"></form>';
						}
					}else{
						// Select abstract is impossible
					    if ($iabstract_selected_info->selected == '2') {
						    $iabstract_selected = '<form method=\"post\" onclick=\"return false;\"><input type=\"submit\" class=\"iabstract-reject\" style=\"width:111px;\" value=\"Rejeté\"></form>';
					    }else{
                            $iabstract_selected = '--';
					    }
					}
				}
			}
			// Abstract note
			$iabstract_usernote_info = $wpdb->get_row( "SELECT note FROM $iabstract_tbl_note WHERE entry_id = " . $form['id'] . " AND user_id = " . $iabstract_get_current_user_id );
			//$iabstract_usernote      = (isset($iabstract_usernote_info->note) && $iabstract_usernote_info->note >= 0) ? '<strong class=\"iabstract-note\">' . $iabstract_usernote_info->note . '</strong>' : '<form onsubmit=\"return iabstract_note(\''.$form['id'].'\', \''.$iabstract_gf_form_id.'\', \''.$iabstract_get_current_user_id.'\');\" method=\"post\"><input class=\"iabstractnote\" type=\"submit\" value=\"Noter\"></form>';
			$iabstract_closing_date  = iabstract_get_options( 'closing_date' );
			$iabstract_current_date  = time();
			if (isset($iabstract_usernote_info->note) && $iabstract_usernote_info->note >= 0) {
                //var_dump($iabstract_current_date, $iabstract_closing_date);
				// Check if closing date expired
				if ($iabstract_current_date < $iabstract_closing_date) {
                    if( strlen($iabstract_usernote_info->note)==1){
                    	$noteDisplay = $iabstract_usernote_info->note."&nbsp;&nbsp;";
                    }else{
                    	$noteDisplay = $iabstract_usernote_info->note;
                    }
					
					$iabstract_usernote  = '<div style=\"width: 77px;\"><div style=\"float: left;\"><strong class=\"iabstract-note\">' . $noteDisplay . '</strong></div>';
					$iabstract_usernote .= '<div><form onsubmit=\"return iabstract_note(\''.$form['id'].'\', \''.$iabstract_gf_form_id.'\', \''.$iabstract_get_current_user_id.'\', \'N\');\" method=\"post\"><input class=\"iabstractnote\" type=\"submit\" value=\"Modifier\"></form></div></div>';
				} else {
					$iabstract_usernote = '<strong class=\"iabstract-note\">' . $iabstract_usernote_info->note . '</strong>';
				}
			} else {
				// First note
				$iabstract_usernote = '<form onsubmit=\"return iabstract_note(\''.$form['id'].'\', \''.$iabstract_gf_form_id.'\', \''.$iabstract_get_current_user_id.'\', \'Y\');\" method=\"post\"><input style=\"width:55px;\" class=\"iabstractnote\" type=\"submit\" value=\"Noter\"></form>';
			}
			// Construct ARRAY Datas
			$iabstract_datas .= '{
				"Titre": "' . addslashes(htmlentities($form['24'])) . '",
				"Choix": "' . addslashes(htmlentities($form['18'])) . '",
				"Thématique": "' . (($form['19']) ? addslashes(htmlentities($form['19'])) : '--' ) . '",
				"Note/20": "' . $iabstract_usernote . '",
				"Moyenne/'. $iabstract_note_max.'": "' . str_replace("/6", "", $iabstract_show_moyenne) . '",
				"Votes": "' . $iabstract_nb_votant . '/' . $iabstract_authorized_members_count . '",
				"Sélectionné": "' . $iabstract_selected . '",
				"NoteMoyenne": "' . $iabstract_show_moyenne . '",
				"Abstract": "' . addslashes(htmlentities(iabstract_htmlconvert($form['23']))) . '",
				},';
		}
	}
	// ------------------------------------
	echo '<style id="jsbin-css">
        td.details-control {
            text-align:center;
            color:forestgreen;
			cursor: pointer;
}
tr.shown td.details-control {
    text-align:center; 
    color:red;
}
</style>
<table width="100%" class="display" id="iabstract-entries" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>Titre</th>
                <th>Choix</th>
                <th>Thématique</th>
                <th>Note/20</th>
                <th>Moyenne/'. $iabstract_note_max.'</th>
                <th>Votes</th>
                <th>Sélectionné</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Titre</th>
                <th>Choix</th>
                <th>Thématique</th>
                <th>Note/20</th>
                <th>Moyenne/'. $iabstract_note_max.'</th>
                <th>Votes</th>
                <th>Sélectionné</th>
            </tr>
        </tfoot>
    </table>
<script>
jQuery(document).ready(function () {
         var table = jQuery("#iabstract-entries").DataTable({
             "data": iabstract_data.data,
             select:"single",
             "columns": [
                 {
                     "className": "details-control",
                     "orderable": false,
                     "data": null,
                     "defaultContent": "",
                     "render": function () {
                         return \'<i class="fa fa-plus-square" aria-hidden="true"></i>\';
                     },
                     width:"15px"
                 },
                 { "data": "Titre" },
                 { "data": "Choix" },
                 { "data": "Thématique" },
                 { "data": "Note/20" },
                 { "data": "Moyenne/'. $iabstract_note_max.'" },
                 { "data": "Votes" },
                 { "data": "Sélectionné" },
             ],
             "order": [2, "asc"],
			 "responsive": true,
			 "lengthMenu": [[25, 50, 100, 150, -1], [25, 50, 100,150, "Tout"]],
			 "iDisplayLength": 100,
			 "stateSave": true,
			 "language": {
			 	"search":"_INPUT_",
				"searchPlaceholder": "Rechercher...",
				"lengthMenu": "_MENU_",
				"zeroRecords": "Aucun abstract posté",
				"emptyTable": "Aucun abstract reçu",
				"paginate": {
					"first":    "Premier",
					"last":     "Dernier",
					"next":     "Suivant",
					"previous": "Précédent"
				},
				"info":      "_START_ à _END_ (_TOTAL_ abstracts reçus)",
				"infoEmpty": "0 à 0 (0 abstract reçu)",
			 },
         });

         // Add event listener for opening and closing details
         jQuery("#iabstract-entries tbody").on("click", "td.details-control", function () {
             var tr = jQuery(this).closest("tr");
             var tdi = tr.find("i.fa");
             var row = table.row(tr);

             if (row.child.isShown()) {
                 // This row is already open - close it
                 row.child.hide();
                 tr.removeClass("shown");
                 tdi.first().removeClass("fa-minus-square");
                 tdi.first().addClass("fa-plus-square");
             }
             else {
                 // Open this row
                 row.child(iabstract_format(row.data())).show();
                 tr.addClass("shown");
                 tdi.first().removeClass("fa-plus-square");
                 tdi.first().addClass("fa-minus-square");
             }
         });

         table.on("user-select", function (e, dt, type, cell, originalEvent) {
             if (jQuery(cell.node()).hasClass("details-control")) {
                 e.preventDefault();
             }
         });
     });

    var iabstract_data = {
    "data": [ ' . $iabstract_datas . ' ]
    };
</script>';
	// ------------------------------------
	// ------------------------------------
	// ------------------------------------
} else {
	// ------------------------------------
	// --- Check if user is connected
	// ------------------------------------
	if ($iabstract_get_current_user_id == 0) {
		// ------------------------------------
		// --- User not connected
		// ------------------------------------
		/*
		echo '<h3>';
		echo "Vous devez vous connecter pour accéder à cette page";
		echo '</h3>';*/
		$redirect = "?redirect_to=jury/";
		$www = wp_login_url().$redirect;
	    echo '<script language="Javascript">document.location.replace("'.$www.'"); </script>';
	} else {
		// ------------------------------------
		// --- User is not a member
		// ------------------------------------
		echo '<h3>';
		echo "Vous n'êtes pas membre du comité pour accéder à cette page";
		echo '</h3>';
	}
}

?>