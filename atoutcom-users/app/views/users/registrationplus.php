<?php

function my_login_form( $args = array() ) {
	$defaults = array(
		'echo' => true,
		'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // Default redirect is back to the current page
		'form_id' => 'loginform',
        'label_nom' => 'Nom' ,
        'label_prenom' => 'Prenom' ,
        'label_mail' => 'Email' ,
        'label_adresse' => 'Adresse' ,
        'label_telephone' => 'Téléphone' ,
        'label_thematique' => 'Thématique ciblée' ,
        'label_inscription' => 'Date d\'inscription' ,
        'label_password' => __( 'Password' ),
        'label_confirm_password' => 'Confirmer le mot de passe',
		'label_prospection' => 'Accepter de se faire contacter pour des démarches commerciales',
		'label_log_in' => __( 'Log In' ),
        'id_nom' => 'user_login',
        'id_prenom' => 'user_login',
        'id_password' => 'user_pass',
        'id_adresse' => 'user_adresse',
        'id_telephone' => 'user_telephone',
        'id_inscription' => 'user_inscription',
        'id_thematique' => 'user_thematique',
		'id_prospection' => 'user_prospection',
		'id_submit' => 'wp-submit',
		'prospection' => true,
        'value_nom' => '',
        'value_prenom' => '',
        'value_password' => '',
        'value_telephone' => '',
        'value_adresse' => '',
        'value_thematique' => '',
        'value_confirm_password' => '',
        'value_inscription' => '',
		'value_prospection' => false // Set this to true to default the "Remember me" checkbox to checked
	);

	$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );

	$login_form_top = apply_filters( 'login_form_top', '', $args );
	$login_form_middle = apply_filters( 'login_form_middle', '', $args );
	$login_form_bottom = apply_filters( 'login_form_bottom', '', $args );

	$form = '
		<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post">
			' . $login_form_top . '
			<p class="login-nom">
				<label for="' . esc_attr( $args['id_nom'] ) . '">' . esc_html( $args['label_nom'] ) . '</label>
                <input type="text" name="log" id="' . esc_attr( $args['id_nom'] ) . '" class="input" value="' . esc_attr( $args['value_nom'] ) . '" size="20" />
			</p>
			<p class="login-prenom">
				<label for="' . esc_attr( $args['id_prenom'] ) . '">' . esc_html( $args['label_prenom'] ) . '</label>
                <input type="text" name="log" id="' . esc_attr( $args['id_prenom'] ) . '" class="input" value="' . esc_attr( $args['value_prenom'] ) . '" size="20" />
            </p>
            <p class="login-mail">
                <label for="' . esc_attr( $args['id_mail'] ) . '">' . esc_html( $args['label_mail'] ) . '</label>
                <input type="text" name="log" id="' . esc_attr( $args['id_mail'] ) . '" class="input" value="' . esc_attr( $args['value_mail'] ) . '" size="20" />
            </p>
            <p class="login-password">
				<label for="' . esc_attr( $args['id_password'] ) . '">' . esc_html( $args['label_password'] ) . '</label>
                <input type="text" name="log" id="' . esc_attr( $args['id_password'] ) . '" class="input" value="' . esc_attr( $args['value_password'] ) . '" size="20" />
            </p>
            <p class="login-adresse">
                <label for="' . esc_attr( $args['id_adresse'] ) . '">' . esc_html( $args['label_adresse'] ) . '</label>
                <input type="text" name="log" id="' . esc_attr( $args['id_adresse'] ) . '" class="input" value="' . esc_attr( $args['value_adresse'] ) . '" size="20" />
            </p>

            <p class="login-telephone">
                <label for="' . esc_attr( $args['id_telephone'] ) . '">' . esc_html( $args['label_telephone'] ) . '</label>
                <input type="text" name="log" id="' . esc_attr( $args['id_telephone'] ) . '" class="input" value="' . esc_attr( $args['value_telephone'] ) . '" size="20" />
            </p>
            <p class="login-thematique">
                <label for="' . esc_attr( $args['id_thematique'] ) . '">' . esc_html( $args['label_thematique'] ) . '</label>
                <input type="text" name="log" id="' . esc_attr( $args['id_thematique'] ) . '" class="input" value="' . esc_attr( $args['value_thematique'] ) . '" size="20" />
            </p>
            <p class="login-inscription">
                <label for="' . esc_attr( $args['id_inscription'] ) . '">' . esc_html( $args['label_inscription'] ) . '</label>
                <input type="text" name="log" id="' . esc_attr( $args['id_inscription'] ) . '" class="input" value="' . esc_attr( $args['value_inscription'] ) . '" size="20" />
            </p>
            ' . ( $args['remember'] ? '<p class="login-prospection"><label><input name="prospection" type="checkbox" id="' . esc_attr( $args['id_prospection'] ) . '" value="forever"' . ( $args['value_prospection'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_prospection'] ) . '</label></p>' : '' ) . '
			' . $login_form_middle . '
			<p class="login-submit">
				<input type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="button-primary" value="' . esc_attr( $args['label_log_in'] ) . '" />
				<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
			</p>
			' . $login_form_bottom . '
        </form>';

	if ( $args['echo'] )
		echo $form;
	else
		return $form;
}

my_login_form();

?>