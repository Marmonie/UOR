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
	  		$reponse1 = "oui";
	  		$reponse2 = "B737";
	  		$reponse3 = "phraséologie";
	  		$reponse4 = "5000";
	  		$reponse5 = "oui";
	  		$score = 0;
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
				if (!filter_var($courriel, FILTER_VALIDATE_EMAIL)) {
  				$courrielErr = "adresse non valide";
				}
			} 

			// Si date entrée, vérifie son format ; sinon date = date du jour
			date_default_timezone_set("Europe/Paris")
  			if(!empty($_POST['date'])) {
  				$date = $_POST['date'];
  				if (!validateDate($date)) {
  				$dateErr = "date non valide";
  				}
  			} else {
  				$date = date('d/m/Y')
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
  			if ($nomErr == "" && $courrielErr == "" && $dateErr == "") {
  				$questionnaire_ok = TRUE;
  			}

  		?>

		<?php

		/* mySQL */
			/* test connection
			$conn_test = mysqli_connect("localhost", "id21044620_atco", "icna11b@Nice");

			if (!$conn_test) {
				die("Connection failed : " . mysqli_connect_error());
			} else {
				echo "Connected successfully";
			}*/

			if ($questionnaire_ok) {
				// connection bdd
				$conn = mysqli_connect("localhost", "id21044620_atco", "icna11b@Nice", "id21044620_atcodb");
				// test connection
				if (!$conn) {
					die("Connection failed : " . mysqli_connect_error());
				}

				// insertion données questionnaire dans bdd
				$sql_insert = "INSERT INTO id21044620_atcodb.questionnaire (`nom`, `courriel`, `date`, `question1`, `question2`, `question3`) VALUES ('$nom', '$courriel', '$date', '$question1', '$question2', '$question3')";

				/* test insertion */
				if (mysqli_query($conn, $sql_insert)) {
					echo "Vos réponses ont bien été enregistrées.";
				} else {
					echo "Error : " . $sql_insert . "<br>" . mysqli_error($conn);
				}

				$sql_nb_correct1 = "SELECT * FROM id21044620_atcodb.questionnaire WHERE question1 = 'oui'";
				$res_nb_correct1 = mysqli_query($conn, $sql_nb_correct1);

				if (mysqli_num_rows($res_nb_correct1) > 0) {
					while($row = mysqli_fetch_assoc($res_nb_correct1)) {
						echo "<p>Personnes ayant répondu correctement à la première question : " . $row['nom'] . "</p>";
					}
				} else {
					echo "0 résultat";
				}
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
					<p><strong>Question 1 :</strong> la norme de séparation radar est-elle respectée entre le SWW264 et le DIFCB&nbsp;?</p>
					<p><img class="pastropgrand" src="illustrations/sepradar1.png" alt="image d’une séparation radar"></p>
					<p><input type="radio" name="question1" <?php if (isset($question1) && $question1=="oui") echo "checked";?> value="oui">oui
						<input type="radio" name="question1" <?php if (isset($question1) && $question1=="non") echo "checked";?> value="non">non</p>

					<?php
						if ($questionnaire_ok) {
							if ($question1 == $reponse1) {
								$score += 1;
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. ";
							}
							echo("Les deux avions sont à 2000ft (deuxième ligne de l’étiquette), mais ils sont séparés latéralement de 6,86NM. La norme est donc respectée.</p>");
						}
					?>

					<p><strong>Question 2 :</strong> concernant le vol TRA85N</p>
					<p><img class="pastropgrand" src="illustrations/strip_tra.png" alt="image d’un strip"></p>
					<p><input type="radio" name="question2" <?php if (isset($question2) && $question2=="transat") echo "checked";?> value="transat">Son indicatif est «&nbsp;Air Transat 85 Novembre&nbsp;» (<em>'Novembre' est le nom de la lettre 'N' dans l’alphabet aéronautique)</p>
					<p><input type="radio" name="question2" <?php if (isset($question2) && $question2=="B737") echo "checked";?> value="B737">Ce vol s’effectue dans un Boeing 737-800</p>
					<p><input type="radio" name="question2" <?php if (isset($question2) && $question2=="badod") echo "checked";?> value="badod">Il est à destination de Badod, en Inde</p>

					<?php
						if ($questionnaire_ok) {
							if ($question2 == $reponse2) {
								$score += 1;
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. ";
							}
							echo("'B738' est le code pour un Boeing 737 de la série 800. Son indicatif est «&nbsp;Transavia 85 Novembre&nbsp;», et sa destination Amsterdam (code EHAM). Badod est simplement le nom d’un point sur sa route.</p>");
						}
					?>

					<p><strong>Question 3 :</strong> le language utilisé par les pilotes et les contrôleurs pour communiquer entre eux s’appelle :</p>
					<p><input type="radio" name="question3" <?php if (isset($question3) && $question3=="communication non violente") echo "checked";?> value="communication non violente">la communication non violente</p>
					<p><input type="radio" name="question3" <?php if (isset($question3) && $question3=="standardisation") echo "checked";?> value="standardisation">la standardisation</p>
					<p><input type="radio" name="question3" <?php if (isset($question3) && $question3=="phraséologie") echo "checked";?> value="phraséologie">la phraséologie</p>
					<p><input type="radio" name="question3" <?php if (isset($question3) && $question3=="protocole TCP") echo "checked";?> value="protocole TCP">le protocole "transmission contrôleur-pilote"</p>

					<?php
						if ($questionnaire_ok) {
							if ($question3 == $reponse3) {
								$score += 1;
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. La bonne réponse est «&nbsp;la phraséologie&nbsp». ";
							}
							echo("Le protocole 'TCP' n’est pas d’une grande utilité dans ce contexte... La communication non violente, elle, gagnerait à être plus connue.</p>");
						}
					?>

					<p><strong>Question 4 :</strong> le vol EZY51NM a été autorisé à descendre vers </p>
					<p><img class="pastropgrand" src="illustrations/strip_ezy.png" alt="image d’un strip"></p>
					<p><input type="radio" name="question4" <?php if (isset($question4) && $question4=="6360") echo "checked";?> value="6360">une altitude de 6360ft</p>
					<p><input type="radio" name="question4" <?php if (isset($question4) && $question4=="5000") echo "checked";?> value="5000">une altitude de 5000ft</p>
					<p><input type="radio" name="question4" <?php if (isset($question4) && $question4=="110") echo "checked";?> value="110">un niveau de vol 110 (environ 11000ft)</p>

					<?php
						if ($questionnaire_ok) {
							if ($question4 == $reponse4) {
								$score += 1;
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. Il est autorisé à descendre à 5000ft. ";
							}
							echo("'6360' correspond à un code transpondeur, c’est un nombre détecté par le radar qui permet à ce dernier d’identifier le vol ; '110' est un cap magnétique (la direction à prendre par rapport à la rose des vents).</p>");
						}
					?>

					<p><strong>Question 5 :</strong> la norme de séparation radar est-elle respectée entre le DLH11P et le EZY34XF&nbsp;?</p>
					<p><img class="pastropgrand" src="illustrations/sepradar2.png" alt="image d’une séparation radar"></p>
					<p><input type="radio" name="question5" <?php if (isset($question5) && $question5=="oui") echo "checked";?> value="oui">oui
						<input type="radio" name="question5" <?php if (isset($question5) && $question5=="non") echo "checked";?> value="non">non</p>

					<?php
						if ($questionnaire_ok) {
							if ($question5 == $reponse5) {
								$score += 1;
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. ";
							}
							echo("Les deux avions sont séparés latéralement de seulement 2,26NM, cependant, le premier est à 900ft, tandis que le deuxième est à un niveau 110 (environ 11000ft), plus de 10000ft les séparent. C’était un piège, en réalité on est large&nbsp;!</p><p><strong>Votre score est de $score sur 5.</strong></p>");
						} else {
							// Le bouton disparaît après la première tentative
							echo('<p><input type="submit" value="Vérifier mes réponses"></p>'); 
						}
					?>

				</div>
			</form>
		</section>
	</body>
