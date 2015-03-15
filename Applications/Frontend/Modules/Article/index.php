
<?php $this->_titre = "Blog AtelierBlancNordOuest- ".$this->nettoyer($article['titre']);?>
<!-- Portion de Vue spécifique à l'affichage des commentaires d'un Article du Blog -->

<section class="col-sm-10">
    <article class="row">
        <div class="col-sm-4"><img src="Contenu/Images/<?= $this->nettoyer($article['image'])?>"  alt="photo article" id="photo"/></div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-12"><h4><?=$this->nettoyer($article['titre'])?></h4></div>
                <div class="col-sm-8"><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($article['date']->getTimestamp()))?></time></div>
                <div class="col-sm-4"><h6><?= $this->nettoyer($article['libelle'])?></h6></div>
            </div>
         </div>
         <div class="col-sm-12"><?= $this->nettoyer($article['contenu'])?></div>
    </article>

    <!-- Affichage des commentaires de l'article -->

    <?php foreach ($commentaires as $commentaire):?>
    <div class="row">
        <article class="col-sm-offset-1 col-sm-11">
            <div class="row">
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-xs-4">A</div>
                        <div class="col-xs-8"><?= $this->nettoyer($commentaire['auteur'])?></div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4 col-xs-6"><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($commentaire['date']->getTimestamp()))?></time></div>
                        <div class="col-sm-8 col-xs-6"><?=$this->nettoyer($article['titre'])?></div>
                        <div class="col-xs-12"><?= $this->nettoyer($commentaire['contenu'])?></div>
                        <?php if ($this->nettoyer($commentaire['auteur'])==$pseudo):?>
                        <div class="col-xs-6"><a href="<?= "article/supprimer/" . $this->nettoyer($commentaire['id'])?>">Supprimer</a></div>
                        <div class="col-xs-6"><a href="<?= "article/modifier/" . $this->nettoyer($commentaire['id']) ?>">Modifier</a></div>
                        <?php endif;?>
                    </div>
                 </div>
            </div>
         </article>
     </div>
     <?php endforeach;?>
</section>

    <!-- volet latéral liste des libelles -->
<aside class="col-sm-2">
    <div class="row">
             <div class="col-xs-12"><h4>Tags</h4></div>
             <div class="col-sm-6 col-xs-2"><a href="<?= "blog/index"?>">Tous</a></div>
      <?php foreach ($listeLibelles as $libelle):
          if ($libelle == $article['libelle']):?>
              <div class="col-sm-6 col-xs-2"><a href="<?= "blog/selectionnerLibelles/".$this->nettoyer($libelle)?>" class="active"><?=$this->nettoyer($libelle)?></a></div>
          <?php else:?>
             <div class="col-sm-6 col-xs-2"><a href="<?= "blog/selectionnerLibelles/".$this->nettoyer($libelle)?>"><?=$this->nettoyer($libelle)?></a></div>
          <?php endif;?>
      <?php endforeach;?>
</aside>

<!-- Formulaire de création de commentaire -->
<section class="col-sm-10">
   <div class="row">
       <div class="well"><?= $this->nettoyer($formulaire)?></div>
   </div>
</section>