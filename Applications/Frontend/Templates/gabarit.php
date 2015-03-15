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
  			background-color: white;
  			border: 1px solid black;
  			border-radius: 6px;
  			line-height: 35px;
  			text-align: center;
		}

        .container {
  			padding-right: 15px;
  			padding-left: 15px;
  			margin-right: auto;
  			margin-left: auto;
		}

		#banniere {
		    width:80%;
		    height:auto;
		    margin-left: auto;
		    margin-right: auto;
        }

        #photo {
            width:25%;
            height:auto;
            margin-left: auto;
            margin-right: auto;
        }

        .photo_miniature {
            width:100%;
            height:auto;
        }

        time {
            font-size: 8px;
        }

        .extrait{
            text-overflow: ellipsis;
            overflow: hidden;
            max-height: 40px;
            text-align: left;
            word-wrap: break-word;
            overflow: hidden;
            background-color: #f5f5f5;
        }

        .complet{
            overflow: auto;
            height:auto;
            text-align: left;
            word-wrap: break-word;
            background-color: #f5f5f5;
            white-space: pre-wrap;
            line-height:1.1;
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
                <div class="col-sm-12">
                    <div class ="row">
                        <div class="col-sm-12">
                            <img src="Contenu/Images/automnegrise.jpg" alt="banniere d'automne" id="banniere"/>
                        </div>
                    </div>
            	</div>
            </header>
			<div class="row">
            	<nav class="col-sm-12">
            		<div class="navbar navbar-default navbar-static-top">

            		    <ul class="nav navbar-nav">
            		        <li> <a href="Accueil">Accueil</a> </li>
            		        <li class="dropdown">
            		            <a data-toggle="dropdown" href="Connexion/index/1">Forum<b class="caret"></b></a>
            		                 <ul class="dropdown-menu">
            		                     <li><a href="Connexion/index/1">Jaune</a></li>
            		                     <li><a href="Connexion/index/2">Vert</a></li>
            		                     <li><a href="Connexion/index/3">Bleu</a></li>
            		                     <li><a href="Connexion/index/4">Blanc</a></li>
            		                  </ul>
            		        <li> <a href="Blog">Blog</a> </li>
            		        <li class="disabled"> <a href="Cours">Cours</a> </li>
            		        <li class="disabled"> <a href="Boutique">Boutique</a> </li>
            		        <li> <a href="Inscription">Mon compte</a> </li>
            		     </ul>
            		     <ul class="nav navbar-nav navbar-right">
            		     <p class="navbar-text"><?=$flash?></p>
            		         <?=$bandeau?>
            		     </ul>
            		 </div>

            	</nav>
			</div>
            <div class="row">
                <?= $contenu ?>
            </div>

            <footer class="row">
                <div class="col-sm-12">
                    pied de site à définir
                </div>
            </footer>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="Contenu/Bootstrap/js/bootstrap.js "></script>
        <script>
        $(function() {
            $('a').click(function() {
              $('#item').collapse('toggle');
            });
            $('#item').on('shown.bs.collapse', function () {
              alert('On me voit !');
            })
          });
    </script>
    </body>
</html>
