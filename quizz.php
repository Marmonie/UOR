<!DOCTYPE html>
<html lang="fr">
  	<!--Chapitre 3 du cours "Utilisation d’Ordinateurs en Réseau" de P. Kislin-->
  	<head>
    	<title>Contrôleur aérien</title>
    	<meta charset="utf-8">
    	<link rel="stylesheet" type="text/css" href="UOR_page2.css">
    	<meta name="description" content="Un quizz pour tester sa compréhension du contrôle aérien et de ses outils.">
    	<meta name="url" content="atco.000webhostapp.com">
    	<meta name="author" content="OD">
    	<meta name="keywords" content="contrôle aérien, contrôleur aérien, aiguilleurs du ciel, ICNA, ATCO, navigation aérienne, DGAC">
  	</head>
  	<body>
  		<h1>L’heure du quizz</h1>
  		<p><blockquote class="citation">Remise de gaz&nbsp;!</blockquote></p>

<!--La barre de navigation-->
  		<ul class="navbar">
			<li class="l"><a href="index.html">Accueil stylé</a></li>
			<li class="l"><a href="UOR_page1.html">Accueil basique</a></li>
			<li class="l"><a class="active" href="quizz.php">Quizz</a></li>
			<li class="r"><a href="#about">À propos</a></li>
		</ul>

<!--Le Questionnaire-->
		<section>
			<p class="erreur">* champs obligatoire</p>
			<!--methode POST pour une question de sécurité-->
			<form method="post" action="https://atco.000webhostapp.com/reception_quizz.php">

				<p> Nom ou pseudo : 
					<input type="text" name="nom" value=""> <span class="erreur">*</span>
				</p>

				<p> Courriel : 
					<input type="text" name="courriel" value=""> <span class="erreur"></span>
				</p>

				<p> Date (jj/mm/aaaa) : 
					<input type="text" name="date" value=""> <span class="erreur"></span>
				</p>
				<div class="questions">
					<p><strong>Question 1 :</strong> la norme de séparation radar est-elle respectée entre le SWW264 et le DIFCB&nbsp;?</p>
					<p><img class="pastropgrand" src="illustrations/sepradar1.png" alt="image d’une séparation radar"></p>
					<p><input type="radio" name="question1"  value="oui">oui
						<input type="radio" name="question1"  value="non">non</p>

					<p><strong>Question 2 :</strong> quelle est la destination du xxx&nbsp;?</p>
					<p><img class="pastropgrand" src="illustrations/strip.png" alt="image d’un strip"></p>
					<p><input type="radio" name="question2" value="B738">B738
						<input type="radio" name="question2" value="LFTH">LFTH
						<input type="radio" name="question2" value="LFRS">LFRS</p>

					<p><strong>Question 3 :</strong> le language utilisé par les pilotes et les contrôleurs pour communiquer entre eux s’appelle :</p>
					<p><input type="radio" name="question3" value="communication non violente">la communication non violente</p>
					<p><input type="radio" name="question3" value="standardisation">la standardisation</p>
					<p><input type="radio" name="question3" value="phraséologie">la phraséologie</p>
					<p><input type="radio" name="question3" value="protocole TCP">le protocole "transmission contrôleur-pilote"</p>

					<p><input type="submit" value="Vérifier mes réponses"></p>
				</div>
			</form>
		</section>
	</body>
