<?php
    $cond = ( $_GET["congres"] === null ) ? "" : $_GET["congres"];
?>

<style type="text/css">
	.formRegistration{
		border-color: #2ecac2!important; 
		border: 1px solid black;
	}

	.titreInscription {
		margin-top: 40px;
        margin-bottom: 25px;
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
<div class="col-sm-10 col-md-10 formRegistration">

	<form id="target-registration" class="text-center">			
                
		<div class="container">
			<div class="row">
		        <div class="form-group col-sm-10 titreInscription">
		        	<h2>Inscription</h2>
		        </div>
	        </div>

            <div class="form-group col-sm-12 col-md-12 alert alert-danger error" role="alert" style="display: none;">
			    
			</div>

			<div class="form-group col-sm-12 col-md-12 alert alert-success text-center success" role="alert" style="display: none;">
			      
			</div>

		    <div class="form-group col-sm-12 col-md-12 alert alert-info text-center info" role="alert" style="display: none;">
				  
			</div>

        	<div class="row">
        		<div class="form-group col-sm-10 text-left">Selectionner votre catégorie <span class="mandatory">*</span> :</div>
	        	<div class="form-group col-sm-10 text-left">
			        <input type="radio" id="participant" name="categorie" value="participant" required>
			        <label for="participant">Participant</label>
			    </div>

			    <div class="form-group col-sm-10 text-left" style="margin-bottom: 25px; margin-top: 10px;">
			        <input type="radio" id="intervenant" name="categorie" value="intervenant">
			        <label for="intervenant">Intervenant</label>
			    </div>
        	</div>


        </div>
        

	    

	    <div class="container">
	    	<div class="row">
	    		<div class="form-group col-sm-5">
			        <div class="text-left">Nom</div>
			        <div><input type="text" name="nom" id="nom" class="form-control" required /></div>
			    </div>

			    <div class="form-group col-sm-5">
			        <div class="text-left">Prénom</div>
			        <div><input type="text" name="prenom" id="prenom" class="form-control"/></div>
			    </div>
	    	</div>
			
            <div class="row">
				<div class="form-group col-sm-10">
			        <div class="text-left">Email</div>
			        <div><input type="email" name="email" id="email" class="form-control" required/></div>
			    </div>
            </div>

            <div class="row">
				<div class="form-group col-sm-5">
			        <div class="text-left">Mot de passe</div>
			        <div><input type="password" name="password" id="password" class="form-control" required/></div>
			    </div>


			    <div class="form-group col-sm-5">
			        <div class="text-left">Confirmer mot de passe</div>
			        <div><input type="password" name="repeat-password" id="repeat-password" class="form-control" required/></div>
			    </div>
		    </div>

            <div class="row">
			    <div class="form-group col-sm-10" style="margin-top: 15px; margin-bottom: 15px;">
				    <div class="form-group"><input id="submit-registration" type="submit" value="Valider" style="width: 200px; height: 43px;"/></div>
				    <div class="form-group" style="vertical-align: middle;">
				        <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>">
				    </div>
				    <input id="redirection" type="hidden" name="redirection" value="<?=$cond?>"/>				    
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


