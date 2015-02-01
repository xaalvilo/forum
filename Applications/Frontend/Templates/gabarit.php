<!DOCTYPE html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"> <!--encodage avec  tous les caract�res courants-->
	    <!-- [if lt IE 9]>
	       <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	       <![endif]-->
	    <meta name="author" content="Frédéric TARREAU">
	    <meta name="language" content="fr">
	    <meta name="date-creation-ddmmyyyy" content="30042014">
	    <meta http-equiv="content-style-type" content="text/css"> <!--meta donn�e utilisation feuille de style-->
	    <meta http-equiv="refresh" content="3600">
	    <base href="<?= $racineWeb ?>" >
        <style type="text/css"> @import url(Contenu/CSS/style.css) </style> <!--à pr�f�rer � <link etc... lien vers le fichier CSS-->
        <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'> <!--  importation de google font -->
        <title><?= $titre ?></title>
    </head>
    <body>
        <div id="global">
            <header>
                <img src="Contenu/Images/automnegrise.jpg" alt="banniere d'automne" id="banniere"/>
                <?= $bandeau ?>
                <?= $flash ?>
            </header>

            <nav id="menu">
                 <a class = "lienMenu" href="Accueil">Accueil</a> <a class = "lienMenu" href="Connexion">Forum </a>
                 <a class = "lienMenu" href="Blog">Blog</a><a class = "lienMenu" href="Connexion">Mon compte</a>
            </nav>

            <div id="contenu">
                <?= $contenu ?>
            </div>

            <footer id="piedPage">
                    pied de site � définir
            </footer>
        </div>
    </body>
</html>
