<?php

?>
<style type="text/css">
    td.details-control{
         color:green;
         cursor: pointer;
    }

    tr.shown td.details-control{
        color:red;
        cursor: pointer;
    }

    .listEvent{
        text-align: center;
        margin-bottom: 60px;
    }

    .loadingEvents{
    	text-align: -webkit-center;
    }

    .header{
        text-align: center;
        font-size: 50px;
        font-weight: 700;
    }
</style>

<div class="header"> Liste des congrès</div>

<div class="loadingEvents">
	<img id="loadingEvents" src="<?php echo admin_url().'/images/wpspin_light-2x.gif';?>" style="display: block;">
</div>

<table class="table table-striped table-bordered" id="list_events" style="display: none;">
    <thead>
        <tr>
            <th></th>
            <th>Organisateur</th>
            <th>Titre</th>
            <th>Spécialité</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Pays</th>
            <th>Date evenement</th>
        </tr>
    </thead>
    <tbody id="bodyEvent">
        
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th>Organisateur</th>
            <th>Titre</th>
            <th>Spécialité</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Pays</th>
            <th>Date evenement</th>
        </tr>
    </tfoot>
</table>