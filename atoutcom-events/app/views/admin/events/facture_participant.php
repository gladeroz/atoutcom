<?php
    $dataEvent = atoutcomUser::formsEvents("listeEventsForSponsors");
    $listEvents = array();
    // Filtré les évenements pour ne pas chopper des doublons
    foreach ($dataEvent as $data) {
        $event = $data["evenement"];
        if(empty($listEvents)){
            array_push($listEvents, $data);
        }else{
            foreach ($listEvents as $value) {
                if( !in_array($event, $value) ){
                    array_push($listEvents, $data);
                }
            }
        }
    }
?>
<style type="text/css">
    .header{
        text-align: center;
        font-size: 50px;
        font-weight: 700;
    }

    td.details-control{
         color:green;
         cursor: pointer;
    }

    tr.shown td.details-control{
        color:red;
        cursor: pointer;
    }

    .loadingFacture{
    	text-align: -webkit-center;
    }

    .facture_participant{
        display: none;
    }

    #manage_facture{
        width: max-content!important;
    }

    #exportExcelParticipant{
        background-color: #e2e6ea; 
        color: black;
        width:200px;
        height: 50px;
        font-size:20px;
    }
    
    .toggle-vis-participant{
        cursor: pointer;
        color: #3174c7!important;
        text-decoration: none!important;
        font-size: smaller;
    }

    #bonDeCommande{
        width:auto;
        height: 50px;
        font-size:20px;
    }

    #bonDeCommande:hover{
        background-color: transparent; 
        color: #28a745;
        background-image: none;
        border-color: #28a745;
    }

    #bonDeCommande:focus{
        background-color: transparent; 
        color: #28a745;
        box-shadow: none;
    }

    .headerBC{
        margin-top: 10px;
        text-align: center;
    }

    .modal-footer button{
        font-size: large;
    }

    .sizeBC{
        font-size: 15px;
    }

</style>
<div class="header">Factures Participants</div>
<div class="loadingFacture">
	<img id="loadingFacture" src="<?php echo admin_url().'/images/wpspin_light-2x.gif';?>" style="display: block;">
</div>

<input type="hidden" id="columnParticipant" value="">
<input type="hidden" class="facture_type" value="participant">

<div class="facture_participant" style="margin-bottom: 20px; margin-top: 20px;">
    Afficher/Masquer colonne: 
    <a class="toggle-vis-participant" data-column="1">PERIODE</a> - 
    <a class="toggle-vis-participant" data-column="2">NUMÉRO</a> - 
    <a class="toggle-vis-participant" data-column="3">DATE_CREATION</a> - 
    <a class="toggle-vis-participant" data-column="4">DESTINATAIRE</a> - 
    <a class="toggle-vis-participant" data-column="5">INTITULÉ</a> -
    <a class="toggle-vis-participant" data-column="6">ANNÉE</a> -
    <a class="toggle-vis-participant" data-column="7">MontantHT</a> -
    <a class="toggle-vis-participant" data-column="8">Ak_TauxTVA</a> -
    <a class="toggle-vis-participant" data-column="9">MontantTVA</a> -
    <a class="toggle-vis-participant" data-column="10">MontantTTC</a> -
    <a class="toggle-vis-participant" data-column="11">MontantNet€</a> -
    <a class="toggle-vis-participant" data-column="12">TOTAL</a> -
    <a class="toggle-vis-participant" data-column="13">ACCOMPTE</a> -
    <a class="toggle-vis-participant" data-column="14">RESTEDÛ</a> -
    <a class="toggle-vis-participant" data-column="15">PAYÉ</a> -
    <a class="toggle-vis-participant" data-column="16">ENCAISSÉ</a> -
    <a class="toggle-vis-participant" data-column="17">Ak_DateReglement</a> -
    <a class="toggle-vis-participant" data-column="18">COMMENTAIRE</a> -
    <a class="toggle-vis-participant" data-column="19">CONCERNE</a>
</div>

<div class="facture_participant" style="margin-bottom: 10px;">
    <button type="submit" id="exportExcelParticipant" class="btn btn-light btn" onclick="exportDataExcel('columnParticipant', '', 'exportExcelParticipant')">
        <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export Excel
    </button>

    <button type="button" id="bonDeCommande" class="btn btn-outline-success btn" data-toggle="modal" data-target="#modalBonDeCommande">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Créer une facture à partir d'un bon de commande
    </button>
    
</div>

<table class="table table-striped table-bordered display nowrap facture_participant" id="factureParticipant">
    <thead>
        <tr> 
            <th></th>
            <th>PERIODE</th>
            <th>NUMÉRO</th>
            <th>DATE</th>
            <th>DESTINATAIRE</th>
            <th>INTITULÉ</th>
            <th>ANNÉE</th>
            <th>MontantHT</th>
            <th>Ak_TauxTVA</th>
            <th>MontantTVA</th>
            <th>MontantTTC</th>
            <th>MontantNet€</th>
            <th>TOTAL</th>
            <th>ACCOMPTE</th>
            <th>RESTEDÛ</th>
            <th>PAYÉ</th>
            <th>ENCAISSÉ</th>
            <th>Ak_DateReglement</th>
            <th>COMMENTAIRE</th>
            <th>CONCERNE</th>
        </tr>
    </thead>
    <tbody id="tableFactureParticipant">
        
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="modalBonDeCommande" data-backdrop="static" role="dialog" aria-labelledby="modalBC" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="modalBC">Création d'une facture à partir d'un bon de commande</h1>
            </div>
            <div class="modal-body">
                <form id="formBonDeCommande">
                	<div class="row">
	                	<div class="col-sm-12 alert alert-danger text-center errorBC" role="alert" style="display: none;">
	             
				        </div>

				        <div class="col-sm-12 alert alert-success text-center successBC" role="alert" style="display: none;">
				  
				        </div>

                        <div class="col-sm-12 alert alert-warning text-center infoBC" role="alert" style="display: none;">
                  
                        </div>
			        </div>
                	<div class="row">
                		<div class="col-sm-2">
					        <label for="bcLangue" class="col-form-label">Langue</label>
					        <select name="bcLangue" id="bcLangue" class="form-control" required style="max-width: none!important;">
			                    <option value="">Langue</option>
			                    <option value="fr">Français</option>
			                    <option value="en">Anglais</option>
			                </select>
					    </div>

					    <div class="col-sm-4">
                            <label class="col-form-label">Détail description</label>
                            <input type="text" name="detailDesc" class="form-control sizeBC" id="detailDesc">
                        </div>

                        <div class="col-sm-3">
                            <label class="col-form-label">Montant</label>
                            <input type="number" name="montant" class="form-control sizeBC" id="montant" required>
                        </div>

                        <div class="col-sm-3">
                            <label class="col-form-label">N° Bon de commande</label>
                            <input type="text" name="commande" class="form-control sizeBC" id="commande" required>
                        </div>

                	</div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="evenementList" class="col-form-label">Evenement</label>
                            <select name="evenement" id="evenementList" class="form-control sizeBC evenementList" required style="max-width: none!important; height: 37px;">
                                <option value=''>selectionner</option>
                            <?php 
                                foreach ($listEvents as $event) {
                                    $valEvent = $event["evenement"].",".$event["data"];
                                    echo "<option value='".$valEvent."'>".$event["evenement"]."</option>";
                                }
                            ?>   
                            </select>
                            <input type="hidden" name="specialiteEvent" id="specialiteEvent">
                        </div>
                        
                        <div class="col-sm-4">
                            <label class="col-form-label">Adresse</label>
                            <input type="text" name="adresseEvent" class="form-control sizeBC" id="adresseEvent" readonly="">
                        </div>

                        <div class="col-sm-2">
                            <label for="codepostalEvent" class="col-form-label">Code postal</label>
                            <input type="text" name="codepostalEvent" class="form-control sizeBC" id="codepostalEvent" readonly="">
                        </div>

                        <div class="col-sm-2">
                            <label for="villeEvent" class="col-form-label">Ville</label>
                            <input type="text" name="villeEvent" class="form-control sizeBC" id="villeEvent" readonly="">
                        </div>
                        
                        <div class="col-sm-2">
                            <label for="paysEvent" class="col-form-label">Pays</label>
                            <input type="text" name="paysEvent" class="form-control sizeBC" id="paysEvent" readonly="">
                        </div>

                        <div class="col-sm-2">
                            <label for="dateDebut" class="col-form-label">Date debut</label>
                            <input type="text" name="dateDebut" class="form-control sizeBC" id="dateDebut" readonly="">
                        </div>

                        <div class="col-sm-2">
                            <label for="dateFin" class="col-form-label">Date fin</label>
                            <input type="text" name="dateFin" class="form-control sizeBC" id="dateFin" readonly="">
                        </div>

                        <div class="col-sm-3">
                            <label for="contactNom" class="col-form-label">Personne à contacter</label>
                            <input type="text" name="contactNom" class="form-control sizeBC" id="contactNom" readonly="">
                        </div>

                        <div class="col-sm-3">
                            <label for="contactAdresse" class="col-form-label">Adresse Contact</label>
                            <input type="text" name="contactAdresse" class="form-control sizeBC" id="contactAdresse" readonly="">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="nom" class="col-form-label">Nom</label>
                            <input type="text" class="form-control sizeBC" id="nom" name="nom" required>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="prenom" class="col-form-label">Prenom</label>
                            <input type="text" class="form-control sizeBC" id="prenom" name="prenom" required>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="email" class="form-control sizeBC" id="email" name="email" required>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="telephone" class="col-form-label">Tel. Professionnel</label>
                            <input type="text" class="form-control sizeBC" id="telephone" name="telephone" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="adresse" class="col-form-label">Adresse</label>
                            <input type="text" class="form-control sizeBC" id="adresse" name="adresse" required>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="codepostal" class="col-form-label">Code Postal</label>
                            <input type="text" class="form-control sizeBC" id="codepostal" name="codepostal" required>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="ville" class="col-form-label">Ville</label>
                            <input type="text" class="form-control sizeBC" id="ville" name="ville" required>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="pays" class="col-form-label">Pays</label>
                            <input type="text" class="form-control sizeBC" id="pays" name="pays" required>
                        </div>
                    </div>
                    <div class="modal-footer">
		                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">
		                    <span class="glyphicon glyphicon-remove"></span> Fermer
		                </button>

		                <button type="submit" class="btn btn-primary btn-lg" id="btnBC">
		                <span class="glyphicon glyphicon-ok"></span> Enregistrer
		                </button>
		            </div>
                </form>
            </div>
            
        </div>
    </div>
</div>


