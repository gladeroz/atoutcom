<?php
    wp_register_style('login_css', mvc_css_url('atoutcom-users', 'login'));
    wp_enqueue_style('login_css');
    //var_dump(atoutcomUser::after_find());
    //include 'ajax/atoutcom_users_registration.php'; action="<?php echo plugins_url( 'registration.php', __FILE__ ); 
    //var_dump();
?>

	<div class="col-sm-12">
		<form id="target-registration" >

			<div class="col-sm-12 alert alert-danger text-center error" role="alert" style="display: none;">
		        
		    </div>

		    <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">
		        
		    </div>

			<div class="col-sm-12 alert alert-info text-center info" role="alert" style="display: none;">
			  
			</div>

		    <div class="form-row">
				<div class="form-group col-sm-12">
			        <label for="nom">Nom</label>
			        <input type="text" name="nom" id="nom" class="form-control" required />
			    </div>

			    <div class="form-group col-sm-12">
			        <label for="nom">Prenom</label>
			        <input type="text" name="prenom" id="prenom" class="form-control"/>
			    </div>

				<div class="form-group col-sm-12">
			        <label for="nom">Email</label>
			        <input type="email" name="email" id="email" class="form-control" required/>
			    </div>

				<div class="form-row col-sm-12">
			        <div class="col">
			            <label for="nom">Mot de passe</label>
			            <input type="password" name="password" id="password" class="form-control" required/>
			        </div>

			        <div class="col">
			            <label for="nom">Confirmer mot de passe</label>
			            <input type="password" name="repeat-password" id="repeat-password" class="form-control" required/>
			        </div>
			    </div>

			    <div class="form-row col-sm-12" style="margin-top: 15px; margin-bottom: 15px;">
				    <div class="col">
				        <input id="submit-registration" type="submit" class="btn btn-primary" value="Valider"/>
				    </div>

				    <div class="col">
				        <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>">
				    </div>
			    </div>
		    </div>
		</form>
	</div>

	<div class="col-sm-12" style="margin-bottom: 100px;">
	    <a href="../login/">Vous avez déjà un compte ?</a>
	</div>
