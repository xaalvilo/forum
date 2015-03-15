<!-- Portion de Vue spécifique à l'affichage du Forum -->
<?php $this->_titre = "Forum AtelierBlancNordOuest"; ?>
<section class="col-sm-10">
           <h4><?=$this->nettoyer($titreTopic)?></h4>
</section>
<section class="col-sm-10">
<?php foreach ($billets as $billet):?>
      <div class="row">
          <article class="col-sm-12">
              <div class="row">
                  <div class="col-sm-3">
                      <div class="row">
                          <div class="col-md-2 col-sm-12 col-xs-6">A</div>
                          <div class="col-md-10 col-sm-12 col-xs-6"><?= $this->nettoyer($billet['auteur'])?></div>
                          <div class="col-xs-12"><h6 class="badge"><?= $this->nettoyer($billet['nbComents'])?> réponses</h6></div>
                      </div>
                  </div>
                  <div class="col-sm-9">
                      <div class="row">
                          <div class="col-sm-4 col-xs-6"><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($billet['date']->getTimestamp())) ?></time></div>
                          <div class="col-sm-8 col-xs-6"><a href="<?= "billet/index/". $this->nettoyer($billet['id']) ?>"><?= $this->nettoyer($billet['titre']) ?></a></div>
                          <div class="col-xs-12"><p class="extrait"><?= $this->nettoyer($billet['contenu']) ?></p></div>
                          <?php if ($this->nettoyer($billet['auteur'])==$pseudo):?>
                          <div class="col-xs-6"><a href="<?= "topic/supprimer/" . $this->nettoyer($billet['id']) ?>">Supprimer</a></div>
                          <div class="col-xs-6"><a href="<?= "topic/modifier/" . $this->nettoyer($billet['id']) ?>">Modifier</a></div>
                           <?php endif;?>
                      </div>
                  </div>
              </div>
           </article>
     </div>
<?php endforeach; ?>
</section>

<!-- volet latéral liste des topics -->
<aside class="col-sm-2">
    <div class="row">
        <div class="col-xs-12"><h4>Thèmes</h4></div>
        <?php foreach ($topics as $topic):
         if ($topic['titre'] == $titreTopic):?>
              <div class="col-sm-6 col-xs-2"><?= $this->nettoyer($titreTopic)?></div>
          <?php else:?>
             <div class="col-sm-6 col-xs-2"><a href="<?= "topic/index/" .$this->nettoyer($topic['id'])?>"><?= $this->nettoyer($topic['titre'])?></a></div>
          <?php endif;?>
        <?php endforeach;?>
   </div>
</aside>


<!-- Formulaire de création de billet -->
<section class="col-sm-10">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 col-sm-offset-1">
            <article class="well"><?= $this->nettoyer($formulaire)?></article>
        </div>
     </div>
</section>