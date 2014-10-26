<!-- Portion de Vue spécifique à l'affichage du Blog -->

<?php $this->_titre = "Blog AtelierBlancNordOuest"; ?>

<?php foreach ($articles as $article):?>
    <a href="<?= "article/index/" . $this->nettoyer($article['id']) ?>">
        <h1 class="titreArticle"><?= $this->nettoyer($article['titre']) ?></h1>
     </a>
     
     <p><?= $this->nettoyer($article)['image']?></p>
            
     <time><?= $this->nettoyer($article['date']->format('d/m/Y - H\hi')) ?></time>
         	
     <time><?= $this->nettoyer($article['dateModif']->format('d/m/Y - H\hi')) ?></time>
         	
      <p><?= $this->nettoyer($article['contenu']) ?></p>
     
<?php endforeach; ?>

<!-- Formulaire de création de commentaire -->
   <?= $this->nettoyer($formulaire)?>    