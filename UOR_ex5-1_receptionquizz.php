<!DOCTYPE html>
<html lang="fr">
  	<head>
    	<title>Contrôleur aérien</title>
    	<meta charset="utf-8">
    	<link rel="stylesheet" type="text/css" href="style.css">
    	<meta name="description" content="Un quizz pour tester sa compréhension du contrôle aérien et de ses outils. Réalisé dans le cadre du cours 'Utilisation d’Ordinateurs en Réseau' de P. Kislin">
    	<meta name="url" content="atco.000webhostapp.com/receptionquizz.php">
    	<meta name="author" content="OD">
    	<meta name="keywords" content="contrôle aérien, contrôleur aérien, aiguilleurs du ciel, ICNA, ATCO, navigation aérienne, DGAC">
  	</head>
  	<body>
  		<h1>L’heure du quizz</h1>
  		<p><blockquote class="citation">Qualifié&nbsp;!</blockquote></p>

<!--La barre de navigation-->
  		<ul class="navbar">
			<li class="l"><a href="index.html">Accueil JS</a></li>
			<li class="l"><a href="avecstyle.html">Accueil CSS</a></li>
			<li class="l"><a href="htmlnu.html">Accueil HTML</a></li>
			<li class="r"><a class="active"  href="quizz.html">Quizz</a></li>
		</ul>

<!--Traitement des réponses au questionnaire-->
		<?php 
			$nomErr = $courrielErr = $dateErr = "";
	  		$nom = $courriel = $date = "";
	  		$obl = "champs obligatoire";
	  		$nom_questions = array("question1", "question2", "question3", "question4", "question5"); // vecteur des noms des questions
	  		$rep_user = array(); // vecteur des réponses de l’utilisateur
	  		$rep_correctes = array("oui", "B737", "phraséologie", "5000", "oui"); // vecteur des réponses justes
	  		$resultats_user = array(); // vecteur de 0 ( si rep juste) et 1 (si faute)
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

			/* Vérification de la validité des réponses, affichage des erreurs le cas échéant */
			// nom
			if (empty($_POST['nom'])) {
				$nomErr = $obl;
			} else {
				$nom = nettoyer($_POST['nom']);
				// vérifie si nom contient seulement lettres, chiffres et espaces
				if (!preg_match("/^[0-9a-zA-Z- Ééèô]*$/",$nom)) {
  				$nomErr = "seulement lettres, chiffres et espaces autorisés";
  				}
			} 

			// courriel
			if (!empty($_POST['courriel'])) {
				$courriel = nettoyer($_POST['courriel']);
				if ((!filter_var($courriel, FILTER_VALIDATE_EMAIL)) || (preg_match("/'/", $courriel))) {
  				$courrielErr = "adresse non valide";
				}
			} 

			// date - si date entrée, vérifie son format ; sinon date = date du jour
			date_default_timezone_set("Europe/Paris");
  			if(!empty($_POST['date'])) {
  				$date = $_POST['date'];
  				if (!validateDate($date)) {
  				$dateErr = "date non valide";
  				}
  			} else {
  				$date = date('d/m/Y');
  			}

  			// remplissage de l’arrays 'rep_user' avec les réponses de l’utilisateur, "" si pas répondu
  			for ($i = 0; $i < 5; $i++) {
  				if (!empty($_POST[$nom_questions[$i]])) {
  					array_push($rep_user, $_POST[$nom_questions[$i]]);
  				} else {
  					array_push($rep_user, "");
  				}
  			}

  			// remplissage de l’array 'resultats_user' avec 0 si rep fausse, 1 sinon
  			for ($i = 0; $i < 5; $i++) {
  				if ($rep_user[$i] == $rep_correctes[$i]) {
  					array_push($resultats_user, 1);
  				} else {
  					array_push($resultats_user, 0);
  				}
  			}

  			// score de l’utilisateur
  			$score_user = array_sum($resultats_user);

  			/* Vérification que nom, courriel et date sont bien remplis (pour affichage réponses) */
  			if ($nomErr == "" && $courrielErr == "" && $dateErr == "") {
  				$questionnaire_ok = TRUE;
  			}

  		?>

<!--Accès à la base de données-->
		<?php

		/* MySQLi */
			if ($questionnaire_ok) {
				// connection bdd
				$conn = mysqli_connect("localhost", "id21044620_atco", "icna11b@Nice", "id21044620_atcodb");
				// test connection
				if (!$conn) {
					die("Connection failed : " . mysqli_connect_error());
				}

				// insertion réponses questionnaire dans bdd
				$sql_insert = "INSERT INTO id21044620_atcodb.questionnaire (`nom`, `courriel`, `date`, `question1`, `question2`, `question3`, `question4`, `question5`, `res1`, `res2`, `res3`, `res4`, `res5`) VALUES ('$nom', '$courriel', '$date', '$rep_user[0]', '$rep_user[1]', '$rep_user[2]', '$rep_user[3]', '$rep_user[4]', '$resultats_user[0]', '$resultats_user[1]', '$resultats_user[2]', '$resultats_user[3]', '$resultats_user[4]')";

				/* test insertion */
				if (mysqli_query($conn, $sql_insert)) {
					echo $nom . ", vos réponses ont bien été enregistrées.";
				} else {
					echo "Error : " . $sql_insert . "<br>" . mysqli_error($conn);
				} 

				// récupération du nombre de lignes dans la table
				$sql_nb_participants = "SELECT COUNT(`clef`) FROM id21044620_atcodb.questionnaire";
				$nb_participants = mysqli_fetch_row(mysqli_query($conn, $sql_nb_participants))[0];
			}
			
		?>

<!--Le questionnaire + affichage réponses-->
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
					<p><input type="radio" name="question1" <?php if (isset($rep_user[0]) && $rep_user[0]=="oui") echo "checked";?> value="oui">oui
						<input type="radio" name="question1" <?php if (isset($rep_user[0]) && $rep_user[0]=="non") echo "checked";?> value="non">non</p>

					<?php
						// affichage réponse si nom, courriel et date remplis correctement
						if ($questionnaire_ok) {
							// si bonne réponse
							if ($resultats_user[0]==1) {
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. ";
							}
							echo("Les deux avions sont à 2000ft (deuxième ligne de l’étiquette), mais ils sont séparés latéralement de 6,86NM. La norme est donc respectée.</p>");

							// affichage pourcentage bonne réponse à la question
							$sql_nb_res1_correct = "SELECT SUM(`res1`) FROM id21044620_atcodb.questionnaire";
							$nb_res1_correct = mysqli_fetch_row(mysqli_query($conn, $sql_nb_res1_correct))[0];
							echo "<p>" . round($nb_res1_correct/$nb_participants*100) . "&#37; des participants ont répondu correctement à cette question.</p>";
						}

					?>

					<p><strong>Question 2 :</strong> concernant le vol TRA85N</p>
					<p><img class="pastropgrand" src="illustrations/strip_tra.png" alt="image d’un strip"></p>
					<p><input type="radio" name="question2" <?php if (isset($rep_user[1]) && $rep_user[1]=="transat") echo "checked";?> value="transat">Son indicatif est «&nbsp;Air Transat 85 Novembre&nbsp;» (<em>'Novembre' est le nom de la lettre 'N' dans l’alphabet aéronautique)</em></p>
					<p><input type="radio" name="question2" <?php if (isset($rep_user[1]) && $rep_user[1]=="B737") echo "checked";?> value="B737">Ce vol s’effectue dans un Boeing 737-800</p>
					<p><input type="radio" name="question2" <?php if (isset($rep_user[1]) && $rep_user[1]=="badod") echo "checked";?> value="badod">Il est à destination de Badod, en Inde</p>

					<?php
						if ($questionnaire_ok) {
							if ($resultats_user[1]==1) {
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. ";
							}
							echo("'B738' est le code pour un Boeing 737 de la série 800. Son indicatif est «&nbsp;Transavia 85 Novembre&nbsp;», et sa destination Amsterdam (code EHAM). Badod est simplement le nom d’un point sur sa route.</p>");

							// affichage pourcentage bonne réponse à la question
							$sql_nb_res2_correct = "SELECT SUM(`res2`) FROM id21044620_atcodb.questionnaire";
							$nb_res2_correct = mysqli_fetch_row(mysqli_query($conn, $sql_nb_res2_correct))[0];
							echo "<p>" . round($nb_res2_correct/$nb_participants*100) . "&#37; des participants ont répondu correctement à cette question.</p>";
						}
					?>

					<p><strong>Question 3 :</strong> le language utilisé par les pilotes et les contrôleurs pour communiquer entre eux s’appelle :</p>
					<p><input type="radio" name="question3" <?php if (isset($rep_user[2]) && $rep_user[2]=="communication non violente") echo "checked";?> value="communication non violente">la communication non violente</p>
					<p><input type="radio" name="question3" <?php if (isset($rep_user[2]) && $rep_user[2]=="standardisation") echo "checked";?> value="standardisation">la standardisation</p>
					<p><input type="radio" name="question3" <?php if (isset($rep_user[2]) && $rep_user[2]=="phraséologie") echo "checked";?> value="phraséologie">la phraséologie</p>
					<p><input type="radio" name="question3" <?php if (isset($rep_user[2]) && $rep_user[2]=="protocole TCP") echo "checked";?> value="protocole TCP">le protocole "transmission contrôleur-pilote"</p>

					<?php
						if ($questionnaire_ok) {
							if ($resultats_user[2]==1) {
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. La bonne réponse est «&nbsp;la phraséologie&nbsp». ";
							}
							echo("Le protocole 'TCP' n’est pas d’une grande utilité dans ce contexte... La communication non violente, elle, gagnerait à être plus connue.</p>");

							// affichage pourcentage bonne réponse à la question
							$sql_nb_res3_correct = "SELECT SUM(`res3`) FROM id21044620_atcodb.questionnaire";
							$nb_res3_correct = mysqli_fetch_row(mysqli_query($conn, $sql_nb_res3_correct))[0];
							echo "<p>" . round($nb_res3_correct/$nb_participants*100) . "&#37; des participants ont répondu correctement à cette question.</p>";
						}
					?>

					<p><strong>Question 4 :</strong> le vol EZY51NM a été autorisé à descendre vers </p>
					<p><img class="pastropgrand" src="illustrations/strip_ezy.png" alt="image d’un strip"></p>
					<p><input type="radio" name="question4" <?php if (isset($rep_user[3]) && $rep_user[3]=="6360") echo "checked";?> value="6360">une altitude de 6360ft</p>
					<p><input type="radio" name="question4" <?php if (isset($rep_user[3]) && $rep_user[3]=="5000") echo "checked";?> value="5000">une altitude de 5000ft</p>
					<p><input type="radio" name="question4" <?php if (isset($rep_user[3]) && $rep_user[3]=="110") echo "checked";?> value="110">un niveau de vol 110 (environ 11000ft)</p>

					<?php
						if ($questionnaire_ok) {
							if ($resultats_user[3]==1) {
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. Il est autorisé à descendre à 5000ft. ";
							}
							echo("'6360' correspond à un code transpondeur, c’est un nombre détecté par le radar qui permet à ce dernier d’identifier le vol ; '110' est un cap magnétique (la direction à prendre par rapport à la rose des vents).</p>");

							// affichage pourcentage bonne réponse à la question
							$sql_nb_res4_correct = "SELECT SUM(`res4`) FROM id21044620_atcodb.questionnaire";
							$nb_res4_correct = mysqli_fetch_row(mysqli_query($conn, $sql_nb_res4_correct))[0];
							echo "<p>" . round($nb_res4_correct/$nb_participants*100) . "&#37; des participants ont répondu correctement à cette question.</p>";
						}
					?>

					<p><strong>Question 5 :</strong> la norme de séparation radar est-elle respectée entre le DLH11P et le EZY34XF&nbsp;?</p>
					<p><img class="pastropgrand" src="illustrations/sepradar2.png" alt="image d’une séparation radar"></p>
					<p><input type="radio" name="question5" <?php if (isset($rep_user[4]) && $rep_user[4]=="oui") echo "checked";?> value="oui">oui
						<input type="radio" name="question5" <?php if (isset($rep_user[4]) && $rep_user[4]=="non") echo "checked";?> value="non">non</p>

					<?php
						if ($questionnaire_ok) {
							if ($resultats_user[4]==1) {
								echo "<p class='jargon'>Bonne réponse ! ";
							} else {
								echo "<p class='erreur'>Perdu. ";
							}
							echo("Les deux avions sont séparés latéralement de seulement 2,26NM, cependant, le premier est à 900ft, tandis que le deuxième est à un niveau 110 (environ 11000ft), plus de 10000ft les séparent. C’était un piège, en réalité on est large&nbsp;!</p>"); 

							// affichage pourcentage bonne réponse à la question
							$sql_nb_res5_correct = "SELECT SUM(`res5`) FROM id21044620_atcodb.questionnaire";
							$nb_res5_correct = mysqli_fetch_row(mysqli_query($conn, $sql_nb_res5_correct))[0];
							echo "<p>" . round($nb_res5_correct/$nb_participants*100) . "&#37; des participants ont répondu correctement à cette question.</p><p><strong>Votre score est de $score_user sur 5.</strong></p>
								<p>" . $nb_participants . " personnes ont participé jusqu’à présent.";

						} else {
							// Le bouton "Vérifier mes réponses" disparaît après la première tentative
							echo('<p><input type="submit" value="Vérifier mes réponses"></p>'); 
						}
					?>

				</div>
			</form>
		</section>
	</body>
