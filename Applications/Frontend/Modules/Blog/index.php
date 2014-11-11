<!-- Portion de Vue spécifique à l'affichage du Blog -->

<?php $this->_titre = "Blog AtelierBlancNordOuest"; ?>
<!-- Affichage du dernier article -->
     <section> 
        <article class="article_blog"> 
            <time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($dernierArticle['date']->getTimestamp()))  ?></time>
         	
            <time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($dernierArticle['dateModif']->getTimestamp())) ?></time>
     
            <h1 class="titreArticle"><?= $this->nettoyer($dernierArticle['titre']) ?></h1>
         
            <img src="Contenu/Images/<?= $this->nettoyer($dernierArticle['image'])?>"  alt="photo article" id="photo"/>
     
            <p><?= $this->nettoyer($dernierArticle['contenu']) ?></p>
      
            <a href="<?= "article/index/" . $this->nettoyer($dernierArticle['id']) ?>">
            <button> Commentaires </button></a>
        </article>
      </section>
      
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
          <p><a href="<?= "article/index/" . $this->nettoyer($article['id']) ?>">
                 <?= $this->nettoyer($article['titre']) ?></a>  </p>      
        </article>
        <?php endforeach;?>
    </section>
      

   