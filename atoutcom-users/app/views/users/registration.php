<?php
    $cond = ( $_GET["congres"] === null ) ? "" : $_GET["congres"];
?>

<style type="text/css">
	#target-registration{
		border-color: #2ecac2!important; 
		border: 1px solid black;
		max-width: 700px!important;
	}

	.titreInscription {
        margin-bottom: 10px;
        text-align: center;
	}
    
	.mandatory{
        color: red;
    }


    input{
    	font-size: 18px!important;
    	margin-top: 3px;
    	background-color: none!important;
    	border: 1px solid #27cfc3!important;
    	margin-bottom: 15px!important;
    }

    #loading{
    	display: none;
    }

    #target-registration{
    	padding: 3% 10% 3% 10%;
    }

    .formRegistration{
    	padding-left: 20%;
    }
</style>

<div class="formRegistration">
	<form id="target-registration" class="text-center">			
        <div class="col-sm-12 titreInscription">
        	<h2>Création de compte</h2>
        </div>

        <div class="col-sm-12 col-md-12 alert alert-danger error" role="alert" style="display: none;">
		    
		</div>

		<div class="col-sm-12 col-md-12 alert alert-success text-center success" role="alert" style="display: none;">
		      
		</div>

	    <div class="col-sm-12 col-md-12 alert alert-info text-center info" role="alert" style="display: none;">
			  
		</div>

    	<div class="col-sm-12 text-left">
	        <input type="radio" id="participant" name="categorie" value="Participant" checked="checked" required>
	        <label for="participant">Participant</label>
	    </div>

	    <div class="container">
	    	<div class="row">
				<div class="col-sm col-md">
			        <div class="text-left">Nom</div>
			        <div><input type="text" name="nom" id="nom" class="form-control" required /></div>
			    </div>

			    <div class="col-sm col-md">
			        <div class="text-left">Prénom</div>
			        <div><input type="text" name="prenom" id="prenom" class="form-control"/></div>
			    </div>
			</div>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
			        <div class="text-left">Email Professionnel</div>
			        <div><input type="email" name="email" id="email" class="form-control" required/></div>
			    </div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-sm-12">
			        <div class="text-left">Mot de passe</div>
			        <div><input type="password" name="password" id="password" class="form-control" required title="Le mot de passe doit comporter au moins 8 caractères et doit inclure au moins une lettre majuscule, un chiffre et un caractère spécial"/></div>
			    </div>
			</div>
	    </div>

	    <div class="container">
	    	<div class="row">
			    <div class="col-sm-12">
			        <div class="text-left">Confirmer mot de passe</div>
			        <div><input type="password" name="repeat-password" id="repeat-password" class="form-control" required title="Le mot de passe doit comporter au moins 8 caractères et doit inclure au moins une lettre majuscule, un chiffre et un caractère spécial"/></div>
			    </div>
			</div>
		</div>

		<div class="container">
			<div class="row">
		    	<div class="col-sm-12 text-left">
			        <div>Règles pour le mot de passe :</div>
			        <div style="color: red">
			        	<ul>
			        		<li>8 caractères minimum</li>
			        		<li>Au moins une lettre majuscule</li>
			        		<li>Au moins un chiffre</li>
			        		<li>Au moins un caractère spécial</li>
			        	</ul>
			        </div>
			    </div>
			</div>
		</div>

		<div class="container">
			<div class="row">
			    <div class="col-sm-12" style="margin-top: 5px; margin-bottom: 15px; text-align: center;">
				    <div class="form-group"><input id="submit-registration" type="submit" value="Valider" style="width: 200px; height: 43px;"/></div>
				    <div class="form-group" style="vertical-align: middle;">
				        <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>">
				    </div>
				    <input id="redirection" type="hidden" name="redirection" value="<?=$cond?>"/>				    
			    </div>
			</div>
		</div>

		<div class="container">
			<div class="row">
			    <div class="col-sm-12" style="margin-bottom: 10px; text-align: center;">
		            <a href="../login/">Vous avez déjà un compte ?</a>
		        </div>
        	</div>
		</div>
	    
	</form>
</div>


