<!-- Portion de Vue spécifique à l'affichage du bandeau -->

	<!-- Pseudo de l'utilisateur -->
	<li class="disabled"><a href="#"><span class="glyphicon glyphicon-user"></span> <?=$this->nettoyer($pseudo) ?></a></li>

	<!-- lien de deconnexion de l'utilisateur -->
	<li><a href="<?= "connexion/deconnecter/"?>"><?= $this->nettoyer($connexion) ?></a></li>

	<!-- Etat du panier -->
	<li class="disabled"><a href="#">Panier</a></li>

