<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Create tab's emails                   -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$iabstract_membersTab->createOption( array(
	'name' => "Membres autorisés",
	'type' => 'heading',
) );
// ----------------------------------------
$iabstract_all_users          = get_users( 'blog_id=' . get_current_blog_id() . '&orderby=nicename' );
$iabstract_authorized_members = [];
if ($iabstract_all_users) {
	foreach($iabstract_all_users as $user) {
		$iabstract_authorized_members[$user->ID] = $user->display_name . ' (' . $user->user_email . ')';
	}
}
// ----------------------------------------
$iabstract_membersTab->createOption( array(
	'name'    => "Les membres autorisés à noter les abstracts",
	'id'      => 'authorized_members',
	'type'    => 'multicheck',
	'desc'    => '',
	'default' => '',
	'options' => $iabstract_authorized_members,
) );
// ----------------------------------------

?>