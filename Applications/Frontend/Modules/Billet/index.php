<!-- Portion de Vue spécifique à l'affichage des commentaires d'un Billet du  Forum -->

<?php $this->_titre = "Forum AtelierBlancNordOuest- ".$this->nettoyer($billet['titre']);?>
<section class="col-sm-12">
    <article class="row">
        <div class="col-sm-12"><h4><?=$this->nettoyer($billet['topic']) ?></h4></div>
    </article>
    <article class="row">
        <div class="col-sm-3">
            <div class="row">
                <div class="col-md-2 col-sm-12 col-xs-6">A</div>
                <div class="col-md-10 col-sm-12 col-xs-6"><?= $this->nettoyer($billet['auteur'])?></div>
                <div class="col-xs-12"><h6 class="badge"><?= $this->nettoyer($billet['nbComents'])?> réponses</h6></div>
             </div>
         </div>
         <div class="col-sm-9">
             <div class="row">
                 <div class="col-sm-4 col-xs-6"><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($billet['date']->getTimestamp()))  ?></time></div>
                 <div class="col-sm-8 col-xs-6"><?= $this->nettoyer($billet['titre'])?></div>
                 <div class="col-xs-12"><p class="complet"><?= $this->nettoyer($billet['contenu'])?></p></div>
             </div>
         </div>
      </article>

    <!-- Affichage des commentaires du Billet -->
   <?php foreach ($commentaires as $commentaire):?>
   <div class="row">
       <article class="col-sm-offset-1 col-sm-11">
           <div class="row">
               <div class="col-sm-3">
                   <div class="row">
                       <div class="col-md-2 col-sm-12 col-xs-4">A</div>
                       <div class="col-md-10 col-sm-12 col-xs-8"><?= $this->nettoyer($commentaire['auteur'])?></div>
                   </div>
               </div>
               <div class="col-sm-9">
                   <div class="row">
                       <div class="col-sm-4 col-xs-6"><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($commentaire['date']->getTimestamp()))?></time></div>
                       <div class="col-sm-8 col-xs-6"><?= $this->nettoyer($billet['titre'])?></div>
                       <div class="col-xs-12"><p class="complet"><?= $this->nettoyer($commentaire['contenu'])?></p></div>
                       <div class="col-xs-4"><a href="<?= "billet/citer/". $this->nettoyer($commentaire['id'])?>">Répondre avec citation</a></div>
                       <?php if ($this->nettoyer($commentaire['auteur'])==$pseudo):?>
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