<!-- Portion de Vue spécifique à l'affichage de la liste des membres du site -->
<?php $this->_titre = "Membres AtelierBlancNordOuest"; ?>
<section class="col-sm-12"><h1>Gestion des membres</h1>

<?php foreach ($users as $user):?>
      <div class="row">
          <article class="col-sm-12">
              <div class="row">
                  <div class="col-sm-7">
                      <div class="row">
                          <div class="col-xs-1"><p>A</p></div>
                          <div class="col-xs-3"><a href="<?="user/index/".$this->nettoyer($user['id'])?>"><?= $this->nettoyer($user->pseudo())?></a></div>
                          <div class="col-xs-4"><h6> inscrit le <time><?=strftime('%A %d %B %Y, %H:%M',$this->nettoyer($user->dateInscription()->getTimestamp()))?></time></h6></div>
                          <div class="col-xs-4"><h6> connecté le <time><?=strftime('%A %d %B %Y, %H:%M',$this->nettoyer($user->dateConnexion()->getTimestamp()))?></time></h6></div>
                      </div>
                  </div>
                  <div class="col-sm-5">
                      <div class="row">
                          <div class="col-xs-4"><h6>Blog <?=$this->nettoyer($user->nbreCommentairesBlog())?> <span class="glyphicon glyphicon-comment"></span></h6></div>
                          <div class="col-xs-4"><h6>Forum <?=$this->nettoyer($user->nbreCommentairesForum())?> <span class="glyphicon glyphicon-comment"></span></h6></div>
                          <div class="col-xs-4"><h6>Forum <?=$this->nettoyer($user->nbreBilletsForum())?> <span class="glyphicon glyphicon-envelope"></span></h6></div>
                      </div>
                  </div>
              </div>
           </article>
     </div>
<?php endforeach; ?>
</section>



