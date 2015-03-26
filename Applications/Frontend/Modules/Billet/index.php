<!-- Portion de Vue spécifique à l'affichage des commentaires d'un Billet du  Forum -->

<?php $this->_titre = "Forum AtelierBlancNordOuest- ".$this->nettoyer($billet['titre']);?>
<section class="col-sm-12">
    <div class="row">
        <article class="col-sm-12">
            <div class="row">
                <div class="col-sm-3 col-xs-5"><a href="<?="topic/index".$this->nettoyer($billet['idTopic'])?>"><h4><?=$this->nettoyer($topic)?></h4></a></div>
                <div class="col-sm-8 col-xs-6"><h5><?= "Discussion: " .$this->nettoyer($billet['titre'])?></h5></div>
                <div class="col-xs-1">
                    <div class="row">
                        <div class="col-sm-12 col-xs-6"><h6><?= $this->nettoyer($billet['nbVu'])?> <span class="glyphicon glyphicon-eye-open"></span></h6></div>
                        <div class="col-sm-12 col-xs-6"><h6><?= $this->nettoyer($billet['nbComents'])?> <span class="glyphicon glyphicon-comment"></span></h6></div>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <div class="row">
        <article class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($billet['date']->getTimestamp()))?></time>
                    <?php if ($billet['dateModif']>$billet['date']):?>
                    <time><?="modifié le ".strftime('%A %d %B %Y, %H:%M',$this->nettoyer($billet['dateModif']->getTimestamp()))?></time>
                    <?php endif;?>
                </div>
                <div class="col-sm-2">
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-6">A</div>
                        <div class="col-md-10 col-sm-12 col-xs-6"><?= $this->nettoyer($billet['auteur'])?></div>
                        <div class="col-xs-6"><h6><?= $this->nettoyer($nbUserBillets)?> <span class="glyphicon glyphicon-envelope"></span></h6></div>
                        <div class="col-xs-6"><h6><?= $this->nettoyer($nbUserComents)?> <span class="glyphicon glyphicon-comment"></span></h6></div>
                    </div>
                </div>
                <div class="col-sm-10"><p class="complet"><?= $this->nettoyer($billet['contenu'])?></p></div>
            </div>
      </article>
    </div>

    <!-- Affichage des commentaires du Billet -->
   <?php foreach ($commentaires as $commentaire):?>
   <div class="row">
       <article class="col-sm-12">
           <div class="row">
               <div class="col-sm-12">
                   <time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($commentaire['date']->getTimestamp()))?></time>
                   <?php if ($commentaire['dateModif']>$commentaire['date']):?>
                   <time><?="modifié le ".strftime('%A %d %B %Y, %H:%M',$this->nettoyer($commentaire['dateModif']->getTimestamp()))?></time>
                   <?php endif;?>
               </div>
               <div class="col-sm-2">
                   <div class="row">
                       <div class="col-md-2 col-sm-12 col-xs-4">A</div>
                       <div class="col-md-10 col-sm-12 col-xs-8"><?= $this->nettoyer($commentaire['auteur'])?></div>
                       <!-- il faut récupérer ici les données sur l'objet -->
                       <div class="col-xs-6"><h6><?= $this->nettoyer($commentaire->nbUserBillets)?> <span class="glyphicon glyphicon-envelope"></span></h6></div>
                       <div class="col-xs-6"><h6><?= $this->nettoyer($commentaire->nbUserComents)?> <span class="glyphicon glyphicon-comment"></span></h6></div>
                   </div>
               </div>
               <div class="col-sm-10">
                   <div class="row">
                       <div class="col-xs-12"><p class="complet"><?= $this->nettoyer($commentaire['contenu'])?></p></div>
                       <div class="col-xs-4"><a href="<?= "billet/citer/". $this->nettoyer($commentaire['id'])?>">Répondre avec citation</a></div>
                       <?php if ($commentaire['auteur']==$pseudo):?>
                           <div class="col-xs-4"><a href="<?= "billet/supprimer/". $this->nettoyer($commentaire['id'])?>">Supprimer</a></div>
                           <div class="col-xs-4"><a href="<?= "billet/modifier/". $this->nettoyer($commentaire['id'])?>">Modifier</a></div>
                       <?php endif;?>
                   </div>
               </div>
          </div>
       </article>
   </div>
   <?php endforeach;?>
</section>

<section class="col-sm-12">
    <!-- Formulaire de création de commentaire -->
    <div class="row">
       <div class="well"><?= $this->nettoyer($formulaire)?></div>
    </div>
</section>