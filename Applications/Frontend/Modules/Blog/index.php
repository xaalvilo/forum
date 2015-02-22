<!-- Portion de Vue spécifique à l'affichage du Blog -->

<?php $this->_titre = "Blog AtelierBlancNordOuest"; ?>
<!-- Affichage du dernier article -->
   <?php if (!empty($this->nettoyer($dernierArticle))):?>
     <section class="col-sm-10">      
        	<article class="row">
        		<div class="col-sm-6"><img src="Contenu/Images/<?= $this->nettoyer($dernierArticle['image'])?>"  alt="photo article" id="photo"/></div>
        		<div class="col-sm-6">
        			<div class="row">       		
        				<div class="col-sm-8"><time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($dernierArticle['date']->getTimestamp()))?></time></div>
        				<div class="col-sm-4"><p><?=$this->nettoyer($dernierArticle['libelle'])?></p></div>        				
        				<div class="col-sm-12"><h2><?=$this->nettoyer($dernierArticle['titre'])?></h2></div>
        			</div>
        		</div>				     				
				<div class="col-sm-12"><p><?=$this->nettoyer($dernierArticle['contenu']) ?></p></div>			
            	<div class="col-sm-2 col-sm-offset-6"><a href="<?= "article/index/". $this->nettoyer($dernierArticle['id'])?>">
            		<button> Commentaires </button></a>
            	</div>
            
        	</article>      	
      </section>
      <?php endif;?>
<!-- volet latéral liste des libelles -->
    <aside class="col-sm-2">
        <ul>
                <li><a href="<?= "blog/index"?>">Tous</a></li>
            <?php foreach ($listeLibelles as $libelle):?>
                 <li><a href="<?= "blog/selectionnerLibelles/".$this->nettoyer($libelle)?>"><?=$this->nettoyer($libelle)?></a></li>
            <?php endforeach;?>
        </ul>
    </aside>
    
<!-- Formulaire d'edition d'article -->
      <section class="col-sm-10">
        <article>
            <?= $this->nettoyer($formulaire)?>
        </article>
      </section>
    
<!--  Affichage de la liste des articles -->
    <section class="col-sm-10">
        <?php foreach ($articles as $article):?>
        <article class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
            <time><?= strftime('%A %d %B %Y, %H:%M',$this->nettoyer($article['date']->getTimestamp()))?></time>
            <p><img src="Contenu/Images/<?= $this->nettoyer($article['image'])?>"  class="photo_miniature" /></p>
            <p><a class="gros" href="<?= "article/index/" . $this->nettoyer($article['id']) ?>"><?= $this->nettoyer($article['titre']) ?></a></p>
        </article>
        <?php endforeach;?>
    </section>

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




