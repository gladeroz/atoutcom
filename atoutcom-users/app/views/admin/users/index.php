<?php
    /*wp_register_style('login_css', mvc_css_url('atoutcom-users', 'login'));
    wp_enqueue_style('login_css');
    var_dump(strpos($_GET["page"], "mvc_events"));*/
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

    #manage_users{
        text-align: center;
    }

    .loadingUsers{
        text-align: -webkit-center;
    }
</style>
<div class="header">Liste des utilisateurs</div>
<input type="hidden" id="userFile" value="">

<div class="loadingUsers">
    <img id="loadingUsers" src="<?php echo admin_url().'/images/wpspin_light-2x.gif';?>" style="display: block;">
</div>

<table class="table table-striped table-bordered" id="manage_users" style="display: none; width: 100%;">
    <thead>
        <tr>
            <th></th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Pays</th>
            <th>Tel. Professionnel</th>
            <th>Date inscription</th>
            <th>Profil</th>
            <th style="display: none;">UserFile</th>
        </tr>
    </thead>
    <tbody id="bodyUser">
        
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Pays</th>
            <th>Tel. Professionnel</th>
            <th>Date inscription</th>
            <th>Profil</th>
            <th style="display: none;">UserFile</th>
        </tr>
    </tfoot>
</table>
