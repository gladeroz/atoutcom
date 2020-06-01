<?php
    $cond = ( $_GET["congres"] === null ) ? "" : $_GET["congres"];
?>

<style type="text/css">
	.formRegistration{
		border-color: #2ecac2!important; 
		border: 1px solid black;
		padding-left: 250px;
		padding-top: 50px;
		font-size: 18px;
	}

	.titreInscription{
		padding-left: 200px;
        margin-bottom: 25px;
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
<div class="col-sm-10 formRegistration">
	<form id="target-registration">
        <div class="titreInscription">
        	<h2>Inscription</h2>
        </div>

		<div class="col-sm-8 alert alert-danger text-center error" role="alert" style="display: none;">
	        
	    </div>

	    <div class="col-sm-8 alert alert-success text-center success" role="alert" style="display: none;">
	        
	    </div>

		<div class="col-sm-8 alert alert-info text-center info" role="alert" style="display: none;">
		  
		</div>
        
        <p class="categorie">Selectionner votre catégorie <span class="mandatory">*</span> :</p>

	    <div class="categorie">
	        <input type="radio" id="participant" name="categorie" value="participant" required>
	        <label for="participant">Participant</label>
	    </div>

	    <div class="categorie" style="margin-bottom: 25px;">
	        <input type="radio" id="intervenant" name="categorie" value="intervenant">
	        <label for="intervenant">Intervenant</label>
	    </div>

	    <div class="container">
	    	<div class="row">
	    		<div class="form-group col-sm-4">
			        <label for="nom">Nom</label>
			        <input type="text" name="nom" id="nom" class="form-control" required />
			    </div>

			    <div class="form-group col-sm-4">
			        <label for="prenom">Prenom</label>
			        <input type="text" name="prenom" id="prenom" class="form-control"/>
			    </div>
	    	</div>
			
            <div class="row">
				<div class="form-group col-sm-8">
			        <label for="email">Email</label>
			        <input type="email" name="email" id="email" class="form-control" required/>
			    </div>
            </div>

            <div class="row">
				<div class="form-group col-sm-4">
			        <label for="password">Mot de passe</label>
			        <input type="password" name="password" id="password" class="form-control" required/>
			    </div>


			    <div class="form-group col-sm-4">
			        <label for="repeat-password">Confirmer mot de passe</label>
			        <input type="password" name="repeat-password" id="repeat-password" class="form-control" required/>
			    </div>
		    </div>

            <div class="row">
			    <div class="form-row col-sm-8" style="margin-top: 15px; margin-bottom: 15px;">
				    <div class="col">
				        <input id="submit-registration" type="submit" value="Valider" style="width: 200px; height: 43px;"/>
				        <input id="redirection" type="hidden" name="redirection" value="<?=$cond?>"/>
				    </div>

				    <div class="col">
				        <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>">
				    </div>
			    </div>
		    </div>

            <div class="row">
			    <div class="form-group col-sm-10" style="margin-bottom: 70px;">
	                <a href="../login/">Vous avez déjà un compte ?</a>
	            </div>
            </div>
	    </div>


	</form>
</div>


