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
        	</td>
    	</article>
    </tr>
<?php endforeach; ?>
</table>
<!-- Formulaire de création de commentaire -->
   <?= $this->nettoyer($formulaire)?>    