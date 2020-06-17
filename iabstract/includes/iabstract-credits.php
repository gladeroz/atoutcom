<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Create tab's options                  -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$informatux_url     = '<a href="https://informatux.com/" target="_blank">INFORMATUX</a>';
$informatux_support = '<a href="https://informatux.com/contact" target="_blank">INFORMATUX</a>';
$informatux_contact = '<a href="https://informatux.com/contact" target="_blank">Contact INFORMATUX</a>';
// ----------------------------------------
$iabstract_creditsTab->createOption( array(
	'name' => __( 'CREDITS', IABSTRACT_ID_LANGUAGES ) . ' <br /><i> ' . IABSTRACT_NAME . '<i>',
	'type' => 'note',
	'desc' => '<img width="96" height="96" class="iabstract-credits" src="' . IABSTRACT_URL . 'images/avatar-informatux.png" alt=""><br>' . __( 'Developed and maintained by', IABSTRACT_ID_LANGUAGES ) . ' ' . $informatux_url . '<br>' . __( 'Written with ', IABSTRACT_ID_LANGUAGES ) . '<a href="http://www.titanframework.net/" target="_blank">Titan Framework</a>'
) );
// ----------------------------------------
$iabstract_creditsTab->createOption( array(
	'name' => __( 'SUPPORT', IABSTRACT_ID_LANGUAGES ) . ' <br /><i> ' . IABSTRACT_NAME . '<i>',
	'type' => 'note',
	'desc' => '<img width="96" height="96" class="iabstract-support" src="' . IABSTRACT_URL . 'images/customer-iabstract-support.png" alt="ILIST Support">' . __( 'Support contact', IABSTRACT_ID_LANGUAGES ) . ' ' . $informatux_support . '<br>' . __( "Need more features on this plugin? Don't hesitate to contact us here", IABSTRACT_ID_LANGUAGES ) . ' ' . $informatux_support .  '<br>' . __( "Need a plugin for Wordpress? Don't hesitate to contact us here", IABSTRACT_ID_LANGUAGES ) . ' ' . $informatux_support . '<br>' . __( 'To contact us, You have to indicate us all the informations of your wordpress installation (Version Number WP, Version number Storefront Icustomizer, Server)', IABSTRACT_ID_LANGUAGES ) . '<br><br><a class="iabstract-support-other-plugins" target="_blank" href="' . get_admin_url(get_current_blog_id(), 'plugin-install.php?s=informatux&tab=search&type=term') . '">&dzigrarr; ' . __( "If you would like to use our other plugins, click here ", IABSTRACT_ID_LANGUAGES ) . '</a>'
) );
// ----------------------------------------
$iabstract_creditsTab->createOption( array(
	'name' => __( 'SERVICES', IABSTRACT_ID_LANGUAGES ) . ' <br /><i> ' . $informatux_url . '<i>',
	'type' => 'note',
	'desc' => '<div class="informatux_outerdiv">

  <div class="informatux_outer">
      <img src="https://informatux.com/data/uploads/giphy/informatux-securite-wp.gif" class="informatux_gs_image" alt="">
      <div class="informatux_centered">' . __( 'SECURITY', IABSTRACT_ID_LANGUAGES ) . '</div>
      <div>
        <p class="informatux_p_services">' . __( "Tired of your WORDPRESS sites being attacked", IABSTRACT_ID_LANGUAGES ) . '<br>
        ' . __( "Too complicated to put back", IABSTRACT_ID_LANGUAGES ) . '<br>
        '. $informatux_contact . '
        </p>       
      </div>
  </div>
  
  <div class="informatux_outer">
      <img src="https://informatux.com/data/uploads/giphy/informatux-installation-wordpress.gif" class="informatux_gs_image" alt="">
      <div class="informatux_centered">INSTALLATION</div>
      <div>
        <p class="informatux_p_services">Wordpress / WooCommerce<br>
        ' . __( 'Wordpress Themes', IABSTRACT_ID_LANGUAGES ) . '<br>
        ' . __( 'Web Hosting', IABSTRACT_ID_LANGUAGES ) . '<br>
        ' . __( 'Manage your WP sites by ANDROID / APPLE application', IABSTRACT_ID_LANGUAGES ) . '<br>
        '. $informatux_contact . '</p>
      </div>
  </div>
  
  <div class="informatux_outer informatux_last">
      <img src="https://informatux.com/data/uploads/giphy/informatux-maintenance.gif" class="informatux_gs_image" alt="">
      <div class="informatux_centered">' . __( 'MAINTENANCE', IABSTRACT_ID_LANGUAGES ) . '</div>
      <div>
        <p class="informatux_p_services">' . __( 'No time', IABSTRACT_ID_LANGUAGES ) . '<br>
        ' . __( 'No envy', IABSTRACT_ID_LANGUAGES ) . '<br>
        ' . __( 'Too complicated', IABSTRACT_ID_LANGUAGES ) . '<br>
        '. $informatux_contact . '
        </p>       
      </div>
  </div>

</div>'
) );