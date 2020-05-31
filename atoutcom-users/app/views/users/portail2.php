<?php
    session_start();

    if( $_SESSION["loginEmail"] ==="disconnect" ) {
      //redirection vers la page de login
      echo '<script language="Javascript">document.location.replace("login/"); </script>';
    }else{
        
        if($_COOKIE["LOGIN"] !=NULL){
          $email = $_COOKIE["LOGIN"];
          $_SESSION["loginEmail"] = $email;
        }else{
          
          if( $_SESSION["loginEmail"] === NULL ){
            //redirection
            echo '<script language="Javascript">document.location.replace("login/"); </script>';
          }else{
            $email = $_SESSION["loginEmail"];
          }
        }
    }
    $userInfo = atoutcomUser::dataUser($email);
    $idUser = $userInfo->id;
    $nom = $userInfo->nom;
    $prenom = $userInfo->prenom;
    //$email = $userInfo->email;
    $adresse = $userInfo->adresse;
    $ville = $userInfo->ville;
    $codePostal = $userInfo->codepostal;
    $telephone = $userInfo->telephone;
    $dateInscription = $userInfo->dateinscription;
    $prospection = $userInfo->prospection;

    // Fichiers utilisateurs
    $userFile = atoutcomUser::dataUserFile($email);
?>
<style type="text/css">
	.modal-backdrop{
		position: inherit;
	}

	.modal{
		position: absolute;
		overflow-y: hidden;
		
	}

	.modal-open .modal{
		overflow-y: hidden;
	}

	.modal-content{
		height: 500px;
	}

	#appercu{
		height: 600px;
	}

  .fichierUpload, .fichierView{
    border: 1px solid;
    box-shadow: 5px 10px #888888;
    height: 400px;
  }

  .fichierUpload{
    margin-right: 50px;
  }
</style>
<div class="col-sm-12 col-xs-12">
  <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-left: 0px;">
    <li class="nav-item" style="list-style-type: none;">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Mes informations</a>
    </li>
    <li class="nav-item" style="list-style-type: none;">
      <a class="nav-link" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="events" aria-selected="false">Mes Ã©venements</a>
    </li>
    <li class="nav-item" style="list-style-type: none;">
      <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false">Mes documents</a>
    </li>
    <li class="nav-item" style="list-style-type: none;">
      <a class="nav-link" id="disconnect-tab" href="#"><span class="glyphicon glyphicon-off"></span> Deconnexion</a>
    </li>
  </ul>
</div>

<div class="tab-content col-sm-12 col-xs-12" style="margin-bottom: 30px;">
  <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <form id="target-update">
      <div class="container">
        <div class="col-sm-12 alert alert-danger text-center error" role="alert" style="display: none;">
        
        </div>
        <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">
  
        </div>
        <div class="row">
          <div class="col-sm-2">
            Nom :
          </div>
          <div class="col-sm-10">
            <input type="text" name="nom" id="nom" value="<?=$nom?>">
            <input type="hidden" name="idUser" id="idUser" value="<?=$idUser?>">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">
            PrÃ©nom :
          </div>
          <div class="col-sm-10">
            <input type="text" name="prenom" id="prenom" value="<?=$prenom?>">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">
            Email :
          </div>
          <div class="col-sm-10">
            <input type="text" name="email" id="email" value="<?=$email?>">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">
            Adresse :
          </div>
          <div class="col-sm-10">
            <input type="text" name="adresse" id="adresse" value="<?=$adresse?>">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">
            Ville :
          </div>
          <div class="col-sm-4">
            <input type="text" name="ville" id="ville" value="<?=$ville?>">
          </div>

          <div class="col-sm-2">
            Code Postal :
          </div>
          <div class="col-sm-4">
            <input type="text" name="codepostal" id="codepostal" value="<?=$codePostal?>">
          </div>
        </div>
        
        <div class="row">
          <div class="col-sm-2">
            Telephone :
          </div>
          <div class="col-sm-10">
            <input type="text" name="telephone" id="telephone" value="<?=$telephone?>">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">
            Date :
          </div>
          <div class="col-sm-4">
            <input type="text" name="dateinscription" id="dateinscription" value="<?=$dateInscription?>" title="Ce champ est en lecture seule" readonly>
          </div>

          <div class="col-sm-2">
            Prospection :
          </div>
          <div class="col-sm-4">
            <input type="text" name="prospection" id="prospection" value="<?=$prospection?>" title="Ce champ est en lecture seule" readonly>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-10">
            <input class="btn btn-primary" type="submit" id="submit-update" value="Mettre Ã  jour">
            <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: none;">
          </div>
        </div>

      </div>
    </form>
  </div>

<div class="tab-pane" id="events" role="tabpanel" aria-labelledby="events-tab">
  

  
</div>

<div class="tab-pane" id="documents" role="tabpanel" aria-labelledby="documents-tab">
	<div class="col-sm-12 alert alert-success text-center successFile" role="alert" style="display: none;">
  
    </div>

    <div class="col-sm-12 alert alert-danger text-center errorFile" role="alert" style="display: none;">
        
    </div>

	<div class="row">

	    <div class="fichierUpload col-sm-4 shadow-lg p-3 mb-5 bg-grey rounded">
		    <div class="fichier1">
		        <form class="form-fichier" id="form-fichier1" enctype="multipart/form-data">
				    <div class="row">
              <div class="col-sm-12">
                <h3>Je transmets un document</h3>
              </div>
            </div>

            <div class="row">
				        <div class="col-sm-4">
				            <input type="file"  id="fichier1" name="fichier1">
				        </div>
				    </div>

					<div class="row">
					    <div class="col-sm-10">
					        <!--<input class="btn btn-primary" type="submit" id="submit-fichier1" value="Enregistrer">-->
                  <button type="submit" id="submit-fichier1" class="btn btn-primary btn-lg" style="background-color: #007bff; border-radius: 10px;">
                    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Envoyer
                  </button>
					        <img id="loading-fichier1" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: none;">
					    </div>
					</div>
		        </form>
		    </div>

		    <!--<br><br>
		    <div class="fichier2">
		        <form class="form-fichier" id="form-fichier2">
				    <div class="row">
				        <div class="col-sm-2">
				            Fichier 2 :
				        </div>
				        <div class="col-sm-4">
				            <input type="file"  id="fichier2" name="fichier2">
				        </div>
				    </div>

					<div class="row">
					    <div class="col-sm-10">
					        <input class="btn btn-primary" type="submit" id="submit-fichier2" value="Enregistrer">
					        <img id="loading-fichier2" src="<?php //echo admin_url().'/images/loading.gif';?>" style="display: none;">
					    </div>
					</div>
		        </form>
		    </div>

		    <br><br>
		    <div class="fichier3">
		        <form class="form-fichier" id="form-fichier3">
				    <div class="row">
				        <div class="col-sm-2">
				            Fichier 3 :
				        </div>
				        <div class="col-sm-4">
				            <input type="file"  id="fichier3" name="fichier3">
				        </div>
				    </div>

					<div class="row">
					    <div class="col-sm-10">
					        <input class="btn btn-primary" type="submit" id="submit-fichier3" value="Enregistrer">
					        <img id="loading-fichier3" src="<?php //echo admin_url().'/images/loading.gif';?>" style="display: none;">
					    </div>
					</div>
		        </form>
		    </div>-->
	    </div>
        
        <?php 
            if(sizeof($userFile) > 0){
            	$urlAdmin = admin_url();
            	echo "
            	    <div class='fichierView col-sm-6 shadow-lg p-3 mb-5 bg-grey rounded' id='fichierUser'>
				    	<div class='row'>
					    	<div class='col-sm-12'>
					    	    <h3>Je consulte mes documents</h3>
					        </div>
				        </div>
            	";
           
            	foreach ($userFile as $key => $value) {
                	$urlFichier = plugins_url().'/atoutcom-users/app/public/uploads/'.$email.'/'.$value["chemin"];
                	$nomFichier = $value["fichier"];
                    $dataDel = $value["chemin"].",".$value["id"];
                	echo "
			            <div class='row'>
				    		<div class='col-sm-2'>
				    			$nomFichier
				    		</div>

				    	    <div class='col-sm-4'>
				    	      <button type='submit' onclick='window.open(\"".$urlFichier."\")' style='background-color:green;'>
                      <span class='glyphicon glyphicon-download' aria-hidden='true'></span> TÃ©lÃ©charger
                    </button>
				    		</div>

				    		<div class='col-sm-6'>
				    		    <form class='form-delete-file'>
				    			    <input type='hidden' class='fileDelete' value='".$dataDel."'>
                      <div class='row'>
					    			    <div class='col-sm-4'>
                          <button type='submit' class='btnDelete' style='background-color:red; width : max-content;'>
                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Suprimer
                          </button>
					    		      </div>

					    			    <div class='col-sm-3'>
					    		        <img  class='loadFile' src='$urlAdmin/images/loading.gif'  style='display: none;'>
					    		      </div>
				    		      </div>
				    			</form>
				    			
				    		</div>
				    	</div>
                	";

                }
                echo "</div>";

            }
        ?>
    </div>
</div>