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

    .creerIntervenant, .afficherIntervenant{
        display: none;
    }

    .inputIntervenant{
        font-size: 20px;
        height: 50px;
    }
    .alignement{
        margin-bottom: 30px;
    }
    .labelIntervenant{
        font-size: x-large;
    }

    .btn.focus, .btn:focus{
        outline: none;
        box-shadow: none;
    }

    .btn-outline-primary:focus{
        box-shadow: none;
    }

    .loadingIntervenant{
        text-align: -webkit-center;
    }

</style>

<div class="header"> Intervenants</div>

<div class="container headerBtn">
    
    <button type="button" id="creerIntervenant" class="btn btn-outline-success btn-lg">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Créer un intervenant
    </button>

    <button type="button" id="afficherIntervenant" class="btn btn-outline-primary btn-lg">
        <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Afficher les intervenants
    </button>

</div>

<input type="hidden" class="facture_type" value="intervenant">

<div class="creerIntervenant">
    <div class="container">
        <div class="col-sm-12 alert alert-success text-center success" role="alert" style="display: none;">
            
        </div>

        <div class="col-sm-12 alert alert-danger text-center erreur" role="alert" style="display: none;">
            
        </div>

        <form id="target-creerIntervenant">
            <div class="row">
                <div class="col-sm-6">
                    <label for="evenementList" class="col-form-label-lg labelIntervenant">Evenement</label>
                    <select name="evenement" id="evenementList" class="form-control form-control-lg" required style="height: 50px; font-size: 20px; max-width: none!important;">
                        <option value=''>selectionner</option>
                    <?php 
                        foreach ($listEvents as $event) {
                            $valEvent = $event["evenement"].",".$event["data"];
                            echo "<option value='".$valEvent."'>".$event["evenement"]."</option>";
                        }
                    ?>   
                    </select>
                </div>
                
                <div class="col-sm-6 alignement">
                    <label for="dateEvenement" class="col-form-label-lg labelIntervenant">Date</label>
                    <input type="text" name="dateEvenement" id="dateEvenement" class="form-control form-control-lg inputIntervenant" readonly="">
                </div>

                <div class="col-sm-3 alignement">
                    <label for="nom" class="col-form-label-lg labelIntervenant">Nom</label>
                    <input type="text" name="nom" class="form-control form-control-lg inputIntervenant" placeholder="Nom" required>
                </div>

                <div class="col-sm-3 alignement">
                    <label for="participation" class="col-form-label-lg labelIntervenant">Prénom</label>
                    <input type="text" name="prenom" class="form-control form-control-lg inputIntervenant" placeholder="Prénom" required>
                </div>

                <div class="col-sm-3 alignement">
                    <label for="email" class="col-form-label-lg labelIntervenant">E-mail</label>
                    <input type="text" name="email" class="form-control form-control-lg inputIntervenant" placeholder="E-mail" required>
                </div>

                <div class="col-sm-3 alignement">
                    <label for="telephone" class="col-form-label-lg labelIntervenant">Téléphone</label>
                    <input type="text" name="telephone" class="form-control form-control-lg inputIntervenant"  placeholder="Téléphone" required>
                </div>

                <div class="col-sm-3 alignement">
                    <label for="adresse" class="col-form-label-lg labelIntervenant">Adresse</label>
                    <input type="text" name="adresse" class="form-control form-control-lg inputIntervenant" placeholder="Adresse">
                </div>

                <div class="col-sm-3 alignement">
                    <label for="codePostal" class="col-form-label-lg labelIntervenant">Code Postal</label>
                    <input type="text" name="codePostal" class="form-control form-control-lg inputIntervenant" placeholder="Code Postal">
                </div>
                
                <div class="col-sm-3 alignement">
                    <label for="ville" class="col-form-label-lg labelIntervenant">Ville</label>
                    <input type="text" name="ville" class="form-control form-control-lg inputIntervenant" placeholder="Ville">
                </div>

                <div class="col-sm-3 alignement">
                    <label for="pays" class="col-form-label-lg labelIntervenant">Pays</label>
                    <input type="text" name="pays" class="form-control form-control-lg inputIntervenant" placeholder="Pays">
                </div>
            </div>

            <div class="loadingIntervenant">
                <img id="loadingIntervenant" src="<?php echo admin_url().'/images/wpspin_light-2x.gif';?>" style="display: none;">
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-3">
                    <button type="submit" id="enregistrerIntervenant" class="btn btn-success btn-lg" style="width: 250px;">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="afficherIntervenant">

    <div class="row exportIntervenant" style="margin-bottom: 10px;">
        <div class="col-sm-3">
            <button type="submit" id="exportExcel" class="btn btn-light btn-lg" style="width: 200px; background-color: #e2e6ea; color: black;">
                <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export Excel
            </button>
        </div>
    </div>

    <table class="table exportIntervenant" id="tableIntervenant">
        <thead>
            <tr>
                <th></th>
                <th>EVENEMENT</th>
                <th>DATE</th>
                <th>NOM</th>
                <th>PRENOM</th>
                <th>EMAIL</th>
                <th>TELEPHONE</th>
                <th>ADRESSE</th>
                <th>CODE POSTAL</th>
                <th>VILLE</th>
                <th>PAYS</th>
            </tr>
        </thead>
        <tbody id="bodyTableIntervenant">
            
        </tbody>
    </table>
</div>

