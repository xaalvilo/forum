<!-- Portion de Vue spécifique à l'affichage du bandeau -->

	<!-- Pseudo de l'utilisateur -->
	<div class="col-xs-1 col-xs-offset-2"><p><?=$this->nettoyer($pseudo) ?></p></div>
	
	<!-- lien de deconnexion de l'utilisateur -->
	<div class="col-xs-2"><a href="<?= "connexion/deconnecter/"?>"><p><?= $this->nettoyer($connexion) ?></p></a></div>
	
	<!-- Etat du panier -->
	<div class="col-xs-2"><p>Panier</p></div>
	
