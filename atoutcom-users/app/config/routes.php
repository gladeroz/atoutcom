<?php

MvcRouter::public_connect('{:controller}', array('action' => 'index'));
MvcRouter::public_connect('{:controller}/{:id:[\d]+}', array('action' => 'show'));
MvcRouter::public_connect('{:controller}/{:action}/{:id:[\d]+}');

/* Partie Utilisateur */

add_shortcode('user_login', function(){
    $controller = new UsersController();
    $controller->get_login();
    return $controller->render_to_string('users/login',['bypass_layout'=>false]);
});

function usersRegistration()
{    
    return mvc_render_to_string('users/registration');
}
add_shortcode('user_registration', 'usersRegistration');

function usersRegistrationPlus()
{    
    return mvc_render_to_string('users/registrationplus');
}
add_shortcode('user_registration_plus', 'usersRegistrationPlus');

function usersPortail()
{    
    return mvc_render_to_string('users/portail');
}
add_shortcode('user_portail', 'usersPortail');

function usersFacture()
{    
    return mvc_render_to_string('users/facture');
}
add_shortcode('user_facture', 'usersFacture');

function usersInvoice()
{    
    return mvc_render_to_string('users/invoice');
}
add_shortcode('user_invoice', 'usersInvoice');

function usersRemind()
{    
    return mvc_render_to_string('users/remind');
}
add_shortcode('user_remind', 'usersRemind');

function usersResetLogin()
{    
    return mvc_render_to_string('users/reset-login');
}
add_shortcode('user_reset_login', 'usersResetLogin');

function usersResetPassword()
{    
    return mvc_render_to_string('users/reset-password');
}
add_shortcode('user_reset_password', 'usersResetPassword');

/* Partie Administration */
function usersManage()
{    
    return mvc_render_to_string('admin/users/manage');
}
add_shortcode('user_admin_users_manage', 'usersManage');
