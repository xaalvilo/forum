<!-- Portion de Vue spécifique à l'affichage des commentaires d'un Billet du  Forum -->

<?php $this->_titre = "Forum AtelierBlancNordOuest- ".$this->nettoyer($billet['titre']);?>
<table>
	<caption>
		<h1 class="titreBillet"><?= $this->nettoyer($billet['titre'])?></h1>
	</caption>
	<tr>
    	<td>
       		<h2 id="titreReponses"><?= $this->nettoyer($billet['auteur'])?></h2>
    	</td>
    	<td>
        	<time><?= $this->nettoyer($billet['date']->format('d/m/Y - H\hi'))?></time>
    	</td>
  		<td>
    		<p><?= $this->nettoyer($billet['contenu'])?></p>
    	</td>
	</tr>
   
    <!-- Affichage des commentaires du Billet -->
    <?php foreach ($commentaires as $commentaire):?>
    	<tr>
        	<td>
        		<h2 id="titreReponses"><?= $this->nettoyer($commentaire['auteur'])?></h2>  	
        	</td>
        	<td>
        		<time><?= $this->nettoyer($commentaire['date']->format('d/m/Y - H\hi'))?></time>
        	</td>
        	<td>
        		<p><?= $this->nettoyer($commentaire['contenu'])?></p>
        	</td>
    	</tr>
    <?php endforeach;?>
</table>   

<!-- Formulaire de création de commentaire -->
   <?= $this->nettoyer($formulaire)?>    
    
    