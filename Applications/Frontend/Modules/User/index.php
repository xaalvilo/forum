<!-- Portion de Vue spécifique à l'affichage des paramètres d'un membre  -->

<?php $this->_titre = "Forum AtelierBlancNordOuest - compte de ".$this->nettoyer($user['_pseudo']);?>
<section class="col-sm-12">
    <div class="row">
        <article class="col-sm-12">
            <div class="row">
                <div class="col-sm-8 col-xs-6"><h5>Pseudo : <?=$this->nettoyer($user['_pseudo'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Nom : <?=$this->nettoyer($user['_nom'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Prénom : <?=$this->nettoyer($user['_prenom'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Année de naissance : <?=$this->nettoyer($user['_naissance'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Pays : <?=$this->nettoyer($user['_pays'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Téléphone : <?=$this->nettoyer($user['_telephone'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Email : <?=$this->nettoyer($user['_mail'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Fichier Avatar : <?=$this->nettoyer($user['_avatar'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Date inscription :</h5><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($user['_dateInscription']->getTimestamp()))?></time></div>
                <div class="col-sm-8 col-xs-6"><h5>Date connexion :</h5><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($user['_dateConnexion']->getTimestamp()))?></time></div>
                <div class="col-sm-8 col-xs-6"><h5>Date connexion précédente :</h5><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($user['_dateLastConnexion']->getTimestamp()))?></time></div>
                <div class="col-sm-8 col-xs-6"><h5>Nombre commentaires Blog :<?=$this->nettoyer($user['_nbreCommentairesBlog'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Nombre billets sur le forum :<?=$this->nettoyer($user['_nbreBilletsForum'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Nombre de messages Forum :<?=$this->nettoyer($user['_nbreCommentairesForum'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Statut : <?=$this->nettoyer($user['_statut'])?></h5></div>
                <div class="col-sm-8 col-xs-6"><h5>Adresse IP :<?=$this->nettoyer($user['_ip'])?></h5></div>
             <div class="col-xs-1">
                    <div class="row">
                        <div class="row">
                          <div class="col-xs-6"><a href="<?= "membres/bannir/" .$this->nettoyer($user['id'])?>">Bannir</a></div>
                          <div class="col-xs-6"><a href="<?= "membres/modifier/" .$this->nettoyer($user['id'])?>">Modifier</a></div>
                          <div class="col-xs-6"><a href="<?= "membres/contacter/" .$this->nettoyer($user['id'])?>">Contacter</a></div>
                      </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

<section class="col-sm-12">
    <!-- Formulaire d'envoi d'email -->
    <div class="row">
       <div class="well"><?= $this->nettoyer($formulaire)?></div>
    </div>
</section>