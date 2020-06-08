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
    $userInfo = atoutcomUser::dataUser($email);
    $idUser = $userInfo->id;
    $nom = $userInfo->nom;
    $prenom = $userInfo->prenom;
    //$email = $userInfo->email;
    $adresse = $userInfo->adresse;
    $ville = $userInfo->ville;
    $pays = $userInfo->pays;
    $codePostal = $userInfo->codepostal;
    $telephone_mobile = $userInfo->telephone_mobile;
    $telephone_fixe = $userInfo->telephone_fixe;
    $dateTemp = $userInfo->dateinscription;
    $annee = substr($dateTemp,0, 4);
    $mois = substr($dateTemp, 5, -9);
    $jour = substr($dateTemp, 8, -5);
    $dateInscription = $jour."/".$mois."/".$annee;
    $prospection = $userInfo->prospection;
    $profil = $userInfo->categorie;
    

    $specialite = $userInfo->specialite;
    $isUpdated = $userInfo->isUpdate;

    // Fichiers utilisateurs
    $userFile = atoutcomUser::dataUserFile($email);

    $dataUserEvents = atoutcomUser::formsEvents("listeEventsForUsers");
    //retourner uniquement le tableau contenant les info du user connecté
    $tabUsers = array();
    
    if( sizeof($dataUserEvents) != 0 ){
    	$conference = true;
        foreach ($dataUserEvents as $dataUserEvent) {
        	$tabUser = array();
        	$tab = $dataUserEvent["data"][0];
            if( $tab["email"] === $email ){
	            $tabUser = 
	            array(
                    "titre"=>$dataUserEvent["evenement"],
                    "dateDebut"=>$tab["dateDebut"],
                    "dateEvt"=>$tab["dateDebut"]." - ".$tab["dateFin"],
                    "moisAnneeTexte"=>atoutcomUser::dateFr( "", substr( $tab["dateDebut"], 3, -5 ) )." ".substr( $tab["dateDebut"], 6 ),
                    "villeEvt"=>$tab["villeEvt"],
                    "organisateur"=> $tab["organisateur"],
                    "specialite"=> $tab["specialite"],
	                "participant"=> $tab["nom"]." ".$tab["prenom"]
	            );
            }

            if( !empty($tabUser) ){
                $tabUsers[] = $tabUser;
            }   
        }
    }else{
    	$conference = false;
    }
    //var_dump( date("d/m/Y") );
?>

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
                <a class="icon-edit" id="<?=$idUser?>" data-toggle="modal" data-backdrop="static" data-target="#modalProfil"></a>
                <div class="profil_nom">
				    <span class="icon-user"></span>
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

					    <div class="profil_info_row">
					        <div class="profil_label">
					            Tel. Fixe :
					        </div>
					        <div class="profil_value">
					            <?= $telephone_fixe ?>
					        </div>
					    </div>

					    <div class="profil_info_row">
					        <div class="profil_label">
					            Tel. Mobile :
					        </div>
					        <div class="profil_value">
					            <?= $telephone_mobile ?>
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
                if(sizeof($userFile) > 0){
                    echo "
                <div class='documents_content' style='display : block;'>
                    ";
                }
                else{
                    echo "
                <div class='documents_content' style='display : none;'>
                    ";
                }
            ?>
					<div class="download_cms">
						<div class="download_cms_item">
							<div class="text">
								Document 1
								<span class="document_list_comment">2019</span>
								<span class="document_list_version"></span>
							</div>
							<a href="/documents/914/acces.html" class="bt_dl_file cms_fix">
								<span class="icon-download"></span>
								<div class="bt_dl_text">
									Télécharger
								</div>
							</a>
						</div>
						
						<div class="download_cms_item">
							<div class="text">
								Document 2
								<span class="document_list_comment">2019</span>
								<span class="document_list_version"></span>
							</div>
							<a href="/documents/924/acces.html" class="bt_dl_file cms_fix">
								<span class="icon-download"></span>
								<div class="bt_dl_text">
									Télécharger
								</div>
							</a>
						</div>
					</div>
				</div>
        <?php 
            if(sizeof($userFile) < 0){
                echo "
                <div class='documents_content'>
                    Aucun document disponible
                </div>
                ";
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
    	foreach ($tabUsers as $tabDataUser) {
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
						<span class="plus plus2 icon-chevron-down" onclick="deplier(2)"></span>
						<span class="moins moins2 icon-chevron-up" onclick="plier(2)" style="display: none;">
						</span>
					</div>
				</div>

	            <div class="conf_expend_row_w conf_expend_row_w2" style="display: none;">
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
												'.$tabDataUser["specialite"].'
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
            //if(sizeof($userFile) > 0){
            if($conference){
            	echo '
            <div class="documents_content">
                <div class="download_cms">
                ';
            	foreach ($userFile as $key => $value) {
	                $urlFichier = plugins_url()."/atoutcom-users/app/public/uploads/".$email."/".$value["chemin"];
	                $nomFichier = $value["fichier"];
	                $dataDel = $value["chemin"].",".$value["id"];
	                $dateFichier = substr($value["date_enregistrement"], 0, 10);
                    echo '
                    <div class="download_cms_item">
						<div class="text_w">
							'.$nomFichier.'
							<span class="document_list_comment">'.$dateFichier.'</span>
							<span class="document_list_version"></span>
						</div>
						<a href="" class="bt_dl_file cms_fix" onclick="window.open(\''.$urlFichier.'\')">
							<span class="icon-download"></span>
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
            //if(sizeof($userFile) > 0){
            if($conference){
            	echo '
            <div class="documents_content">
                <div class="download_cms">
                ';
            	foreach ($userFile as $key => $value) {
	                $urlFichier = plugins_url()."/atoutcom-users/app/public/uploads/".$email."/".$value["chemin"];
	                $nomFichier = $value["fichier"];
	                $dataDel = $value["chemin"].",".$value["id"];
	                $dateFichier = substr($value["date_enregistrement"], 0, 10);
                    echo '
                    <div class="download_cms_item">
						<div class="text_w">
							'.$nomFichier.'
							<span class="document_list_comment">'.$dateFichier.'</span>
							<span class="document_list_version"></span>
						</div>
						<a href="" class="bt_dl_file cms_fix" onclick="window.open(\''.$urlFichier.'\')">
							<span class="icon-download"></span>
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
                    echo '
                    <div class="download_cms_item">
						<div class="text_w">
							'.$nomFichier.'
							<span class="document_list_comment">'.$dateFichier.'</span>
							<span class="document_list_version"></span>
						</div>
						<a href="" class="bt_dl_file cms_fix" onclick="window.open(\''.$urlFichier.'\')">
							<span class="icon-download"></span>
							<div class="bt_dl_text">
								Télécharger
							</div>
						</a>
						<a href="" class="bt_dl_file_w cms_fix_w" onclick="suppressionFichier(\''.$dataDel.'\')">
							<span class="icon-remove"></span>
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

<div class="modal fade" id="modalProfil">
    <div class="modal-dialog" role="document">
	    <div class="modal-content" style="width: 600px;">
		    <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Mes informations personnelles</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    <div class="modal-body">
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
			                Prenom :
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
			                Tel. Fixe :
			            </div>
			            <div class="col-sm-4">
			                <input type="text" name="telephone_fixe" id="telephone_fixe" value="<?=$telephone_fixe?>">
			            </div>

			            <div class="col-sm-2">
			                Tel. Mobile :
			            </div>
			            <div class="col-sm-4">
			                <input type="text" name="telephone_mobile" id="telephone_mobile" value="<?=$telephone_mobile?>">
			            </div>
			        </div>

			        <div class="row">
			            <div class="col-sm-2">
			                Date :
			            </div>
			            <div class="col-sm-4">
			                <input type="text" name="dateinscription" id="dateinscription" value="<?=$dateInscription?>" title="Ce champ est en lecture seule" readonly>
			            </div>

                        <div class='col-sm-2'>
			                Pays :
			            </div>
			            <div class='col-sm-4'>
			                <input type='text' name='pays' id='pays' value='<?=$pays?>'>
			            </div>
                <?php 
                    if($profil==="intervenant") {
                    	echo"
                        <div class='col-sm-2'>
			                Spécialité :
			            </div>
			            <div class='col-sm-4'>
			                <input type='text' name='specialite' id='specialite' value='$specialite'>
			            </div>
                    	";
                    }
                ?>
			            
			        </div>

			        <div class="row" style="margin-bottom: 25px; margin-top: 25px;">
			            <div class="col-sm-10">
                            <button type="button" id="submit-update" class="btn btn-success">Confirmer</button>
			                <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: block;">
			            </div>
			        </div>
			    </div>
			    </form>
		    </div>
	    </div>
    </div>
</div>