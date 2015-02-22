<!DOCTYPE html>
    <head>
        <meta http-equiv="content-type" content="text/html" charset="utf-8"> <!--encodage avec  tous les caract�res courants-->
	    
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!-- [if lt IE 9]>
	       <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	       <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	       <![endif]-->
	    <meta name="author" content="Frédéric TARREAU">
	    <meta name="language" content="fr">
	    <meta name="date-creation-ddmmyyyy" content="30042014">
	    <!--  <meta http-equiv="content-style-type" content="text/css"> --><!--meta donn�e utilisation feuille de style-->
	    <meta http-equiv="refresh" content="3600">
	    <meta http-equiv="X-UA-Comptatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <base href="<?= $racineWeb ?>">
	    
	    <!--  Bootstrap core CSS -->         
        <link href="Contenu/Bootstrap/css/bootstrap.css" rel="stylesheet">
        
        <!-- Custom style -->
      	<!--    <link href="Contenu/CSS/style.css" rel="stylesheet">-->
        <style type="text/css">
        body {
  			padding-top: 10px;
		}
		[class*="col-"], footer {
  			background-color: lightgreen;
  			border: 2px solid black;
  			border-radius: 6px;
  			line-height: 40px;
  			text-align: center;
		} 
		
        .container {
  			padding-right: 15px;
  			padding-left: 15px;
  			margin-right: auto;
  			margin-left: auto;
		}
		
        @media (min-width: 768px) {
  			.container {
    			width: 750px;
  			}
		}
		
		@media (min-width: 992px) {
  			.container {
    			width: 970px;
  			}
		}
		
		@media (min-width: 1200px) {
  			.container {
    			width: 1170px;
  			}
		}
        </style>
        
        <!--  <style type="text/css"> @import url(Contenu/CSS/style.css) </style> --><!--à pr�f�rer � <link etc... lien vers le fichier CSS-->
        <!--  <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>--><!--  importation de google font -->
        
        <title><?= $titre ?></title>
    </head>
    <body>
        <div class="container">
            <header class="row">
            	<div class ="row">
            		<div class="col-sm-12">
                		<img src="Contenu/Images/automnegrise.jpg" alt="banniere d'automne" id="banniere"/>
                		<p> banniere</p>
            		</div>
            	</div>
            	<div class="row">               		
            		<div class="col-sm-12">
            			<div class="row">
            				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5"
                				<p><?= $flash ?></p>
            		    	</div>         				
            					<?= $bandeau ?>
            				
            			</div>
            		</div>
            	</div>                              
            </header>
			<div class="row">
            	<nav class="col-sm-12">
            		<div class="row"> 
                 		<div class="col-xs-3"><a href="Accueil">Accueil</a> </div>
                 		<div class="col-xs-3"><a href="Connexion">Forum </a></div>
                 		<div class="col-xs-3"><a href="Blog">Blog</a></div>
                 		<div class="col-xs-3"><a href="Inscription">Mon compte</a></div>
                 	</div>
            	</nav>
			</div>
            <div class="row">
                <?= $contenu ?>
            </div>

            <footer class="row">
                    pied de site à définir
            </footer>
        </div>
    </body>
</html>
