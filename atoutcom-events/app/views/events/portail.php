<?php
    //session_start();
    $userInfo = atoutcomUser::dataUser();
    $idUser = $userInfo->id;
    $nom = $userInfo->nom;
    $prenom = $userInfo->prenom;
    $email = $userInfo->email;
    $adresse = $userInfo->adresse;
    $ville = $userInfo->ville;
    $codePostal = $userInfo->codepostal;
    $telephone = $userInfo->telephone;
    $dateInscription = $userInfo->dateinscription;
    $prospection = $userInfo->prospection;
?>
<div class="col-sm-12 col-xs-12">
  <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-left: 0px;">
    <li class="nav-item" style="list-style-type: none;">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Mes informations</a>
    </li>
    <li class="nav-item" style="list-style-type: none;">
      <a class="nav-link" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="events" aria-selected="false">Mes évenements</a>
    </li>
    <li class="nav-item" style="list-style-type: none;">
      <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false">Mes documents</a>
    </li>
  </ul>
</div>

<div class="tab-content col-sm-12 col-xs-12" style="margin-bottom: 30px;">
  <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
            Preom :
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
            Telephone :
          </div>
          <div class="col-sm-10">
            <input type="text" name="telephone" id="telephone" value="<?=$telephone?>">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">
            Date :
          </div>
          <div class="col-sm-4">
            <input type="text" name="dateinscription" id="dateinscription" value="<?=$dateInscription?>" title="Ce champ est en lecture seule" readonly>
          </div>

          <div class="col-sm-2">
            Prospection :
          </div>
          <div class="col-sm-4">
            <input type="text" name="prospection" id="prospection" value="<?=$prospection?>" title="Ce champ est en lecture seule" readonly>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-10">
            <input class="btn btn-primary" type="submit" id="submit-update" value="Mettre à jour">
            <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: none;">
          </div>
        </div>

      </div>
    </form>
  </div>

  <div class="tab-pane" id="events" role="tabpanel" aria-labelledby="events-tab">
    halla
  </div>

  <div class="tab-pane" id="documents" role="tabpanel" aria-labelledby="documents-tab">
    Tala
  </div>
  <!--
  <div class="tab-pane" id="account" role="tabpanel" aria-labelledby="account-tab">
    <div class="row">
      <div class="nav flex-column nav-pills col-sm-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Mes informations</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Mes évenements</a>
        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Documents recents</a>
        <a class="nav-link" id="v-pills-disconnect-tab" data-toggle="pill" href="#v-pills-disconnect" role="tab" aria-controls="v-pills-disconnect" aria-selected="false">Deconnexion</a>
      </div>-
      
      <div class="tab-content col-sm-10" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
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
                  Preom :
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
                  Telephone :
                </div>
                <div class="col-sm-10">
                  <input type="text" name="telephone" id="telephone" value="<?=$telephone?>">
                </div>
              </div>

              <div class="row">
                <div class="col-sm-2">
                  Date :
                </div>
                <div class="col-sm-4">
                  <input type="text" name="dateinscription" id="dateinscription" value="<?=$dateInscription?>" title="Ce champ est en lecture seule" readonly>
                </div>

                <div class="col-sm-2">
                  Prospection :
                </div>
                <div class="col-sm-4">
                  <input type="text" name="prospection" id="prospection" value="<?=$prospection?>" title="Ce champ est en lecture seule" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-10">
                  <input class="btn btn-primary" type="submit" id="submit-update" value="Mettre à jour">
                  <img id="loading" src="<?php echo admin_url().'/images/loading.gif';?>" style="display: none;">
                </div>
              </div>

            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          Evenements
        </div>
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
          Documents
        </div>
      </div>
    </div>
  </div>
</div>-->