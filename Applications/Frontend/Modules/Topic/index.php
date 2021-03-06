<!-- Portion de Vue spécifique à l'affichage du Forum -->
<?php $this->_titre = "Forum AtelierBlancNordOuest"; ?>
<section class="col-sm-10">
    <div class="row">
        <div class="col-sm-12"><h4><?=$this->nettoyer($titreTopic)?></h4></di
    </div>
</section>
<section class="col-sm-10">
<?php foreach ($billets as $billet):?>
      <div class="row">
          <article class="col-sm-12">
              <div class="row">
                  <div class="col-sm-4">
                      <div class="row">
                          <div class="col-sm-12 col-xs-6"><a href="<?="billet/index/". $this->nettoyer($billet['id'])?>"><?= $this->nettoyer($billet['titre'])?></a></div>
                          <div class="col-sm-12 col-xs-6"><p> créé par <?= $this->nettoyer($billet['auteur'])?><time> le <?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($billet['date']->getTimestamp())) ?></time></p></div>
                      </div>
                  </div>
                   <div class="col-sm-7">
                      <div class="row">
                          <div class="col-xs-12"><p class="extrait"><?= $this->nettoyer($billet['contenu']) ?></p></div>
                          <?php if ($billet['auteur']==$pseudo):?>
                          <div class="col-xs-6"><a href="<?= "topic/supprimer/" . $this->nettoyer($billet['id']) ?>">Supprimer</a></div>
                          <div class="col-xs-6"><a href="<?= "topic/modifier/" . $this->nettoyer($billet['id']) ?>">Modifier</a></div>
                           <?php endif;?>
                      </div>
                  </div>
                  <div class="col-sm-1">
                      <div class="row">
                          <div class="col-sm-12 col-xs-6"><h6><?= $this->nettoyer($billet['nbComents'])?> <span class="glyphicon glyphicon-comment"></span></h6></div>
                          <div class="col-sm-12 col-xs-6"><h6><?= $this->nettoyer($billet['nbVu'])?> <span class="glyphicon glyphicon-eye-open"></span></h6></div>
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