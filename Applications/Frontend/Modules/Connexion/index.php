<?php $this->_titre = "Connexion AtelierBlancNordOuest"; ?>
<section class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">Ce forum est privé, vous devez vous authentifier ou vous inscrire</div>
    </div>
    <div class="row">
        <!-- Portion de Vue spécifique à l'affichage du formulaire de connexion -->
        <div class="col-sm-6"><?= $this->nettoyer($formulaire)?></div>

        <!-- lien vers le formulaire d'inscription -->
        <div class="col-sm-6"><a href="Inscription">Créer un compte</a></div>
    </div>
</section>