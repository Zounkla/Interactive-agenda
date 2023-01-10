<?php session_start(); ?>
<!DOCTYPE html>

<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/profil.css" />
		<title>Connexion</title>
	</head>

	<body>
		<h1>Agenda</h1>

		<nav>
				<ul>
					<li><a href="accueil.php">Accueil</a></li>
				</ul>

		</nav>
		<h2>Formulaire de connexion</h2>
	<!--Formulaire de connexion-->
			<form method="post" action="connexion.php">
        Identifiez-vous: <br>
        <br>
        <label for='pseudomail'>Pseudo ou mail : </label>
        <input type="text" id='pseudomail' name="identifiant" /><br>
        <br>
        <label for='mot_de_passe'> Mot de passe : </label>
        <input type="password" name="mdp" id='mot_de_passe' /> <br>
        <br>
        <input type="submit" name='submit' value="Valider" />
				<p>
			</form>
      <?php
			if(isset ($_REQUEST["identifiant"]) and isset ($_REQUEST["mdp"]) 
        and isset ($_REQUEST['submit'])) {
          if(empty($_REQUEST["identifiant"]) || empty($_REQUEST["mdp"])) {
            echo "L'un des champs est vide, veuillez refaire votre saisie";
          } else {
            $id = htmlentities($_REQUEST["identifiant"], ENT_QUOTES);
            $mdp = htmlentities($_REQUEST["mdp"], ENT_QUOTES);
            $erreur = 0;
            $compte = 0;
            $pseudo = '';

            include "connexion_base.php";
            $requete = "SELECT * FROM profil where pseudo = :pseudo";
            $res = $connexion->prepare($requete);
            $res->bindParam(":pseudo", $id);
            $res->execute();
            while ($donnees = $res->fetch()){
              $hash = $donnees['mdp'];
              if($id === $donnees['mail'] && password_verify($mdp, $hash )) {
                $compte = 1;
                $pseudo = $donnees['pseudo'];
                $num_compte = $donnees['id'];
              }
              if ($id === $donnees['pseudo'] 
              &&  password_verify($mdp, $hash )) {
                $compte = 1;
                $num_compte = $donnees['id'];
              }
              if(($id === $donnees['mail'] || $id === $donnees['pseudo']) 
              && !(password_verify($mdp, $hash ))) {
                $erreur = 1;
              }
              if ($id != $donnees['pseudo']) {
                $erreur = 1;
              }
              $couleur = $donnees['couleur'];
              $style = $donnees['style'];
              $pays = $donnees['pays'];
            }   
            if($erreur === 1 || $compte === 0){
              echo "Identifiant et/ou mot de passe incorrect";
            }
            if($compte === 1 && $pseudo != '') {
              $_SESSION['pseudo'] = $pseudo;
              $_SESSION['pays'] = $pays;
              $_SESSION['couleur'] = $couleur;
              $_SESSION['style'] = $style;
              $_SESSION['numcompte'] = $num_compte;
              header("location:accueil.php");
            }
            if ($compte === 1) {
              $_SESSION['pseudo'] = $id;
              $_SESSION['pays'] = $pays;
              $_SESSION['couleur'] = $couleur;
              $_SESSION['style'] = $style;
              $_SESSION['numcompte'] = $num_compte;

              header("location:accueil.php");
            }
            unset($res);
            unset($connexion);

          }
        }
		?>
		<br>
		<br>
		<footer>
		</footer>
	</body>
</html>
