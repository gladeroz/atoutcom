<?php

?>
<style type="text/css">
    td.details-control{
         color:green;
         cursor: pointer;
         width: 30px;
    }

    tr.shown td.details-control{
        color:red;
        cursor: pointer;
        width: 30px;
    }
    
    #exportExcelListeParticipant{
        background-color: #e2e6ea; 
        color: black;
        width:200px;
        height: 50px;
        font-size:20px;
    }

    .listParticipant{
    	text-align: center;
    	margin-bottom: 60px;
    }

    .loadingParticipant{
        text-align: -webkit-center;
    }

    .header{
        text-align: center;
        font-size: 50px;
        font-weight: 700;
    }

    .list_participant{
        display: none;
    }
</style>

<div class="header">Liste des participants</div>

<div class="loadingParticipant">
    <img id="loadingParticipant" src="<?php echo admin_url().'/images/wpspin_light-2x.gif';?>" style="display: block;">
</div>

<input type="hidden" class="facture_type" value="Liste_Participant">

<div class="row list_participant" style="margin-bottom: 10px;">
    <div class="col-sm-3">
        <button type="submit" id="exportExcelListeParticipant" class="btn btn-light btn-lg">
            <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export Excel
        </button>
    </div>
</div>

<table class="table list_participant" id="tableParticipant" style="width: 100%;">
    <thead>
        <tr>
            <th></th>
            <th>Evenement</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Telephone Professionnel</th>
            <th>Transaction ID</th>
            <th>Statut Paiement</th>
            <th style="display: none;">Entry ID</th>
            <th style="display: none;">Form ID</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody id="bodyUserEvent">
        
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th>Evenement</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Telephone Professionnel</th>
            <th>Transaction ID</th>
            <th>Statut Paiement</th>
            <th style="display: none;">Entry ID</th>
            <th style="display: none;">Form ID</th>
            <th>Statut</th>
        </tr>
    </tfoot>
</table>