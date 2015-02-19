<!-- Portion de Vue spécifique à l'affichage du Blog -->

<?php $this->_titre = "Blog AtelierBlancNordOuest"; ?>
<!-- Affichage du dernier article -->
   <?php if (!empty($this->nettoyer($dernierArticle))):?>
     <section>
        <article class="article_blog">
            <time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($dernierArticle['date']->getTimestamp()))  ?></time>

            <h1 class="titreArticle"><?= $this->nettoyer($dernierArticle['titre']) ?></h1>

            <img src="Contenu/Images/<?= $this->nettoyer($dernierArticle['image'])?>"  alt="photo article" id="photo"/>

            <p><?= $this->nettoyer($dernierArticle['libelle']) ?></p>

            <p><?= $this->nettoyer($dernierArticle['contenu']) ?></p>

            <a href="<?= "article/index/" . $this->nettoyer($dernierArticle['id']) ?>">
            <button> Commentaires </button></a>
        </article>
      </section>
      <?php endif;?>

<!-- Formulaire d'edition d'article -->
      <section>
        <article>
            <?= $this->nettoyer($formulaire)?>
        </article>
      </section>

<!--  Affichage de la liste des articles -->
    <section>
        <?php foreach ($articles as $article):?>
        <article class="resume">
            <time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($article['date']->getTimestamp()))?></time>
            <p><img src="Contenu/Images/<?= $this->nettoyer($article['image'])?>"  class="photo_miniature" /></p>
            <p><a class="gros" href="<?= "article/index/" . $this->nettoyer($article['id']) ?>"><?= $this->nettoyer($article['titre']) ?></a></p>
        </article>
        <?php endforeach;?>
    </section>

<!-- volet latéral liste des libelles -->
    <aside class="lateral">
        <ul>
                <li><a href="<?= "blog/index"?>">Tous</a></li>
            <?php foreach ($listeLibelles as $libelle):?>
                 <li><a href="<?= "blog/selectionnerLibelles/".$this->nettoyer($libelle)?>"><?=$this->nettoyer($libelle)?></a></li>
            <?php endforeach;?>
        </ul>
    </aside>

 <!-- liens vers les pages d'articles suivants -->
    <nav class="resume" id="menuBas">
         <?php $courant = $this->nettoyer($curseur);
               foreach ($listeArticles as $key=>$idPage):
                    if($this->nettoyer($idPage)==$courant):?>
                       <p class = "lienMenu"> <?= $this->nettoyer($key + 1)?></p>
             <?php  else :?>
                       <a class = "lienMenu" href="<?= "blog/index/".$this->nettoyer($idPage)?>"><?=round($this->nettoyer($key + 1))?></a>
              <?php endif;?>
         <?php endforeach;?>
    </nav>




