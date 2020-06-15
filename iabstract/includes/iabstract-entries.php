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
		$iabstract_show_moyenne = (!is_nan($iabstract_moyenne)) ? $iabstract_moyenne . '/' . $iabstract_note_max : "--";
		// Abstract selectionne ou pas
		$iabstract_selected_info = $wpdb->get_row( "SELECT selected FROM $iabstract_tbl_selected WHERE entry_id = " . $form['id'] );
		$iabstract_selected      = (@$iabstract_selected_info->selected == '1') ? '<i class=\"fa fa-check-square iabstract-green\" aria-hidden=\"true\" title=\"Candidat sélectionné\"></i>' : '<i class=\"fa fa-window-close iabstract-red\" aria-hidden=\"true\" title=\"Non sélectionné\"></i>';
		// Construct ARRAY Datas
		$iabstract_datas .= '{
		    "Date": "' . iabstract_convert_date($form['date_created'], 'FRT') . '",
		    "Lien": "<a target=\'_blank\' href=\'' . get_admin_url( get_current_blog_id() ) . 'admin.php?page=gf_entries&view=entry&id=' . $form['form_id'] .'&lid=' . $form['id'] . '&order=ASC&filter&paged=1&pos=1&field_id&operator\'>' . addslashes(htmlentities("Voir l'entrée")) . '</a>",
			"Choix": "' . addslashes(htmlentities($form['18'])) . '",
			"Thématique": "' . (($form['19']) ? addslashes(htmlentities($form['19'])) : '--' ) . '",
			"Nom / Prénom": "' . addslashes(htmlentities(ucfirst(strtolower($form['2']) . ' ' . strtoupper($form['1'])))) . '",
			"Email": "' . addslashes(htmlentities($form['9'])) . '",
			"Note": "' . number_format($iabstract_show_moyenne, 2, '.', '') . '",
			"Votants": "' . $iabstract_nb_votant . '/' . $iabstract_authorized_members_count . '",
			"Sélectionné": "' . $iabstract_selected . '",
			"auteurPrincipal": "' . addslashes(htmlentities($form['20'])) . '",
			"titreAbstract": "' . addslashes(htmlentities($form['24'])) . '",
			"Abstract": "' . addslashes(htmlentities(iabstract_htmlconvert($form['23']))) . '",
			"Members": "' . $iabstract_users . '",
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
                <th>Note</th>
                <th>Votants</th>
                <th>Sélectionné</th>
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
                <th>Note</th>
                <th>Votants</th>
                <th>Sélectionné</th>
            </tr>
        </tfoot>
    </table>
<script>
$(document).ready(function () {
         var table = $("#iabstract-entries").DataTable({
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
                 { "data": "Note" },
                 { "data": "Votants" },
                 { "data": "Sélectionné" },
             ],
             "order": [1, "desc"],
			 responsive: true,
			 "lengthMenu": [25, 50, 75, 100, 150],
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