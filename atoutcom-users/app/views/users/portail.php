<?php
    
    session_start();
    
    wp_enqueue_style( 'portail', plugins_url().'/atoutcom-users/app/public/css/portail.css');
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
    $userInfo = atoutcomUser::dataUser($email, $_SESSION["categorie"]);
    $idUser = $userInfo->id;
    $nom = $userInfo->nom;
    $prenom = $userInfo->prenom;
    //$email = $userInfo->email;
    $adresse = $userInfo->adresse;
    $ville = $userInfo->ville;
    $pays = $userInfo->pays;
    $codePostal = $userInfo->codepostal;
    $telephone_professionnel = $userInfo->telephone_professionnel;
    //$telephone_fixe = $userInfo->telephone_fixe;
    $dateInscription = $userInfo->dateinscription;
    $prospection = $userInfo->prospection;
    $profil = $userInfo->categorie;
    
    $specialite = $userInfo->specialite;
    $isUpdated = $userInfo->isUpdate;

    $organismeFact = $userInfo->organisme_facturation;
    $emailFact = $userInfo->email_facturation;
    $adresseFact = $userInfo->adresse_facturation;
    $villeFact = $userInfo->ville_facturation;
    $codepostalFact = $userInfo->codepostal_facturation;
    $paysFact = $userInfo->pays_facturation;

    // Fichiers utilisateurs
    $userFile = atoutcomUser::dataUserFile($email, "user");
    $userFactures = atoutcomUser::dataUserFile($email, "facture");
    $userAttestations = atoutcomUser::dataUserFile($email, "attestation");

    $dataUserEvents = atoutcomUser::formsEvents("listeEventsForUsers");
    //retourner uniquement le tableau contenant les info du user connecté
    $tabUsers = array();
    
    if( sizeof($dataUserEvents) != 0 ){
    	$conference = true;

        foreach ($dataUserEvents as $dataUserEvent) {
        	$tabUser = array();
        	$tab = $dataUserEvent["data"][0];
            if( $tab["Email Professionnel"] === $email ){
            	if( $tab["Date Debut Evenement"] === $tab["Date Fin Evenement"] ){
            		$dateEvt = $tab["Date Debut Evenement"];
            	}else{
            		$dateEvt = $tab["Date Debut Evenement"]." - ".$tab["Date Fin Evenement"];
            	}
	            $tabUser = 
	            array(
                    "titre"=>$dataUserEvent["evenement"],
                    "dateDebut"=>$tab["Date Debut Evenement"],
                    "dateEvt"=>$dateEvt,
                    "moisAnneeTexte"=>atoutcomUser::dateFr( "", substr( $tab["Date Debut Evenement"], 3, -5 ) )." ".substr( $tab["Date Debut Evenement"], 6 ),
                    "villeEvt"=>$tab["Ville Evenement"],
                    "organisateur"=> $tab["Organisateur Evenement"],
                    "specialiteEvt"=> $tab["Specialite Evenement"],
	                "participant"=> $tab["Nom"]." ".$tab["Prenom"]
	            );
            }

            if( !empty($tabUser) ){
                $tabUsers[] = $tabUser;
            }   
        }
    }else{
    	$conference = false;
    }
    //var_dump( $dataUserEvents ); 
?>

<style type="text/css">
	.form-group {
    	display: inline-block;
    }

    div.text-left{
    	margin-bottom: 5px;
    	font-weight: 800;
    }

    .notice {
    	font-weight: 800;
    	color: #e88b48d6;
    }

    .row {
    	padding-bottom: 8px!important;
    }

    input{

        border: 1px solid #27cfc3!important;
    }
</style>


<div class="col-sm-12 col-xs-12">
	<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-left: 0px;">
		<li class="nav-item" style="list-style-type: none;">
			<a class="nav-link active" id="home-tab" data-toggle="tab" href="" role="tab" aria-controls="home" aria-selected="true">Accueil</a>
		</li>
		<li class="nav-item" style="list-style-type: none;">
			<a class="nav-link" id="events-tab" data-toggle="tab" href="" role="tab" aria-controls="events" aria-selected="false">Mes évenements</a>
		</li>
		<li class="nav-item" style="list-style-type: none;">
			<a class="nav-link" id="documents-tab" data-toggle="tab" href="" role="tab" aria-controls="documents" aria-selected="false">Mes documents</a>
		</li>
		<li class="nav-item" style="list-style-type: none;">
			<a class="nav-link" id="disconnect-tab" href="#"><span class="glyphicon glyphicon-off"></span> Deconnexion</a>
		</li>
	</ul>
</div>

<div class="tab-content col-sm-12 col-xs-12" style="margin-bottom: 300px;">
	<div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="profil">
        	<div class="profil_content">
                <a class="my_icon-edit" id="<?=$idUser?>" data-toggle="modal" data-backdrop="static" data-target="#modalProfil">
                	<img src="<?php echo plugins_url().'/atoutcom-users/app/public/images/icon_edit.png';?>">
                </a>
                <div class="profil_nom">
				    <span class="my_icon-user"><img src="<?php echo plugins_url().'/atoutcom-users/app/public/images/icon_user.png';?>"></span>
				    <span class="nom"><?=$nom." ".$prenom ?></span>
				    <span class="statut"><?= $profil ?></span>
				    <input type="hidden" id="isUpdate" value="<?=$isUpdated?>">
				</div>
                
                <div class="profil_detail">
                	<div class="profil_info">
					    <div class="profil_info_row">
					        <div class="profil_label">
					            E-mail :
					        </div>
					        <div class="profil_value">
					            <?= $email ?>
					        </div>
					    </div>

					    <div class="profil_info_row">
					        <div class="profil_label">
					            Adresse :
					        </div>
					        <div class="profil_value">
					            <?= $adresse ?>
					        </div>
					    </div>

					    <div class="profil_info_row">
					        <div class="profil_label">
					            Code Postal :
					        </div>
					        <div class="profil_value">
					            <?= $codePostal ?>
					        </div>
					    </div>

					    <div class="profil_info_row">
					        <div class="profil_label">
					            Ville :
					        </div>
					        <div class="profil_value">
					            <?= $ville ?>
					        </div>
					    </div>

					    <div class="profil_info_row">
					        <div class="profil_label">
					            Pays :
					        </div>
					        <div class="profil_value">
					            <?= $pays ?>
					        </div>
					    </div>

					    <!--<div class="profil_info_row">
					        <div class="profil_label">
					            Tel. Fixe :
					        </div>
					        <div class="profil_value">
					            <?= $telephone_fixe ?>
					        </div>
					    </div>-->

					    <div class="profil_info_row">
					        <div class="profil_label">
					            Tel. Professionnel :
					        </div>
					        <div class="profil_value">
					            <?= $telephone_professionnel ?>
					        </div>
					    </div>

					    <div class="profil_info_row">
					        <div class="profil_label">
					            Date inscription :
					        </div>
					        <div class="profil_value">
					            <?= $dateInscription ?>
					        </div>
					    </div>
                <?php 
                    if($profil==="intervenant"){
                        echo "
                        <div class='profil_info_row'>
					        <div class='profil_label'>
					            Spécialité :
					        </div>
					        <div class='profil_value'>
					            $specialite
					        </div>
					    </div>
                        ";
                    }
                ?>

					</div>	
                </div>

                <?php 
                    if( $organismeFact == "" || $organismeFact == NULL){
                    	echo "<div class='adresseDeFacturation' style='display: none'>";
                    }else{
                    	echo "<div class='adresseDeFacturation' style='display: block'>";
                    }
                ?>
	                <div class="profil_nom">
					    Adresse de facturation
					</div>

					<div class="profil_detail">
	                	<div class="profil_info">
						    
						    <div class="profil_info_row">
						        <div class="profil_label">
						            Organisme :
						        </div>
						        <div class="profil_value">
						            <?= $organismeFact ?>
						        </div>
						    </div>

						    <div class="profil_info_row">
						        <div class="profil_label">
						            Email :
						        </div>
						        <div class="profil_value">
						            <?= $emailFact ?>
						        </div>
						    </div>

						    <div class="profil_info_row">
						        <div class="profil_label">
						            Adresse :
						        </div>
						        <div class="profil_value">
						            <?= $adresseFact ?>
						        </div>
						    </div>

						    <div class="profil_info_row">
						        <div class="profil_label">
						            Ville :
						        </div>
						        <div class="profil_value">
						            <?= $villeFact ?>
						        </div>
						    </div>

						    <div class="profil_info_row">
						        <div class="profil_label">
						            Code Postal :
						        </div>
						        <div class="profil_value">
						            <?= $codepostalFact ?>
						        </div>
						    </div>

						    <div class="profil_info_row">
						        <div class="profil_label">
						            Pays :
						        </div>
						        <div class="profil_value">
						            <?= $paysFact ?>
						        </div>
						    </div>

						</div>
					</div>
				</div>
        	</div>
        </div>

        <div class="info-user">
        	<div class="info_user_w">
				<div class="profil_title">
					Ma prochaine conférence
				</div>
            <?php 
                if($conference){
                	foreach ($tabUsers as $tabDataUser) {
                		if( $tabDataUser["dateDebut"] > date("d/m/y") ){
                			$titre = $tabDataUser["titre"];
                		    $lieu = $tabDataUser["villeEvt"];
                		    $dateEvt = $tabDataUser["dateDebut"];
                			break;
                		}else{
                			$titre = "";
                		}
                	} 
                }
                
                if($titre != ""){
                	echo "
                <div class='info_user_content_w' style='display : block;'>
                    ";
                }else{
                	echo "
                <div class='info_user_content_w' style='display : none;'>
                    ";
                }                
            ?>
					<div class="info_user_content">
						<div class="info_user_row">
							<div class="info_user_label">
								Ttre :
							</div>
							<div class="info_user_value">
								<?=$titre?>
							</div>
						</div>
						<div class="info_user_row">
							<div class="info_user_label">
								Lieu :
							</div>
							<div class="info_user_value">
								<?=$lieu?>
							</div>
						</div>
						<div class="info_user_row">
							<div class="info_user_label">
								Date :
							</div>
							<div class="info_user_value">
								<?=$dateEvt?>
							</div>
						</div>
					</div>

				</div>
			<?php 
                if($titre == ""){
                    echo "
                <div>
					Aucune inscription enregistrée
				</div>
                    ";
                }
            ?>
			</div>

			<div class="documents_info">
				<div class="documents_title">
					Documents utiles
				</div>
        <?php 
            if(sizeof($userAttestations) > 0){
            	echo '
            <div class="documents_content">
                <div class="download_cms">
                ';
            	foreach ($userAttestations as $key => $value) {
	                $urlFichier = plugins_url()."/atoutcom-users/app/public/uploads/".$email."/".$value["chemin"];
	                $nomFichier = $value["fichier"];
	                $dataDel = $value["chemin"].",".$value["id"];
	                $dateFichier = substr($value["date_enregistrement"], 0, 10); 
	                $dateFr = substr($dateFichier, 8)."/".substr($dateFichier, 5, -3)."/".substr($dateFichier, 0, 4);
                    echo '
                    <div class="download_cms_item">
						<div class="text_w_a_f">
							'.$nomFichier.'
							<span class="document_list_comment">'.$dateFr.'</span>
							<span class="document_list_version"></span>
						</div>
						<a href="" class="bt_dl_file cms_fix" onclick="window.open(\''.$urlFichier.'\')" style="float:right;">
							<span class="glyphicon glyphicon-download-alt"></span>
							<div class="bt_dl_text">
								Télécharger
							</div>
						</a>
					</div>
                    ';
                }
                echo '
                </div>
            </div>
                ';
            }
            else{
                echo '
            <div class="documents_content">
                Aucun document disponible
            </div>
                ';
            }
        ?>		
			</div>
        </div>
	</div>

<div class="tab-pane" id="events" role="tabpanel" aria-labelledby="events-tab">
	<div id="conf_rows">
<?php 
    if( sizeof($tabUsers) === 0 ) {
   	    echo" Vous n'avez pas d'évenements";
    }else{
    	foreach ($tabUsers as $key => $tabDataUser) {
            echo '
			<div class="conf_row_w" data-toggle="container">
				<div class="conf_row ">
					<div class="date">
						'.$tabDataUser["moisAnneeTexte"].'
					</div>
					<div class="conf_detail_theme">
						<span>Thème :</span>
						<span>'.$tabDataUser["titre"].'</span>
					</div>
					<div class="conf_detail_lieu">
						<span>Lieu :</span>
						<span>'.$tabDataUser["villeEvt"].'</span>
					</div>

					<div class="conf_expend" data-toggle="button">
						<a href="" class="plus'.$key.'" onclick="deplier('.$key.')">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
						<a href="" class="moins'.$key.'" onclick="plier('.$key.')" style="display: none;">
							<span class="glyphicon glyphicon-chevron-up"></span>
						</a>
					</div>
				</div>

	            <div class="conf_expend_row_w conf_expend_row_w'.$key.'" style="display: none;">
					<div class="conf_expend_row" data-toggle="container">
						<div class="conf_decompte_w" data-toggle="element">
							<div class="conf_decompte " data-type="count_container">
								<table class="decompte_table" cellspacing="0" cellpadding="0">
									<tbody>
										<tr>
											<th>
												Date
											</th>
											<th>
												Organisateur
											</th>
											<th>
												Titre
											</th>

											<th>
												Spécialité
											</th>
											<th>
												Lieu
											</th>
											<th>
												Participant
											</th>
										</tr>
										<tr>
											<td>
												'.$tabDataUser["dateEvt"].'
											</td>
											<td>
												'.$tabDataUser["organisateur"].'
											</td>
											<td>
												'.$tabDataUser["titre"].'
											</td>
											<td>
												'.$tabDataUser["specialiteEvt"].'
											</td>
											<td>
												'.$tabDataUser["villeEvt"].'
											</td>
											<td>
												'.$tabDataUser["participant"].'
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
			    </div>
			</div>
	        ';
        }
    }
?>



	</div>
</div>

<div class="tab-pane" id="documents" role="tabpanel" aria-labelledby="documents-tab">
	<div class="col-sm-12 alert alert-success text-center successFile" role="alert" style="display: none;">

	</div>

	<div class="col-sm-12 alert alert-danger text-center errorFile" role="alert" style="display: none;">

	</div>
    
    <div class="doc">
		<div class="doc_content">
			<div class="doc_nom">
				<span class="nom">Transmettre un document</span>
			</div>
			
			<div class="doc_detail">
				<div class="doc_info">
					<form class="form-fichier" id="form-fichier1" enctype="multipart/form-data">
						<div class="row" style="margin-top: 25px;">
							<div class="col-sm-4">
								<input type="file"  id="fichier1" name="fichier1">
							</div>
						</div>

						<div class="row" style="margin-top: 25px;">
							<div class="col-sm-10">
								<button type="button" id="submit-fichier1" class="btn btn-primary btn-lg">
									<span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Envoyer
								</button>
								<img id="loading-fichier1" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: none;">
							</div>
						</div>
					</form>

				</div>	
			</div>
		</div>
	</div>

	<div class="doc-user">
        <div class="doc_user_w">
			<div class="doc_title">
				Mes Factures
			</div>
        <?php 
            if(sizeof($userFactures) > 0){
            	echo '
            <div class="documents_content">
                <div class="download_cms">
                ';
            	foreach ($userFactures as $key => $value) {
	                $urlFichier = plugins_url()."/atoutcom-users/app/public/uploads/".$email."/".$value["chemin"];
	                $nomFichier = $value["fichier"];
	                $dataDel = $value["chemin"].",".$value["id"];
	                $dateFichier = substr($value["date_enregistrement"], 0, 10);
	                $dateFr = substr($dateFichier, 8)."/".substr($dateFichier, 5, -3)."/".substr($dateFichier, 0, 4);
                    echo '
                    <div class="download_cms_item">
						<div class="text_w_a_f">
							'.$nomFichier.'
							<span class="document_list_comment">'.$dateFr.'</span>
							<span class="document_list_version"></span>
						</div>
						<a href="" class="bt_dl_file cms_fix" onclick="window.open(\''.$urlFichier.'\')">
							<span class="glyphicon glyphicon-download-alt"></span>
							<div class="bt_dl_text">
								Télécharger
							</div>
						</a>
					</div>
                    ';
                }
                echo '
                </div>
            </div>
                ';
            }
            else{
                echo '
            <div class="documents_content">
                Aucun document disponible
            </div>
                ';
            }
        ?>
		</div>

        <div class="doc_user_w">
			<div class="doc_title">
				Mes Attestations
			</div>
        <?php 
            if(sizeof($userAttestations) > 0){
            	echo '
            <div class="documents_content">
                <div class="download_cms">
                ';
            	foreach ($userAttestations as $key => $value) {
	                $urlFichier = plugins_url()."/atoutcom-users/app/public/uploads/".$email."/".$value["chemin"];
	                $nomFichier = $value["fichier"];
	                $dataDel = $value["chemin"].",".$value["id"];
	                $dateFichier = substr($value["date_enregistrement"], 0, 10); 
	                $dateFr = substr($dateFichier, 8)."/".substr($dateFichier, 5, -3)."/".substr($dateFichier, 0, 4);
                    echo '
                    <div class="download_cms_item">
						<div class="text_w_a_f">
							'.$nomFichier.'
							<span class="document_list_comment">'.$dateFr.'</span>
							<span class="document_list_version"></span>
						</div>
						<a href="" class="bt_dl_file cms_fix" onclick="window.open(\''.$urlFichier.'\')" style="float:right;">
							<span class="glyphicon glyphicon-download-alt"></span>
							<div class="bt_dl_text">
								Télécharger
							</div>
						</a>
					</div>
                    ';
                }
                echo '
                </div>
            </div>
                ';
            }
            else{
                echo '
            <div class="documents_content">
                Aucun document disponible
            </div>
                ';
            }
        ?>
		</div>

        <div class="doc_user_w">
			<div class="doc_title">
				Mes documents transmis
			</div>
        <?php 
            if(sizeof($userFile) > 0){
            	$urlAdmin = admin_url();
            	echo '
            <div class="documents_content">
                <div class="download_cms">
                ';
            	foreach ($userFile as $key => $value) {
	                $urlFichier = plugins_url()."/atoutcom-users/app/public/uploads/".$email."/".$value["chemin"];
	                $nomFichier = $value["fichier"];
	                $dataDel = $value["chemin"].",".$value["id"];
	                $dateFichier = substr($value["date_enregistrement"], 0, 10);
	                $dateFr = substr($dateFichier, 8)."/".substr($dateFichier, 5, -3)."/".substr($dateFichier, 0, 4);
                    echo '
                    <div class="download_cms_item">
						<div class="text_w">
							'.$nomFichier.'
							<span class="document_list_comment">'.$dateFr.'</span>
							<span class="document_list_version"></span>
						</div>
						<a href="" class="bt_dl_file cms_fix" onclick="window.open(\''.$urlFichier.'\')">
							<span class="glyphicon glyphicon-download-alt"></span>
							<div class="bt_dl_text">
								Télécharger
							</div>
						</a>
						<a href="" class="bt_dl_file_w cms_fix_w" onclick="suppressionFichier(\''.$dataDel.'\')">
							<span class="glyphicon glyphicon-remove"></span>
							<div class="bt_dl_text_w">
								Supprimer
							</div>
						</a>
						<img  class="loadFile'.$value["id"].'" src="'.$urlAdmin.'images/loading.gif"  style="display: none;">
					</div>
                    ';
                }
                echo '
                </div>
            </div>
                ';
            }
            else{
                echo '
            <div class="documents_content">
                Aucun document disponible
            </div>
                ';
            }
        ?>
		</div>
	</div>
</div>

<div class="modal fade" id="modalProfil" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content text-center" style="margin-top: 90px;">
		    <div class="modal-header">
		        <h5 class="modal-title text-center" id="exampleModalLabel">Je complète mes informations personnelles</h5>
		    </div>
		    <div class="modal-body">
		        <form id="form_updateUserInfo">
			        <div class="container col-sm-12 col-md-12">
			            <div class="col-sm-12 alert alert-danger text-center error" role="alert" style="display: none;">
			        
			            </div>
			            <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">
			  
			            </div>

			            <div class="row">
				            <div class="form-group col-sm-3">
				            	<div class="text-left">Nom</div>
				                <div><input type="text" name="nom" id="nom" value="<?=$nom?>"></div>
				                <input type="hidden" name="idUser" id="idUser" value="<?=$idUser?>" required>
				            </div>

			                <div class="form-group col-sm-3">
			                	<div class="text-left">Prénom</div>
			                    <div><input type="text" name="prenom" id="prenom" value="<?=$prenom?>" required></div>
			                </div>

			                <div class="form-group col-sm-5">
				            	<div class="text-left">Email</div>
				                <div>
				                	<input type="text" name="email" id="email" value="<?=$email?>" title="Ce champ est en lecture seule" readonly required style="background-color: #cec9c9;">
				                </div>
				            </div>
			            </div>

				        <div class="row">
				            <div class="form-group col-sm-4">
				            	<div class="text-left"> Adresse</div>
				                <div><input type="text" name="adresse" id="adresse" value="<?=$adresse?>" required></div>
				            </div>

				            <div class="form-group col-sm-3">
				            	<div class="text-left">Ville</div>
				                <div><input type="text" name="ville" id="ville" value="<?=$ville?>" required></div>
				            </div>

				            <div class="form-group col-sm-2">
				            	<div class="text-left">Code Postal</div>
				                <div><input type="text" name="codepostal" id="codepostal" value="<?=$codePostal?>" required></div>
				            </div>

				            <div class="form-group col-sm-2">
				            	<div class="text-left">Pays</div>
				                <div><input type='text' name='pays' id='pays' value='<?=$pays?>' required></div>
				            </div>
				        </div>
				        
				        <div class="row">
				            <div class="form-group col-sm-4">
				            	<div class="text-left">Tel. Professionnel</div>
				                <div><input type="text" name="telephone_professionnel" id="telephone_professionnel" value="<?=$telephone_professionnel?>" required></div>
				            </div>

				            <div class="form-group col-sm-3">
				            	<div class="text-left">Date d'inscription</div>
				                <div><input type="text" name="dateinscription" id="dateinscription" value="<?=$dateInscription?>" title="Ce champ est en lecture seule" readonly style="background-color: #cec9c9;"></div>
				            </div>
				        </div>

	                <?php 
	                    if($profil==="intervenant") {
	                    	echo"
	                    	<div class='row'>
					            <div class='form-group col-sm-12'>
					                <div class='text-left'> Spécialité :</div>
					                <input type='text' name='specialite' id='specialite' value='$specialite' required>
					            </div>
				            </div>
	                    	";
	                    }
	                ?>

				        <div class="row">
				            <div class="col-sm-12 notice">
				            	<input type="checkbox" id="blocAdresseFact">
				                <label>Ajouter ou modifier une adresse de facturation différente de l'adresse professionnelle</label>
				            </div>
				        </div>
                        
                        <div class="blocAdresseFacturation" style="display: none;">
	                        <div class="row">
					            <div class="form-group col-sm-5">
					            	<div class="text-left">Organisme/Société</div>
					                <div><input type="text" name="organismeFact" class="factRequired" id="organismeFact" value="<?=$organismeFact?>"></div>
					            </div>
                                
                                <div class="form-group col-sm-6">
					            	<div class="text-left">Email de facturation</div>
					                <div><input type="text" name="emailFact" class="factRequired" id="emailFact" value="<?=$emailFact?>"></div>
					            </div>
					            
					        </div>

					        <div class="row">
					        	<div class="form-group col-sm-4">
					            	<div class="text-left">Adresse de facturation</div>
					                <div><input type="text" name="adresseFact" class="factRequired" id="adresseFact" value="<?=$adresseFact?>"></div>
					            </div>

					            <div class="form-group col-sm-3">
					            	<div class="text-left">Ville</div>
					                <div><input type="text" name="villeFact" class="factRequired" id="villeFact" value="<?=$villeFact?>"></div>
					            </div>

					            <div class="form-group col-sm-2">
					                <div class="text-left">Code Postal</div>
					                <div><input type="text" name="codepostalFact" class="factRequired" id="codepostalFact" value="<?=$codepostalFact?>"></div>
					            </div>

					            <div class="form-group col-sm-2">
					                <div class="text-left">Pays</div>
					                <div><input type="text" name="paysFact" class="factRequired" id="paysFact" value="<?=$paysFact?>"></div>
					            </div>

					        </div>
                        </div>

				        <div class="row" style="margin-top: 15px;">
				        	<div class="form-group col-sm-12 text-left">
							    <input type="submit" id="submit-update" value="Confirmer">
							</div>
							
							<div class="form-group" style="vertical-align: middle;">
							    <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>" style="padding-top: 11px;">
							</div>
				        </div>
				    </div>
			    </form>
		    </div>
	    </div>
    </div>
</div>