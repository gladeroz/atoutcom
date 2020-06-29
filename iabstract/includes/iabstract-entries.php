<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');
global $wpdb, $iabstract_table_name, $iabstract_table_selected;
$iabstract_tbl_note     = $wpdb->prefix . $iabstract_table_name;
$iabstract_tbl_selected = $wpdb->prefix . $iabstract_table_selected;

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Create tab's Entries                  -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$iabstract_entriesTab->createOption( array(
	'name' => "Tous les abstracts reçus",  
	'type' => 'heading',
) );

// ----------------------------------------
$iabstract_gf_form_id               = iabstract_get_options( 'form_gf_id' );
$iabstract_gf_search_criteria       = array('status' => 'active');
$iabstract_gf_sorting               = array();
$iabstract_gf_paging                = array( 'offset' => 0, 'page_size' => 200 );
$iabstract_gf_entries               = GFAPI::get_entries( $iabstract_gf_form_id, $iabstract_gf_search_criteria, $iabstract_gf_sorting, $iabstract_gf_paging );
$iabstract_gf_entries_count         = count( $iabstract_gf_entries );
$iabstract_note_max                 = iabstract_get_options( 'note_max' );
$iabstract_authorized_members       = iabstract_get_options( 'authorized_members' );
$iabstract_authorized_members_count = count( $iabstract_authorized_members );

// ------------------------------------
// --- Get current user id
// ------------------------------------
$iabstract_get_current_user_id = get_current_user_id();

// ----------------------------------------
// Create option select
// ----------------------------------------
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
				$iabstract_users    .= ' \<br>';
				if (@$iabstract_note_info->note) {
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
		$iabstract_show_moyenne = (!is_nan($iabstract_moyenne)) ? number_format($iabstract_moyenne,2) : "";
		//$iabstract_show_moyenne = "--";
		
        $iabstract_selected_info = $wpdb->get_row( "SELECT selected, commentaire FROM $iabstract_tbl_selected WHERE entry_id = " . $form['id'] );
        if( ($iabstract_selected_info->commentaire !=NULL) || ($iabstract_selected_info->commentaire !="")){
            $label_comment = $iabstract_selected_info->commentaire;
        }else{
            $label_comment = "";
        }
        if ($iabstract_selected_info->selected == '1') {            
            //Cas où l'abstract a été noté et déjà été selectionné
            $iabstract_selected = '<form method=\"post\" onsubmit=\"return iabstract_unselected(\''.$form['id'].'\', \''.$iabstract_gf_form_id.'\', \'0\', \'deselect\');\"><input type=\"submit\" class=\"deselect\" value=\"De-Sélectionner\"></form>'.'<form method=\"post\" onsubmit=\"return iabstract_rejected(\''.$form['id'].'\', \''.$iabstract_get_current_user_id.'\', \''.$iabstract_gf_form_id.'\', \'update\');\"><input type=\"submit\" class=\"reject\" value=\"Rejeter\"></form>';
            $etat = 'Selectionné';

            $commentaire = '<form method=\"post\" style=\"width: 128px;\" onsubmit=\"return iabstract_comment(\''.$form['id'].'\', \''.$iabstract_get_current_user_id.'\', \''.$iabstract_gf_form_id.'\');\"><div class=\"textarea-container\"><textarea class=\"com_'.$form['id'].'\" name=\"comment\" type=\"text\">'.$label_comment.'</textarea><button type=\"submit\">Valider</button></div></form>';

        } else {
            // Check if members count EQUAL nb votants
            if ( ($iabstract_authorized_members_count == $iabstract_nb_votant) && (isset($iabstract_selected_info->selected)) || ($iabstract_opening_selection === true)) {
                // Select abstract is possible again
                $iabstract_selected = '<form method=\"post\" onsubmit=\"return iabstract_unselected(\''.$form['id'].'\', \''.$iabstract_gf_form_id.'\', \'1\', \'reselect\');\"><input type=\"submit\" class=\"reselect\" value=\"Sélectionner\"></form>'.'<form method=\"post\" onsubmit=\"return iabstract_rejected(\''.$form['id'].'\', \''.$iabstract_get_current_user_id.'\', \''.$iabstract_gf_form_id.'\', \'update\');\"><input type=\"submit\" class=\"reject\" value=\"Rejeter\"></form>';

                $commentaire = '<form method=\"post\" style=\"width: 128px;\" onsubmit=\"return iabstract_comment(\''.$form['id'].'\', \''.$iabstract_get_current_user_id.'\', \''.$iabstract_gf_form_id.'\');\"><div class=\"textarea-container\"><textarea class=\"com_'.$form['id'].'\" name=\"comment\" type=\"text\">'.$label_comment.'</textarea><button type=\"submit\">Valider</button></div></form>';
                if($iabstract_selected_info->selected == '2'){
                    $etat = 'Rejeté';
                }else{
                    $etat = '--';
                }
            } else {
                if( ($iabstract_authorized_members_count == $iabstract_nb_votant) && (!isset($iabstract_selected_info->selected)) ){
                    $iabstract_selected = '<form method=\"post\" onsubmit=\"return iabstract_selected(\''.$form['id'].'\', \''.$iabstract_gf_form_id.'\', \''.$iabstract_get_current_user_id.'\');\"><input type=\"submit\" class=\"reselect\"  value=\"Sélectionner\"></form>'.'<form method=\"post\" onsubmit=\"return iabstract_rejected(\''.$form['id'].'\', \''.$iabstract_get_current_user_id.'\', \''.$iabstract_gf_form_id.'\', \'insert\');\"><input type=\"submit\" class=\"reject\" value=\"Rejeter\"></form>';

                    $commentaire = '<form method=\"post\" style=\"width: 128px;\" onsubmit=\"return iabstract_comment(\''.$form['id'].'\', \''.$iabstract_get_current_user_id.'\', \''.$iabstract_gf_form_id.'\');\"><div class=\"textarea-container\"><textarea class=\"com_'.$form['id'].'\" name=\"comment\" type=\"text\">'.$label_comment.'</textarea><button type=\"submit\">Valider</button></div></form>';
                    if($iabstract_selected_info->selected == '2'){
                        $etat = 'Rejeté';
                    }else{
                        $etat = '--';
                    }
                }else{
                    // Select abstract is impossible
                    $iabstract_selected = '<form method=\"post\"><input type=\"submit\" title=\"Abstract non noté\" onclick=\"return false;\" class=\"iabstract-no-selectable unselect\" style=\"width:111px; border : none;\" value=\"Sélectionner\"></form>'.'<form method=\"post\" onsubmit=\"return iabstract_rejected(\''.$form['id'].'\', \''.$iabstract_get_current_user_id.'\', \''.$iabstract_gf_form_id.'\', \'insert\');\"><input type=\"submit\" class=\"reject\" value=\"Rejeter\"></form>';

                    $commentaire = '<form method=\"post\" style=\"width: 128px;\" onsubmit=\"return iabstract_comment(\''.$form['id'].'\', \''.$iabstract_get_current_user_id.'\', \''.$iabstract_gf_form_id.'\');\"><div class=\"textarea-container\"><textarea class=\"com_'.$form['id'].'\" name=\"comment\" type=\"text\">'.$label_comment.'</textarea><button type=\"submit\">Valider</button></div></form>';
                    if($iabstract_selected_info->selected == '2'){
                        $etat = 'Rejeté';
                    }else{
                        $etat = '--';
                    }
                }
            }
        }

		// Construct ARRAY Datas
		$iabstract_datas .= '{
		    "Date": "' . iabstract_convert_date($form['date_created'], 'FRT') . '",
		    "Lien": "<a target=\'_blank\' href=\'' . get_admin_url( get_current_blog_id() ) . 'admin.php?page=gf_entries&view=entry&id=' . $form['form_id'] .'&lid=' . $form['id'] . '&order=ASC&filter&paged=1&pos=1&field_id&operator\'>' . addslashes(htmlentities("Voir l'entrée")) . '</a>",
			"Choix": "' . addslashes(htmlentities($form['18'])) . '",
			"Thématique": "' . (($form['19']) ? addslashes(htmlentities($form['19'])) : '--' ) . '",
			"Nom / Prénom": "' . addslashes(htmlentities(ucfirst(strtolower($form['2']) . ' ' . strtoupper($form['1'])))) . '",
			"Email": "' . addslashes(htmlentities($form['9'])) . '",
			"Moyenne/'.$iabstract_note_max.'": "' . $iabstract_show_moyenne . '",
			"Votants": "' . $iabstract_nb_votant . '/' . $iabstract_authorized_members_count . '",
			"Action": "' . $iabstract_selected . '",
            "Etat": "' . $etat . '",
			"Commentaire": "'.$commentaire.'",
			"auteurPrincipal": "' . addslashes(htmlentities($form['20'])) . '",
			"titreAbstract": "' . addslashes(htmlentities($form['24'])) . '",
			"Abstract": "' . addslashes(htmlentities(iabstract_htmlconvert($form['23']))) . '",
			"Members": "' . $iabstract_users . '",
            "Pays": "' . addslashes(htmlentities($form['17'])) . '",
            "Ville": "' . addslashes(htmlentities($form['16'])) . '",
			},';
	}
}
//die('$iabstract_datas:'.addslashes(htmlentities(iabstract_htmlconvert($form['23']))));
//echo '<pre>';
//var_dump($iabstract_gf_entries);
//echo '</pre>';
// ----------------------------------------
$iabstract_entriesTab->createOption( array(
	'type'   => 'custom',
	'custom' => '<style id="jsbin-css">
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
                <th>Date</th>
                <th>Lien</th>
                <th>Choix</th>
                <th>Thématique</th>
                <th>Nom / Prénom</th>
                <th>Email</th>
                <th>Moyenne/'.$iabstract_note_max.'</th>
                <th>Votants</th>
                <th>Action</th>
                <th>Etat</th>
				<th>Commentaire</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Date</th>
                <th>Lien</th>
                <th>Choix</th>
                <th>Thématique</th>
                <th>Nom / Prénom</th>
                <th>Email</th>
                <th>Moyenne/'.$iabstract_note_max.'</th>
                <th>Votants</th>
                <th>Action</th>
                <th>Etat</th>
				<th>Commentaire</th>
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
                 { "data": "Date" },
                 { "data": "Lien" },
                 { "data": "Choix" },
                 { "data": "Thématique" },
                 { "data": "Nom / Prénom" },
                 { "data": "Email" },
                 { "data": "Moyenne/'.$iabstract_note_max.'" },
                 { "data": "Votants" },
                 { "data": "Action" },
                 { "data": "Etat" },
				 { "data": "Commentaire" },
             ],
             "order": [1, "desc"],
			 "responsive": true,
			 "lengthMenu": [[25, 50, 100, 150, -1], [25, 50, 100,150, "Tout"]],
			 "iDisplayLength": 100,
			 "stateSave": true,
			 "language": {
				"search": "Recherche",
				"lengthMenu": "_MENU_ abstracts",
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
         $("#iabstract-entries tbody").on("click", "td.details-control", function () {
             var tr = $(this).closest("tr");
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
             if ($(cell.node()).hasClass("details-control")) {
                 e.preventDefault();
             }
         });
     });

    var iabstract_data = {
		"data": [ ' . $iabstract_datas . ' ]
    };
</script>'
) );
// ----------------------------------------
// ----------------------------------------
// ----------------------------------------
?>
