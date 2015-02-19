<!-- Portion de Vue spécifique à l'affichage du Forum -->

<?php $this->_titre = "Forum AtelierBlancNordOuest"; ?>
<table>
<?php foreach ($billets as $billet):?>
    <tr>
        <article>
            <td>
               	<a href="<?= "billet/index/" . $this->nettoyer($billet['id']) ?>">
                <h1 class="titreBillet"><?= $this->nettoyer($billet['titre']) ?></h1>
                </a>
            </td>
            <td>
               	<h2 class="titreBillet"><?= $this->nettoyer($billet['auteur']) ?></h2>
            </td>
            <td>
         		<time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($billet['date']->getTimestamp()))  ?></time>
           	</td>
        	<td>
        		<p><?= $this->nettoyer($billet['contenu']) ?></p>
        		<?php if ($this->nettoyer($billet['auteur'])==$pseudo):?>
        		<a href="<?= "forum/supprimer/" . $this->nettoyer($billet['id']) ?>">
            	<button> Supprimer </button></a>
            	<a href="<?= "forum/modifier/" . $this->nettoyer($billet['id']) ?>">
            	<button> Modifier </button></a>
            	<?php endif;?>
        	</td>
    	</article>
    </tr>
<?php endforeach; ?>
</table>
<!-- Formulaire de création de commentaire -->
   <?= $this->nettoyer($formulaire)?>