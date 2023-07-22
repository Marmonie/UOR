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

		<?php 
			$nomErr = $courrielErr = $dateErr = "";
	  		$nom = $courriel = $date = "";
	  		$obl = "champs obligatoire";

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

			/*foreach($_POST as $clef => $valeur){
				$nclef = nettoyer($valeur);
				echo"<p>" . $clef . " vaut " . $nclef . "</p>";
			}*/

			/* Vérification de la validité des réponses, affichage des erreurs le cas échéant */
			if (empty($_POST['nom'])) {
				$nomErr = $obl;
			} else {
				$nom = nettoyer($_POST['nom']);
				// vérifie si nom contient seulement lettres et espaces
				if (!preg_match("/^[a-zA-Z-' ]*$/",$nom)) {
  				$nomErr = "seulement lettres et espaces autorisés";
  				}
			} 

			$courriel = nettoyer($_POST['courriel']);
			if (!filter_var($courriel, FILTER_VALIDATE_EMAIL)) {
  				$courrielErr = "adresse non valide";
  			} 

  			$date = $_POST['date'];
  			if (!validateDate($date)) {
  				$dateErr = "date non valide";
  			}

  			$question1 = $_POST['question1'];
		?>

		<!--Le Questionnaire-->
		<div>
			<p class="jargon">* champs obligatoire</p>
			<!--methode POST pour une question de sécurité-->
			<form class="questions" method="post" action="https://atco.000webhostapp.com/reception_quizz.php">

				<p> Nom ou pseudo : 
					<input type="text" name="nom" value="<?php echo $nom;?>"> <span class="jargon">*<?php echo $nomErr;?></span>
				</p>

				<p> Courriel : 
					<input type="text" name="courriel" value="<?php echo $courriel;?>"> <span class="jargon"><?php echo $courrielErr;?></span>
				</p>

				<p> Date : 
					<input type="text" name="date" value="<?php echo $date;?>"> <span class="jargon"><?php echo $dateErr;?></span>
				</p>

				<p class="questions">Question 1 : la norme de séparation radar est-elle respectée entre le SWW264 et le DIFCB&nbsp;?</p>
				<p><img class="pastropgrand" src="illustrations/sepradar1.png" alt="image d’une séparation radar"></p>
				<p><input type="radio" name="question1" <?php if (isset($question1) && $question1=="oui") echo "checked";?> value="oui">oui
					<input type="radio" name="question1" <?php if (isset($question1) && $question1=="non") echo "checked";?> value="non">non</p>

				<p><input type="submit"></p>

			</form>
		</div>
	</body>
