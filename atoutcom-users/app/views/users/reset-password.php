<?php

?>

<div class="col-xs-1 text-center" style="margin-left: 320px;">
<form id="target-reset-password" class="text-center p-5" style="border-color: #2ecac2!important; border: 1px solid black; width: 405px;">

    <p class="h4 mb-4">Récuperation mot de passe</p>
    <div class="col-sm-12 alert alert-info text-center info" role="alert" style="display: none;">
  
    </div>

    <div class="col-sm-12 alert alert-danger text-center error" role="alert" style="display: none;">
                
    </div>

    <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">
                
    </div>
    
    <div class="login">
    	<input type="hidden" name="action" id="action" value="">
        <input type="email" name="email" id="email" class="form-control mb-4" placeholder="Saisir votre Identifiant" style="width: 304px;" required>
    </div>
    
    <div class="password" style="display: none;">
    	<input type="password" name="password" id="password" class="form-control mb-4" placeholder="Nouveau mot de passe" style="width: 304px;" required>
    	<input type="password" name="password-repeat" id="password-repeat" class="form-control mb-4" placeholder="Resaisir votre nouveau mot de passe" style="width: 304px;">
    </div>
    
    <div class="redirection" style="display: none;">
    	Vous pouvez vous connecter en cliquant sur ce <a href="../login/">lien</a>
    </div>
    <br>
    <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: none;">
    <!-- Sign in button -->
    <input type="submit" id="submit-reset-password" class="form-control mb-4" value="Envoyer" style="width: 304px; height: 43px;" />
             
    <!-- Register -->
    <p style="text-align: left;">
        Vous n'avez pas de compte ? <a href="../registration/">Créer</a>
        <br>
        Mot de passe oublié ? <a href="../reset-password/">Recréer</a>
    </p>

</form>
</div>