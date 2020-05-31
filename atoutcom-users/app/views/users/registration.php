<?php
    $cond = ( $_GET["congres"] === null ) ? "" : $_GET["congres"];
?>

<style type="text/css">
	.formRegistration{
		border-color: #2ecac2!important; 
		border: 1px solid black;
		padding-left: 150px;
		padding-top: 50px;
	}

	.titreInscription{
		text-align: center;
        margin-bottom: 25px;
	}

	.mandatory{
        color: red;
    }
</style>
<div class="col-sm-12 formRegistration">
	<form id="target-registration">
        <div class="titreInscription">
        	<h1>Inscription</h1>
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

	    <div class="form-row">
			<div class="form-group col-sm-5">
		        <label for="nom">Nom</label>
		        <input type="text" name="nom" id="nom" class="form-control" required />
		    </div>

		    <div class="form-group col-sm-5">
		        <label for="prenom">Prenom</label>
		        <input type="text" name="prenom" id="prenom" class="form-control"/>
		    </div>

			<div class="form-group col-sm-10">
		        <label for="email">Email</label>
		        <input type="email" name="email" id="email" class="form-control" required/>
		    </div>

			<div class="form-group col-sm-5">
		        <label for="password">Mot de passe</label>
		        <input type="password" name="password" id="password" class="form-control" required/>
		    </div>

		    <div class="form-group col-sm-5">
		        <label for="repeat-password">Confirmer mot de passe</label>
		        <input type="password" name="repeat-password" id="repeat-password" class="form-control" required/>
		    </div>

		    <div class="form-row col-sm-10" style="margin-top: 15px; margin-bottom: 15px;">
			    <div class="col">
			        <input id="submit-registration" type="submit" class="btn btn-primary" value="Valider"/>
			        <input id="redirection" type="hidden" name="redirection" value="<?=$cond?>"/>
			    </div>

			    <div class="col">
			        <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>">
			    </div>
		    </div>

		    <div class="form-group col-sm-10" style="margin-bottom: 70px;">
                <a href="../login/">Vous avez déjà un compte ?</a>
            </div>
	    </div>


	</form>
</div>


