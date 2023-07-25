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
  		<p><blockquote class="citation">Serez-vous à la hauteur&nbsp;?</blockquote></p>

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
					<p><input type="radio" name="question1" value="oui">oui
						<input type="radio" name="question1" value="non">non</p>

					<p><strong>Question 2 :</strong> concernant le vol TRA85N</p>
					<p><img class="pastropgrand" src="illustrations/strip_tra.png" alt="image d’un strip"></p>
					<p><input type="radio" name="question2" value="transat">Son indicatif est «&nbsp;Air Transat 85 Novembre&nbsp;» (<em>'Novembre' est le nom de la lettre 'N' dans l’alphabet aéronautique)</em></p>
					<p><input type="radio" name="question2" value="B737">Ce vol s’effectue dans un Boeing 737-800</p>
					<p><input type="radio" name="question2" value="badod">Il est à destination de Badod, en Inde</p>

					<p><strong>Question 3 :</strong> le language utilisé par les pilotes et les contrôleurs pour communiquer entre eux s’appelle :</p>
					<p><input type="radio" name="question3" value="communication non violente">la communication non violente</p>
					<p><input type="radio" name="question3" value="standardisation">la standardisation</p>
					<p><input type="radio" name="question3" value="phraséologie">la phraséologie</p>
					<p><input type="radio" name="question3" value="protocole TCP">le protocole "transmission contrôleur-pilote"</p>

					<p><strong>Question 4 :</strong> le vol EZY51NM a été autorisé à descendre vers </p>
					<p><img class="pastropgrand" src="illustrations/strip_ezy.png" alt="image d’un strip"></p>
					<p><input type="radio" name="question4" value="6360">une altitude de 6360ft</p>
					<p><input type="radio" name="question4" value="5000">une altitude de 5000ft</p>
					<p><input type="radio" name="question4" value="110">un niveau de vol 110 (environ 11000ft)</p>

					<p><strong>Question 5 :</strong> la norme de séparation radar est-elle respectée entre le DLH11P et le EZY34XF&nbsp;?</p>
					<p><img class="pastropgrand" src="illustrations/sepradar2.png" alt="image d’une séparation radar"></p>
					<p><input type="radio" name="question5" value="oui">oui
						<input type="radio" name="question5" value="non">non</p>

					<p><input type="submit" value="Vérifier mes réponses"></p>
				</div>
			</form>
		</section>
	</body>
