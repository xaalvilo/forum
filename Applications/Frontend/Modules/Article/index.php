<!-- Portion de Vue spécifique à l'affichage des commentaires d'un Article du Blog -->

<section> 
    <article> 
        <?php $this->_titre = "Blog AtelierBlancNordOuest- ".$this->nettoyer($article['titre']);?>
        

	   <time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($article['date']->getTimestamp()))?></time>
	
	   <caption>
		  <h1 class="titreArticle"><?= $this->nettoyer($article['titre'])?></h1>		     
	   </caption>
	   <h2><?= $this->nettoyer($article['libelle'])?></h2>
	   <p><img src="Contenu/Images/<?= $this->nettoyer($article['image'])?>"  alt="photo article" id="photo"/></p>
	        
    	<p><?= $this->nettoyer($article['contenu'])?></p>
  
    <!-- Affichage des commentaires de l'article -->
        <table>    
            <?php foreach ($commentaires as $commentaire):?>
    	   <tr>
        	<td>
        		<h2 id="titreReponses"><?= $this->nettoyer($commentaire['auteur'])?></h2>  	
        	</td>
        	<td>
        		<time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($commentaire['date']->getTimestamp()))  ?></time>
           	</td>
        	<td>
        		<p><?= $this->nettoyer($commentaire['contenu'])?></p>
        		<?php if ($this->nettoyer($commentaire['auteur'])==$pseudo):?>
        		<a href="<?= "article/supprimer/" . $this->nettoyer($commentaire['id']) ?>">
            	<button> Supprimer </button></a>
            	<a href="<?= "article/modifier/" . $this->nettoyer($commentaire['id']) ?>">
            	<button> Modifier </button></a>
            	<?php endif;?>
        	</td>
    	   </tr>
         <?php endforeach;?>
        </table>  
  
    <!-- Formulaire de création de commentaire -->
    <?= $this->nettoyer($formulaire)?>
    
    </article> 
</section>   