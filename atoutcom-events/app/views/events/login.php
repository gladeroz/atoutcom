<?php
    wp_register_style('login_css', mvc_css_url('atoutcom-users', 'login'));
    wp_enqueue_style('login_css');
?>

<!-- Default form login -->
<div class="col-xs-1 text-center" style="margin-left: 320px;">
<form id="target-login" class="text-center p-5" style="border-color: #2ecac2!important; border: 1px solid black; width: 405px;">

    <p class="h4 mb-4">Connexion</p>
    <div class="col-sm-12 alert alert-info text-center info" role="alert" style="display: none;">
  
    </div>

    <div class="col-sm-12 alert alert-danger text-center error" role="alert" style="display: none;">
                
    </div>

    <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">
                
    </div>
    <!-- Email -->
    <input type="email" name="email" id="email" class="form-control mb-4" placeholder="E-mail">

    <!-- Password -->
    <input type="password" name="password" id="password" class="form-control mb-4" placeholder="Password">

    <!--<input type="checkbox" name="checkbox" class="mb-4" style="margin-left: -130px;">
    <label class="" for="remember">Se souvenir de moi</label>-->

    <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: none;">
    <!-- Sign in button -->
    <input type="submit" id="submit-login" class="form-control mb-4" value="Login" style="width: 304px; height: 43px;" />
             
    <!-- Register -->
    <p style="text-align: left;">
        Vous n'avez pas de compte ? <a href="../registration/">Créer</a>
        <br>
        Mot de passe oublié ? <a href="../reset-password/">Recréer</a>
    </p>

</form>
</div>
