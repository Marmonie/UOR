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

<!--Traitement des réponses au questionnaire-->
		<?php 
			$nomErr = $courrielErr = $dateErr = "";
	  		$nom = $courriel = $date = $question1 = $question2 = $question3 = "";
	  		$obl = "champs obligatoire";
	  		$reponse1 = "";
	  		$reponse2 = "";
	  		$reponse3 = "";
	  		$questionnaire_ok = FALSE;

			/* fonctions qui accentuent la sécurité du formulaire (source : "https://www.w3schools.com/php/php_form_validation.asp" et le cours) */
	  		function nettoyer($data) {
	  			$data = trim($data); // enlève les caractères superflus
	  			$data = stripslashes($data); // enlève les "\"
	  			$data = htmlspecialchars($data); /* convertit les car. spéciaux en code html*/
	  			return $data;
			}

			/* Validation du format de la date, source : https://www.php.net/manual/en/function.checkdate.php */
			function validateDate($date, $format = 'd/m/Y') {
    			$d = DateTime::createFromFormat($format, $date);
    			return $d && $d->format($format) == $date;
			}

			/*exemple du cours
			foreach($_POST as $clef => $valeur){
				$nclef = nettoyer($valeur);
				echo"<p>" . $clef . " vaut " . $nclef . "</p>";
			}*/

			/* Vérification de la validité des réponses, affichage des erreurs le cas échéant */
			if (empty($_POST['nom'])) {
				$nomErr = $obl;
			} else {
				$nom = nettoyer($_POST['nom']);
				// vérifie si nom contient seulement lettres, chiffres et espaces
				if (!preg_match("/^[0-9a-zA-Z-' ]*$/",$nom)) {
  				$nomErr = "seulement lettres, chiffres et espaces autorisés";
  				}
			} 

			if (!empty($_POST['courriel'])) {
				$courriel = nettoyer($_POST['courriel']);
			}
			if (!filter_var($courriel, FILTER_VALIDATE_EMAIL)) {
  				$courrielErr = "adresse non valide";
  			} 

  			if(!empty($_POST['date'])) {
  				$date = $_POST['date'];
  			}
  			if (!validateDate($date)) {
  				$dateErr = "date non valide";
  			}

  			if (!empty($_POST['question1'])) {
  				$question1 = $_POST['question1'];
  			} 

  			if (!empty($_POST['question2'])) {
  				$question2 = $_POST['question2'];
  			} 

  			if (!empty($_POST['question3'])) {
  				$question3 = $_POST['question3'];
  			} 

  			/* Vérification que nom, courriel et date sont bien remplis (pour affichage réponses) */
  			if ($nomErr = $courrielErr = $dateErr = "") {
  				$questionnaire_ok = TRUE;
  			}

  			?>

<!--Le Questionnaire-->
		<section>
			<p class="erreur">* champs obligatoire</p>
			<!--methode POST pour une question de sécurité-->
			<form method="post" action="https://atco.000webhostapp.com/reception_quizz.php">

				<p> Nom ou pseudo : 
					<input type="text" name="nom" value="<?php echo $nom;?>"> <span class="erreur">*<?php echo $nomErr;?></span>
				</p>

				<p> Courriel : 
					<input type="text" name="courriel" value="<?php echo $courriel;?>"> <span class="erreur"><?php echo $courrielErr;?></span>
				</p>

				<p> Date (jj/mm/aaaa) : 
					<input type="text" name="date" value="<?php echo $date;?>"> <span class="erreur"><?php echo $dateErr;?></span>
				</p>
				<div class="questions">
					<p>Question 1 : la norme de séparation radar est-elle respectée entre le SWW264 et le DIFCB&nbsp;?</p>
					<p><img class="pastropgrand" src="illustrations/sepradar1.png" alt="image d’une séparation radar"></p>
					<p><input type="radio" name="question1" <?php if (isset($question1) && $question1=="oui") echo "checked";?> value="oui">oui
						<input type="radio" name="question1" <?php if (isset($question1) && $question1=="non") echo "checked";?> value="non">non</p>

					<?php
						if ($questionnaire_ok) {
							if ($question1 = "oui") {
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='jargon'>Raté. ";
							}
							echo("Les deux avions sont à 2000ft (deuxième ligne de l’étiquette), mais ils sont séparés latéralement de 6,86NM. La norme est donc respectée.</p>");
						}
					?>

					<p>Question 2 : quelle est la destination du xxx&nbsp;?</p>
					<p><img class="pastropgrand" src="illustrations/strip.png" alt="image d’un strip"></p>
					<p><input type="radio" name="question2" <?php if (isset($question2) && $question2=="a") echo "checked";?> value="a">a
						<input type="radio" name="question2" <?php if (isset($question2) && $question2=="b") echo "checked";?> value="b">b
						<input type="radio" name="question2" <?php if (isset($question2) && $question2=="c") echo "checked";?> value="c">c</p>

					<p>Question 3 : le language utilisé par les pilotes et les contrôleurs pour communiquer entre eux s’appelle :</p>
					<p><input type="radio" name="question3" <?php if (isset($question3) && $question3=="communication non violente") echo "checked";?> value="communication non violente">la communication non violente</p>
					<p><input type="radio" name="question3" <?php if (isset($question3) && $question3=="standardisation") echo "checked";?> value="standardisation">la standardisation</p>
					<p><input type="radio" name="question3" <?php if (isset($question3) && $question3=="phraséologie") echo "checked";?> value="phraséologie">la phraséologie</p>
					<p><input type="radio" name="question3" <?php if (isset($question3) && $question3=="protocole TCP") echo "checked";?> value="protocole TCP">le protocole "transmission contrôleur-pilote"</p>

					<p><input type="submit" value="Vérifier mes réponses"></p>
				</div>
			</form>
		</section>
	</body>
