<!-- Portion de Vue spécifique à l'affichage du bandeau -->

<!-- Pseudo de l'utilisateur -->
<p><?=$this->nettoyer($pseudo) ?></p>

<!-- Etat du panier -->

<!-- lien de deconnexion de l'utilisateur -->
<a href="<?= "connexion/deconnecter/"?>"><h3><?= $this->nettoyer($connexion) ?></h3></a>