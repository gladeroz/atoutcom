<?php

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

<div class="row facture_participant" style="margin-bottom: 10px;">
    <div class="col-sm-3">
        <button type="submit" id="exportExcelParticipant" class="btn btn-light btn-lg" onclick="exportDataExcel('columnParticipant', '', 'exportExcelParticipant')">
            <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export Excel
        </button>
    </div>
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


