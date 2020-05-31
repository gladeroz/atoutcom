<?php
    $listEvents = atoutcomUser::formsEvents("listeEventsForSponsors", "");
?>

<style type="text/css">
	.btn-lg{
		width:400px;
		height: 50px;
		font-size:20px;
	}

	.header{
        text-align: center;
        font-size: 50px;
        font-weight: 700;
	}

	.headerBtn{
		text-align: center; 
		margin-top: 50px;
		margin-bottom: 50px;
	}

	.createSponsor, .showSponsor{
        display: none;
	}

	input.form-control, #evenementList, #sponsorLangue, #evenementSpecialite, #participation{
		font-size: 20px!important;
		height: 50px!important;
	}
    
    #exportExcelSponsor{
    	width: 150px; 
    	background-color: #e2e6ea; 
    	color: black;
    }
	.labelSponsor{
		font-size: 20px;
	}

	.btn.focus, .btn:focus{
		outline: none;
		box-shadow: none;
	}

	.btn-outline-primary:focus{
		box-shadow: none;
	}

	.loadingFactureSponsor{
    	text-align: -webkit-center;
    }

    .facture_sponsor{
    	display: none;
    }

    #manage_factureSponsor{
    	width: max-content!important;
    }
    
    .toggle-vis-sponsor{
    	cursor: pointer;
        color: #3174c7!important;
        text-decoration: none!important;
        font-size: smaller;
    }
    
</style>

<div class="header"> Que voulez vous faire ?</div>


<div class="container headerBtn">
    
	<button type="button" id="createSponsor" class="btn btn-outline-success btn-lg">
	    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Créer un sponsor
	</button>

	<button type="button" id="showSponsor" class="btn btn-outline-primary btn-lg">
	    <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Afficher les sponsors
	</button>

</div>


<div class="loadingFactureSponsor">
    <img id="loadingFactureSponsor" src="<?php echo admin_url().'/images/wpspin_light-2x.gif';?>" style="display: none;">
</div>

<input type="hidden" id="isLoadCreate" value="">
<input type="hidden" id="isLoadShow" value="">
<input type="hidden" id="columnSponsor" value="">
<input type="hidden" class="facture_type" value="sponsor">

<div class="createSponsor">
	<div class="container">
		<div class="col-sm-12 alert alert-danger text-center errorSponsor" role="alert" style="display: none;">
             
        </div>

        <div class="col-sm-12 alert alert-success text-center successSponsor" role="alert" style="display: none;">
  
        </div>

		<form id="target-createSponsor">
			
            <div class="row">
            	<div class="col-sm-4">
			        <label for="sponsorLangue" class="col-form-label-lg labelSponsor">Langue</label>
			        <select name="sponsorLangue" id="sponsorLangue" class="form-control form-control-lg" required style="max-width: none!important;">
	                    <option value="">Choisir une langue</option>
	                    <option value="fr">Français</option>
	                    <option value="en">Anglais</option>
	                </select>
			    </div>

			    <div class="col-sm-8">
			        <label for="detailDesc" class="col-form-label-lg labelSponsor">Détail description</label>
			        <input type="text" name="detailDesc" class="form-control form-control-lg" id="detailDesc" required>
			    </div>
            </div>
            <br><br>

			<div class="row">

				<div class="col-sm-6">
			        <label for="evenementList" class="col-form-label-lg labelSponsor">Evenement</label>
			        <select name="evenement" id="evenementList" class="form-control form-control-lg" required style="max-width: none!important;">
	                    <option value=''>selectionner</option>
	                <?php 
                        foreach ($listEvents as $event) {
					    	$valEvent = $event["evenement"].",".$event["data"];
					    	echo "<option value='".$valEvent."'>".$event["evenement"]."</option>";
					    }
	                ?>   
	                </select>
			    </div>

			    <div class="col-sm-2">
			        <label for="dateDebut" class="col-form-label-lg labelSponsor">Date debut</label>
			        <input type="text" name="dateDebut" class="form-control form-control-lg" id="dateDebut" readonly="">
			    </div>

			    <div class="col-sm-2">
			        <label for="dateFin" class="col-form-label-lg labelSponsor">Date fin</label>
			        <input type="text" name="dateFin" class="form-control form-control-lg" id="dateFin" readonly="">
			    </div>

				<div class="col-sm-2">
			        <label for="codepostalEvent" class="col-form-label-lg labelSponsor">Code postal</label>
			        <input type="text" name="codepostalEvent" class="form-control form-control-lg" id="codepostalEvent" readonly="">
			    </div>

			    <div class="col-sm-6">
			        <label for="adresseEvent" class="col-form-label-lg labelSponsor">Adresse</label>
			        <input type="text" name="adresseEvent" class="form-control form-control-lg" id="adresseEvent" readonly="">
			    </div>

			    <div class="col-sm-3">
			        <label for="villeEvent" class="col-form-label-lg labelSponsor">Ville</label>
			        <input type="text" name="villeEvent" class="form-control form-control-lg" id="villeEvent" readonly="">
			    </div>

			    <div class="col-sm-3">
			        <label for="paysEvent" class="col-form-label-lg labelSponsor">Pays</label>
			        <input type="text" name="paysEvent" class="form-control form-control-lg" id="paysEvent" readonly="">
			    </div>

			</div>
            <br><br>

			<div class="row">
			    
			    <div class="col-sm-4">
			        <label for="sponsor" class="col-form-label-lg labelSponsor">Sponsor</label>
			        <input type="text" name="sponsor" class="form-control form-control-lg inputSponsor" id="sponsor" placeholder="Sponsor" required>
			    </div>

                <div class="col-sm-4">
			        <label for="evenementSpecialite" class="col-form-label-lg labelSponsor">Specialité</label>
			        <select name="specialite" id="evenementSpecialite" class="form-control form-control-lg" required style="max-width: none!important;">
	                    <option value="">Choisir une spécialité</option>
	                    <option value="Cardiologie">Cardiologie</option>		
						<option value="Esthétique">Esthétique</option>
						<option value="Gynécologie">Gynécologie</option>
						<option value="Oncologie">Oncologie</option>
						<option value="Paramédical">Paramédical</option>
						<option value="Pédiatrie">Pédiatrie</option>
						<option value="Scientifiques">Scientifiques</option>
						<option value="Ventilation">Ventilation</option>
	                </select>
			    </div>

			    <div class="col-sm-4">
			        <label for="participation" class="col-form-label-lg labelSponsor">Participation</label>
			        <input type="number" name="participation" class="form-control form-control-lg" id="participation" placeholder="Participation" required>
			    </div>

			    <div class="col-sm-3">
			        <label for="adresseFact" class="col-form-label-lg labelSponsor">Adresse de facturation</label>
			        <input type="text" name="adresseFact" class="form-control form-control-lg" id="adresseFact" required>
			    </div>

			    <div class="col-sm-3">
			        <label for="emailContact" class="col-form-label-lg labelSponsor">Email de contact</label>
			        <input type="text" name="emailContact" class="form-control form-control-lg" id="emailContact" required>
			    </div>

			    <div class="col-sm-2">
			        <label for="codepostalFact" class="col-form-label-lg labelSponsor">Code postal</label>
			        <input type="text" name="codepostalFact" class="form-control form-control-lg" id="codepostalFact" required>
			    </div>

			    <div class="col-sm-2">
			        <label for="villeFact" class="col-form-label-lg labelSponsor">Ville</label>
			        <input type="text" name="villeFact" class="form-control form-control-lg" id="villeFact" required>
			    </div>

			    <div class="col-sm-2">
			        <label for="paysFact" class="col-form-label-lg labelSponsor">Pays</label>
			        <input type="text" name="paysFact" class="form-control form-control-lg" id="paysFact" required>
			    </div>

			</div>
            <br><br>

			<div class="row" style="margin-top: 15px;">
				<div class="col-sm-3">
					<button type="submit" id="enregistrerSponsor" class="btn btn-success btn-lg" style="width: 150px;">
					    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Enregistrer
					</button>
				</div>
			</div>
	    </form>
    </div>
</div>

<div class="showSponsor">
	<div class="facture_sponsor" style="margin-bottom: 15px">
		Afficher/Masquer colonne: 
		<a class="toggle-vis-sponsor" data-column="1">PERIODE</a> - 
		<a class="toggle-vis-sponsor" data-column="2">NUMÉRO</a> - 
		<a class="toggle-vis-sponsor" data-column="3">DATE_CREATION</a> - 
		<a class="toggle-vis-sponsor" data-column="4">DESTINATAIRE</a> - 
		<a class="toggle-vis-sponsor" data-column="5">INTITULÉ</a> -
		<a class="toggle-vis-sponsor" data-column="6">SPECIALITÉ</a> -
		<a class="toggle-vis-sponsor" data-column="7">ANNÉE</a> -
		<a class="toggle-vis-sponsor" data-column="8">MontantHT</a> -
		<a class="toggle-vis-sponsor" data-column="9">Ak_TauxTVA</a> -
		<a class="toggle-vis-sponsor" data-column="10">MontantTVA</a> -
		<a class="toggle-vis-sponsor" data-column="11">MontantTTC</a> -
		<a class="toggle-vis-sponsor" data-column="12">MontantNet€</a> -
		<a class="toggle-vis-sponsor" data-column="13">TOTAL</a> -
		<a class="toggle-vis-sponsor" data-column="14">ACCOMPTE</a> -
		<a class="toggle-vis-sponsor" data-column="15">RESTEDÛ</a> -
		<a class="toggle-vis-sponsor" data-column="16">PAYÉ</a> -
		<a class="toggle-vis-sponsor" data-column="17">ENCAISSÉ</a> -
		<a class="toggle-vis-sponsor" data-column="18">Ak_DateReglement</a> -
		<a class="toggle-vis-sponsor" data-column="19">COMMENTAIRE</a> -
		<a class="toggle-vis-sponsor" data-column="20">CONCERNE</a>
	</div>

    <div class="row facture_sponsor" style="margin-bottom: 10px;">
		<div class="col-sm-3">
			<button type="submit" id="exportExcelSponsor" class="btn btn-light btn-lg" onclick="exportDataExcel('columnSponsor', '', 'exportExcelSponsor')">
			    <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export Excel
			</button>
		</div>
	</div>

	<table class="table table-striped table-bordered facture_sponsor" id="manage_factureSponsor">
	    <thead>
	        <tr>
	            <th></th>
	            <th>PERIODE</th>
	            <th>NUMÉRO</th>
	            <th>DATE_CREATION</th>
	            <th>DESTINATAIRE</th>
	            <th>INTITULÉ</th>
	            <th>SPECIALITÉ</th>
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
	    <tbody id="bodyFactureSponsor">
	        
	    </tbody>
	</table>
</div>
