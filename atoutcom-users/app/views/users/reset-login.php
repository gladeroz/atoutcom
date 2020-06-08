<?php

?>
<div class="col-xs-1 text-center" style="margin-left: 320px;">
<form id="target-reset-password" class="text-center p-5" style="border-color: #2ecac2!important; border: 1px solid black">

    <p class="h4 mb-4">Récuperation du Login</p>
    <div class="col-sm-12 alert alert-info text-center info" role="alert" style="display: none;">
  
    </div>

    <div class="col-sm-12 alert alert-danger text-center error" role="alert" style="display: none;">
                
    </div>

    <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">
                
    </div>
    <!-- Email -->
    <input type="text" name="nom" id="nom" class="form-control mb-4" placeholder="Saisir votre nom">
    <input type="text" name="text" id="prenom" class="form-control mb-4" placeholder="Saisir votre prenom">

    <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: none;">
    <!-- Sign in button -->
    <input type="submit" id="submit-login" class="form-control mb-4" value="Login" style="width: 282px; height: 43px;" />
             
    <!-- Register -->
    <p style="text-align: left;">
        Vous n'avez pas de compte ? <a href="../registration/">Créer</a>
        <br>
        Mot de passe oublié ? <a href="../reset-password/">Recréer</a>
    </p>

</form>
</div>