<!-- Portion de Vue spécifique à l'affichage du Forum -->
<?php $this->_titre = "Forum AtelierBlancNordOuest"; ?>
<section class="col-sm-12">
           <h4><?=$this->nettoyer($topics[0]['nomCategorie'])?></h4>
</section>
<section class="col-sm-12">
<?php foreach ($topics as $topic):?>
      <div class="row">
          <article class="col-sm-12">
              <div class="row">
                  <div class="col-sm-6"><a href="<?= "topic/index/".$this->nettoyer($topic['id'])?>"><?= $this->nettoyer($topic['titre'])?></a></div>
                  <div class="col-sm-2">
                      <div class="row">
                          <div class="col-xs-12"><h6 class="badge"><?= $this->nettoyer($topic['vu'])?> vues</h6></div>
                          <div class="col-xs-12"><h6 class="badge"><?= $this->nettoyer($topic['nbPost'])?> discussions</h6></div>
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="row">
                          <div class="col-xs-12"><a href="<?="billet/index/".$this->nettoyer($topic['idBillet'])?>"><h6><?= $this->nettoyer($topic['titreBillet'])?></h6></a></div>
                          <div class="col-xs-12"><h6>par <?= $this->nettoyer($topic['auteur'])?></h6></div>
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="row">
                          <div class="col-xs-12"><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($topic['date']->getTimestamp())) ?></time></div>
                      </div>
                  </div>
              </div>
         </article>
     </div>
<?php endforeach;?>
</section>

