<?php

    session_start(); 

    if( $_SESSION["loginEmail"] === NULL && $_COOKIE["LOGIN"] != NULL){
        $_SESSION["loginEmail"] = $_COOKIE["LOGIN"];
    }

    if( $_SESSION["loginEmail"] != NULL && $_SESSION["loginEmail"] != "disconnect") {

        if($_GET["congres"] === NULL){
            //redirection vers le portail
            $www = site_url( $path = 'portail/', $scheme = null );
            echo '<script language="Javascript">document.location.replace("'.$www.'"); </script>';
        }else{
            //redirection vers le formulaire d'inscription du congrès
            $www = site_url( $path = $_GET["congres"], $scheme = null );
            echo '<script language="Javascript">document.location.replace("'.$www.'"); </script>';
        }
    }

    $cond = ( $_GET["congres"] === NULL ) ? "" : "?congres=".$_GET["congres"];
?>
<style type="text/css">
    .categorie, .identifiant{
        text-align: left;
    }
    
    .identifiant{
        margin-top : 20px;
        margin-bottom: 20px;
    }
    
    .loadingConnect{
        text-align: -webkit-center;
    }
    .mandatory{
        color: red;
    }

    input{
        font-size: 18px!important;
        margin-top: 3px;
        border: none!important;
        background-color: none!important;
    }
</style>
<!-- Default form login -->
<div class="col-xs-1 text-center" style="margin-left: 320px; font-size: 18px;">
<form id="target-login" class="text-center p-5" style="border-color: #2ecac2!important; border: 1px solid black; width: 505px;">
    
    <p><h2 style="margin-bottom: 20px;">Connexion</h2></p>
    <div class="col-sm-12 alert alert-info text-center info" role="alert" style="display: none;">
        
    </div>

    <div class="col-sm-12 alert alert-danger text-center error" role="alert" style="display: none;">
                
    </div>

    <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">
                
    </div>

    <p class="categorie">Selectionner votre catégorie <span class="mandatory">*</span> :</p>

    <div class="categorie">
        <input type="radio" id="participant" name="categorie" value="participant" required>
        <label for="participant">Participant</label>
    </div>

    <div class="categorie">
        <input type="radio" id="intervenant" name="categorie" value="intervenant">
        <label for="intervenant">Intervenant</label>
    </div>

    <div class="identifiant">
        <!-- Email -->
        <input type="email" name="email" id="email" class="form-control mb-4" placeholder="E-mail">

        <!-- Password -->
        <input type="password" name="password" id="password" class="form-control mb-4" placeholder="Password">

        <input type="checkbox" name="remember" id="remember" class="remember mb-4">
        <label for="remember">Resté connecter</label>

        <input id="redirection" type="hidden" name="redirection" value="<?=$cond?>"/>
        <!-- Sign in button -->
        <input type="submit" id="submit-login" class="form-control mb-4" value="Login" style="width: 407px; height: 43px;" />
        <div class="loadingConnect">
            <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: block;">
        </div>
    </div>

             
    <!-- Register -->
    <p style="text-align: left;">
        Vous n'avez pas de compte ? <a href="../registration/<?=$cond?>">Créer</a>
        <br><br>
        Mot de passe oublié ? <a href="../reset-password/">Recréer</a>
    </p>

</form>
</div>
