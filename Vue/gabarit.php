<!DOCTYPE html> 
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"> <!--encodage avec  tous les caract�res courants-->
	    <meta name="author" content="Frédéric TARREAU">
	    <meta name="language" content="fr">
	    <meta name="date-creation-ddmmyyyy" content="30042014">
	    <meta http-equiv="content-style-type" content="text/css"> <!--meta donn�e utilisation feuille de style-->
	    <meta http-equiv="refresh" content="3600">
	    <base href="<?= $racineWeb ?>" >
        <style type="text/css"> @import url(Contenu/style.css) </style> <!--à pr�f�rer � <link etc... lien vers le fichier CSS-->
        <title><?= $titre ?></title> 
    </head>
    <body>
        <div id="global">
            <header>
                <a href=""><h1 id="titreBlog">Mon Forum</h1></a>
                <p>Bienvenue sur le site etc....</p>
            </header>
            <div id="contenu">
                <?= $contenu?>
            </div> 
            <footer id="piedBlog">
                    pied de site � définir
            </footer>
        </div> 
    </body>
</html>
