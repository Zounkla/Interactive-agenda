<?php session_start(); ?>
<!DOCTYPE html>

<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/profil.css" />
		<title>Inscription</title>
	</head>

	<body>
		<header>
			<nav>
			<h1>Agenda</h1>
				<ul>
					<li><a href="accueil.php">Accueil</a></li>
				</ul>

			</nav>
		</header>

		<section>
			<h2>Formulaire d'inscription</h2>
			<form method="post" action="inscription.php">
				<p>
					<br>
					<label for="identifiant">Pseudo* : </label>
					<input type="text" name="pseudo" id="identifiant" maxlength='25' 
          required placeholder='25 caractères maximum'/>
					<br>
					<br>
					<label for="email">Email* : </label>
					<input type="email" name="mail" required id="email" />
					<br>
					<br>
					<label for="town">Ville : </label>
					<input type="text" name="ville" id="town" maxlength='60'
          placeholder='60 caractères maximum'/>
					<br>
					<br>
					<label for="country">Pays : </label>
					<select name="pays" id="country">
            <option value="fr">France</option>
            <option value="uk">United Kingdom</option>
            <option value="us">USA</option>
          </select>
					<br>
					<br>
					<label for="motdepasse">Mot de passe* : </label>
					<input type="password" name="mdp" id="motdepasse" 
          required maxlength='45' placeholder='45 caractères maximum'/>
					<br>
					<br>
					<label for="mdpverif">Confirmez le mot de passe* : </label>
					<input type="password" name="mdp_verif" id="mdpverif"
          required maxlength='45'/>
					<br>
					<br>
					Veuillez choisir un jeu de couleur pour l'affichage du calendrier :
					<select name="couleurs">
						<option value="neutre">Neutre</option>
						<option value="chaud">Tons chauds</option>
						<option value="froid">Tons froids</option>
					</select>
					<br>

					<input type="submit" value="S'inscrire" />
					<br>
					<p>Les champs marqués d'une * sont obligatoires</p>
				<p>
			</form>

      <?php
			if(isset($_REQUEST['pseudo']) and !empty($_REQUEST['pseudo']) 
      and isset($_REQUEST['mdp']) and !empty($_REQUEST['mdp']) 
      and isset($_REQUEST['mdp_verif']) and isset($_REQUEST['mail'])
      and !empty($_REQUEST['mail'])){
        $pseudo = htmlentities($_REQUEST['pseudo'], ENT_QUOTES);
				$mdp = htmlentities($_REQUEST['mdp'], ENT_QUOTES);
        $hash = password_hash($mdp, PASSWORD_DEFAULT);
				$mdp_verif = htmlentities($_REQUEST['mdp_verif'], ENT_QUOTES);
        $mdp_verif = password_verify($mdp_verif, $hash);
				$mail = $_REQUEST['mail'];

				//on vérifie le format de l'adresse mail
				$er = "/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$/i";
				if (!preg_match($er, $mail)) {
					echo "Cette adresse email n’est pas valide";
				}

				//on vérifie la concordance des mots de passe
				else if($mdp_verif != 1){
					echo "Mot de passe et confirmation de mot de passe différents, 
          veuillez saisir à nouveau votre mot de passe";
				} else {
					$mail = htmlentities($mail, ENT_QUOTES);
					include "connexion_base.php";
					$request1 = "SELECT * FROM profil";
					$res1 = $connexion->query($request1);

					$erreur_inscription = false;
					$lignes = $res1->fetchAll();
					foreach($lignes as $data) {
						if($pseudo == $data['pseudo'] || $mail == $data['mail']){
							$erreur_inscription = true;
						}
					}
					//si la variable erreur est définie à true on affiche le message d'erreur, cela signifie que les identifiants d'inscription sont utilisés
					if($erreur_inscription == true) {
						echo "Identifiant ou adresse mail déjà utilisé(e.s)<br>
            Veuillez réessayer avec de nouvelles données";
					} else {
					//sinon on entre les données dans la table en vérifiant les valeurs de champs Ville et Pays
						if(isset($_REQUEST['ville'])){
							$ville = htmlentities($_REQUEST['ville'], ENT_QUOTES);
						} else {
							$ville = "Non définie";
						}

						if(isset($_REQUEST['pays'])){
							$pays = htmlentities($_REQUEST['pays'], ENT_QUOTES);
						} else {
							$pays = "Non défini";
						}
						if (isset($_REQUEST['couleurs'])) {
							$couleur = $_REQUEST['couleurs'];
              $_SESSION['couleur'] = $couleur;
						}
						//valeur par défaut d'affichage de la plage d'événements paramétrée à 7
						$nombre_jours = 7;
            $mdp = $hash;
						$request2 = "INSERT INTO profil 
            (pseudo, mail, mdp, ville, pays, couleur, nombre_jours) VALUES  
            (:pseudo, :mail, :mdp, :ville, :pays, :couleur, :nombre_jours)";
						$res2 = $connexion->prepare($request2);
						$res2->bindParam(":pseudo", $pseudo);
						$res2->bindParam(":mail", $mail);
						$res2->bindParam(":mdp", $mdp);
						$res2->bindParam(":ville", $ville);
						$res2->bindParam(":pays", $pays);
						$res2->bindParam(":couleur", $couleur);
						$res2->bindParam(":nombre_jours", $nombre_jours);
						$res2->execute();
						//===  permet de distinguer false et 0
						if($res2 === false) {
							die("Erreur");
						} else {
							$_SESSION['couleur'] = $couleur;
							$_SESSION['pseudo'] = $pseudo;
              $_SESSION['pays'] = $pays;
							$request3 = "SELECT * FROM profil";
							$res3 = $connexion->query($request3);
							$lignes = $res3->fetchAll();
							foreach($lignes as $data) {
								if($pseudo == $data['pseudo']) {
									$_SESSION['numcompte'] = $data['id'];
								}
							}
							unset($res3);
							header("location:accueil.php");
							unset($res2);
						}
					}
					unset($connexion);
				}
			}
			?>
			<br>
			<br>
		</section>
		<!--Image en bas de page-->
		<footer>
		</footer>
	</body>

</html>
