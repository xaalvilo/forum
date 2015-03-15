<!-- Portion de Vue spécifique à l'affichage du Blog -->

<?php $this->_titre = "Blog AtelierBlancNordOuest"; ?>
<!-- Affichage du dernier article -->
<?php if (!empty($this->nettoyer($dernierArticle))):?>
<section class="col-sm-10">
    <article class="row">
        <div class="col-sm-4"><img src="Contenu/Images/<?= $this->nettoyer($dernierArticle['image'])?>" alt="photo article" id="photo"/></div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-12"><h4><?=$this->nettoyer($dernierArticle['titre'])?></h4></div>
                <div class="col-sm-8"><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($dernierArticle['date']->getTimestamp()))?></time></div>
                <div class="col-sm-4"><h6><?=$this->nettoyer($dernierArticle['libelle'])?></h6></div>
             </div>
        </div>
        <div class="col-sm-4"><a class="btn btn-default btn-block" href="<?= "article/index/". $this->nettoyer($dernierArticle['id'])?>">
            Commentaires <span class="badge"><?=$this->nettoyer($dernierArticle['nbComents'])?></span></a></div>
		<div class="col-sm-8"><p><?=$this->nettoyer($dernierArticle['contenu']) ?></p></div>
    </article>
</section>

<!--  volet latéral cv -->
<aside class="hidden-xs col-sm-2">
    <div class="row">beaucoup de texte</div>
</aside>
<?php endif;?>

<!-- Formulaire d'edition d'article -->
<section class="col-sm-10">
    <div class="row">
        <article class="well"><?= $this->nettoyer($formulaire)?></article>
    </div>
</section>

<!--  Affichage de la liste des articles -->
<section class="col-sm-10">
    <div class="row">
    <?php foreach ($articles as $article):?>
            <article class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                <p><a href="<?= "article/index/" . $this->nettoyer($article['id']) ?>"><?= $this->nettoyer($article['titre']) ?></a></p>
                <p><img src="Contenu/Images/<?= $this->nettoyer($article['image'])?>"  class="photo_miniature" /></p>
                <!--  <time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($article['date']->getTimestamp()))?></time>-->
             </article>
    <?php endforeach;?>
    </div>
    <!-- liens vers les pages d'articles suivants -->
    <nav class="row">
        <div class="col-sm-12">
            <div class="row">
                <ul class="pagination">
                <?php $courant = $this->nettoyer($curseur);
                    foreach ($listeArticles as $key=>$idPage):
                        if($this->nettoyer($idPage)==$courant):?>
                            <li class="disabled"><a href="<?= "blog/index/".$this->nettoyer($idPage)?>"><?= $this->nettoyer($key + 1)?></a> </li>
                        <?php else :?>
                            <li><a href="<?= "blog/index/".$this->nettoyer($idPage)?>"><?=round($this->nettoyer($key + 1))?></a></li>
                        <?php endif;
                     endforeach;?>
                </ul>
            </div>
        </div>
   </nav>
</section>

<!-- volet latéral liste des libelles -->
<aside class="col-sm-2">
    <div class="row">
             <div class="col-xs-12"><h4>Tags</h4></div>
             <div class="col-sm-6 col-xs-2"><a href="<?= "blog/index"?>">Tous</a></div>
      <?php foreach ($listeLibelles as $libelle):?>
             <div class="col-sm-6 col-xs-2"><a href="<?= "blog/selectionnerLibelles/".$this->nettoyer($libelle)?>"><?=$this->nettoyer($libelle)?></a></div>
      <?php endforeach;?>
    </div>
</aside>




