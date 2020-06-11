<?php

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
   
    #exportExcelGlobal{
        width: 200px; 
        background-color: #e2e6ea; 
        color: black;
    }
	.btn.focus, .btn:focus{
		outline: none;
		box-shadow: none;
	}

	.btn-outline-primary:focus{
		box-shadow: none;
	}

	.loadingFactureGlobale{
    	text-align: -webkit-center;
    }

    .facture_globale{
    	display: none;
    }

    #manage_factureGloable{
        width: max-content!important;
    }
    
    .toggle-vis-global{
        cursor: pointer;
        color: #3174c7!important;
        text-decoration: none!important;
        font-size: smaller;
    }
</style>

<div class="header"> Facturier Global</div>

<div class="loadingFactureGlobale">
    <img id="loadingFactureGlobale" src="<?php echo admin_url().'/images/wpspin_light-2x.gif';?>">
</div>

<input type="hidden" class="facture_type" value="global">
<input type="hidden" id="columnGlobal" value="">

<div class="facture_globale" style="margin-bottom: 20px; margin-top: 25px;">
    Afficher/Masquer colonne: 
    <a class="toggle-vis-global" data-column="1">PERIODE</a> - 
    <a class="toggle-vis-global" data-column="2">NUMÉRO</a> - 
    <a class="toggle-vis-global" data-column="3">DATE_CREATION</a> - 
    <a class="toggle-vis-global" data-column="4">DESTINATAIRE</a> - 
    <a class="toggle-vis-global" data-column="5">INTITULÉ</a> -
    <a class="toggle-vis-global" data-column="6">ANNÉE</a> -
    <a class="toggle-vis-global" data-column="7">MontantHT</a> -
    <a class="toggle-vis-global" data-column="8">Ak_TauxTVA</a> -
    <a class="toggle-vis-global" data-column="9">MontantTVA</a> -
    <a class="toggle-vis-global" data-column="10">MontantTTC</a> -
    <a class="toggle-vis-global" data-column="11">MontantNet€</a> -
    <a class="toggle-vis-global" data-column="12">TOTAL</a> -
    <a class="toggle-vis-global" data-column="13">ACCOMPTE</a> -
    <a class="toggle-vis-global" data-column="14">RESTEDÛ</a> -
    <a class="toggle-vis-global" data-column="15">PAYÉ</a> -
    <a class="toggle-vis-global" data-column="16">ENCAISSÉ</a> -
    <a class="toggle-vis-global" data-column="17">Ak_DateReglement</a> -
    <a class="toggle-vis-global" data-column="18">COMMENTAIRE</a> -
    <a class="toggle-vis-global" data-column="19">CONCERNE</a>
</div>
<div class="row facture_globale" style="margin-bottom: 10px;">
	<div class="col-sm-3">
		<button type="submit" id="exportExcelGlobal" class="btn btn-light btn-lg" onclick="exportDataExcel('columnGlobal', '', 'exportExcelGlobal')">
		    <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export Excel
		</button>
	</div>
</div>

<table class="table table-striped table-bordered facture_globale" id="manage_factureGloable">
    <thead>
        <tr>
            <th></th>
            <th>PERIODE</th>
            <th>NUMÉRO</th>
            <th>DATE_CREATION</th>
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
    <tbody id="bodyFactureGlobale">
        
    </tbody>
</table>

