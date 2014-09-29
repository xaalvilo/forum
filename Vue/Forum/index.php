<!-- Portion de Vue spécifique à l'affichage du Blog -->

<?php $this->_titre = "Blog AtelierBlancNordOuest"; ?>
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
         		<time><?= $this->nettoyer($billet['date']->format('d/m/Y - H\hi')) ?></time>
         	</td>
        	<td>
        		<p><?= $this->nettoyer($billet['contenu']) ?></p>
        	</td>
    	</article>
    </tr>
<?php endforeach; ?>
</table>
