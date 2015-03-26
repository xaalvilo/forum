<!-- Portion de Vue spécifique à l'affichage du Forum -->
<?php $this->_titre = "Forum AtelierBlancNordOuest"; ?>

<!-- affichage des nouveaux billets -->
<?php if ($isNewBillets):?>
<section class="col-sm-12">
    <?php foreach ($billets as $billet):?>
        <div class="row">
            <article class="col-sm-12">
              <div class="row">
                  <div class="col-sm-2">
                      <div class="row">
                          <!-- il faut récupérer ici les données sur l'objet -->
                          <div class="col-sm-12"><h4><?=$this->nettoyer($billet->titreTopic)?></h4></div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="row">
                          <div class="col-sm-12 col-xs-6"><a href="<?="billet/index/". $this->nettoyer($billet['id'])?>"><?= $this->nettoyer($billet['titre'])?></a></div>
                          <div class="col-sm-12 col-xs-6"><p> créé par <?= $this->nettoyer($billet['auteur'])?><time> le <?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($billet['date']->getTimestamp())) ?></time></p></div>
                      </div>
                  </div>
                   <div class="col-sm-5">
                      <div class="row">
                          <div class="col-xs-12"><p class="extrait"><?= $this->nettoyer($billet['contenu']) ?></p></div>
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
<!-- affichage des topics de la catégorie sélectionnée -->
<?php else:?>
<section class="col-sm-12">
     <h4><?=$this->nettoyer($topics[0]['nomCategorie'])?></h4>
</section>
<section class="col-sm-12">
    <?php foreach ($topics as $topic):?>
    <div class="row">
		<article class="col-sm-12">
			<div class="row">
				<div class="col-sm-6">
					<a href="<?= "topic/index/".$this->nettoyer($topic['id'])?>"><?= $this->nettoyer($topic['titre'])?></a>
				</div>
				<div class="col-sm-1">
					<div class="row">
						<div class="col-xs-12">
							<h6><?= $this->nettoyer($topic['vu'])?> <span class="glyphicon glyphicon-eye-open"></span></h6>
						</div>
						<div class="col-xs-12">
							<h6><?= $this->nettoyer($topic['nbPost'])?> <span class="glyphicon glyphicon-envelope"></span></h6>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="row">
						<div class="col-xs-12">
							<a href="<?="billet/index/".$this->nettoyer($topic['idBillet'])?>"><h6><?= $this->nettoyer($topic['titreBillet'])?></h6></a>
						</div>
						<div class="col-xs-12">
							<h6>créé par <?= $this->nettoyer($topic['auteur'])?></h6>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="row">
						<div class="col-xs-12">
							<time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($topic['date']->getTimestamp())) ?></time>
						</div>
					</div>
				</div>
			</div>
		</article>
	</div>
	<?php endforeach;?>
</section>
<?php endif;?>
<section class="col-sm-12">
    <div class="row">
        <div class="col-sm-12"><h6><?= $this->nettoyer($nbVisiteurs)?> membre connecté</h6></div>
    </div>
</section>

