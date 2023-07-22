<!DOCTYPE html>
<html lang="fr">
  	<!−−Chapitre 3 du cours "Utilisation d’Ordinateurs en Réseau" de P. Kislin−−>
  	<head>
    	<title>Contrôleur aérien</title>
    	<meta charset="utf-8">
    	<Content-Type: text/html; charset=utf-8> <!--pas compris la différence entre les deux... Apparemment, content-type est prioritaire sur meta charset, mais est-ce que meta charset est quand même utile ?-->
    	<link rel="stylesheet" type="text/css" href="UOR_page2.css">
    	<meta name="description" content="Un quizz pour tester sa compréhension du contrôle aérien et de ses outils.">
    	<meta name="url" content="atco.000webhostapp.com">
    	<meta name="author" content="OD">
    	<meta name="keywords" content="contrôle aérien, contrôleur aérien, aiguilleurs du ciel, ICNA, ATCO, navigation aérienne, DGAC">
  	</head>
  	<body>
  		<h1>L’heure du quizz</h1>
  		<p><blockquote class="citation">Remise de gaz&nbsp;!</blockquote></p>

  		<ul class="navbar">
			<li class="l"><a href="index.html">Accueil stylé</a></li>
			<li class="l"><a href="UOR_page1.html">Accueil basique</a></li>
			<li class="l"><a class="active" href="quizz.php">Quizz</a></li>
			<li class="r"><a href="#about">À propos</a></li>
		</ul>

		<!--Le Questionnaire-->
		<div>
			<p class="jargon">* champs obligatoire</p>
			<!--methode POST pour une question de sécurité-->
			<form class="questions" method="post" action="https://atco.000webhostapp.com/reception_quizz.php">

				<p> Nom ou pseudo : 
					<input type="text" name="nom"> <span class="jargon">*</span>
				</p>

				<p> Courriel : 
					<input type="text" name="courriel"> <span class="jargon"></span>
				</p>

				<p> Date : 
					<input type="text" name="date"> <span class="jargon"></span>
				</p>

				<p class="questions">Question 1 : la norme de séparation radar est-elle respectée entre le SWW264 et le DIFCB&nbsp;?</p>
				<p><img class="pastropgrand" src="illustrations/sepradar1.png" alt="image d’une séparation radar"></p>
				<p><input type="radio" name="question1"  value="oui">oui
					<input type="radio" name="question1" value="non">non</p>

				<p><input type="submit"></p>

			</form>
		</div>
	</body>
