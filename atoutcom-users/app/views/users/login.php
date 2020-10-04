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
    #target-login{
        border-color: #2ecac2!important; 
        border: 1px solid black;
        max-width: 650px!important;
    }

    .categorie, .identifiant, .formLogin, .text-center{
        text-align: left;
    }
    
    .formLogin{
        padding-left: 20%;
    }
    .identifiant{
        margin-top : 20px;
        margin-bottom: 20px;
    }
    
    .loadingConnect{
        text-align: -webkit-center;
    }
    

    .titreLogin {
        text-align: center;
    }
    
    .mandatory{
        color: red;
    }

    input{
        font-size: 18px!important;
        margin-top: 5px;
        margin-bottom: 15px!important;
        background-color: none!important;
        border: 1px solid #27cfc3!important;
    }
    #loading{
        display: none;
    }

    #target-login{
        padding: 5% 8% 5% 8%;
    }

    .text-center{
        text-align: center;
    }
</style>
<!-- Default form login -->

<div class="formLogin">
    <form id="target-login">     
        <div class="container" style="margin-bottom: 5px;">
            <div class="row">
                <div class="col-sm-12 titreLogin">
                    <h2>Connexion</h2>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 alert alert-info text-center info" role="alert" style="display: none;">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 alert alert-danger text-center error" role="alert" style="display: none;">           
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">        
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <input type="radio" id="participant" name="categorie" value="Participant" checked="checked" required>
                    <label for="participant">Participant</label>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="">E-mail</div>
                    <div>
                        <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required="">
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-left">Mot de passe</div>
                    <div>
                         <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required="">
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <input type="checkbox" name="remember" id="remember" class="remember">
                    <label for="remember">Restez connecter</label>
                </div>
            </div>
        </div>

        <div class="container text-center">
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <input type="submit" id="submit-login" class="form-control btn btn-primary btn-lg" value="Connexion" style="width: 200px; height: 43px;"/>
                        <input id="redirection" type="hidden" name="redirection" value="<?=$cond?>"/>
                    </div>

                    <div style="vertical-align: middle;">
                        <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>">
                    </div>                 
                </div>
            </div>
        </div>

        <div class="container text-center">
            <div class="row">
                <div class="form-group col-sm-12">
                    <div>Vous n'avez pas de compte ? <a href="../registration/<?=$cond?>">Créer</a></div>
                    <div>Mot de passe oublié ? <a href="../reset-password/">Réinitialiser</a></div>
                </div>
            </div>
        </div>
    </form>
</div>
