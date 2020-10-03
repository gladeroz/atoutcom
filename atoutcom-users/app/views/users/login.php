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
    .formLogin{
        border-color: #2ecac2!important; 
        border: 1px solid black;
    }

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
    

    .titreLogin {
        margin-top: 40px;
    }
    
    .mandatory{
        color: red;
    }

    .form-group {
        display: inline-block;
    }

    input{
        font-size: 18px!important;
        margin-top: 3px;
        background-color: none!important;
        border: 1px solid #27cfc3!important;
    }
</style>
<!-- Default form login -->
<div class="container text-center">
    <div class="row" style="padding-right: 25%; padding-left: 25%">
        <form id="target-login" class="formLogin">     

            <div class="container">
                <div class="row">
                    <div class="form-group col-sm-10 titreLogin">
                        <h2>Connexion</h2>
                    </div>
                </div>
                
                <div class="col-sm-12 alert alert-info text-center info" role="alert" style="display: none;">
                    test
                </div>

                <div class="col-sm-12 alert alert-danger text-center error" role="alert" style="display: none;">
                            
                </div>

                <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">
                            
                </div>

                <div class="row">
                    <div class="form-group col-sm-8 text-left">
                        <input type="radio" id="participant" name="categorie" value="Participant" checked="checked" required>
                        <label for="participant">Participant</label>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="form-group col-sm-8">
                        <div class="text-left">E-mail</div>
                        <div>
                            <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-8">
                        <div class="text-left">Mot de passe</div>
                        <div>
                             <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-8">
                        <input type="checkbox" name="remember" id="remember" class="remember">
                        <label for="remember">Restez connecter</label>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-8">
                        
                        <div class="form-group">
                            <input type="submit" id="submit-login" class="form-control btn btn-primary btn-lg" value="Connexion" style="width: 200px; height: 43px;" />
                            <input id="redirection" type="hidden" name="redirection" value="<?=$cond?>"/>
                        </div>

                        <div class="form-group" style="vertical-align: middle;">
                            <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>">
                        </div>                 
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-8">
                        <div>Vous n'avez pas de compte ? <a href="../registration/<?=$cond?>">Créer</a></div>
                        <div>Mot de passe oublié ? <a href="../reset-password/">Réinitialiser</a></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
