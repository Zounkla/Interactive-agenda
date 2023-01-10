<?php session_start();
if(!isset($_SESSION['pseudo'])) {
	header("location:accueil.php");
} 
?>


<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/profil.css" />
		<title>Profil</title>
	</head>

	<body>
		<header>
			<h1>Agenda</h1>
		<!--En-tête-->
      <div class='pseudo'>
        <?php
          if(isset($_SESSION['pseudo'])){
            echo "Bienvenue sur ton profil <span class='pseudo_session'>
            {$_SESSION['pseudo']}</span><br>";
            //echo "<a href='deconnexion.php'><button type='button'>Déconnexion</button></a>";
            echo "<form action ='deconnexion.php'>";
            echo "<button type='submit'> Déconnexion</button>";
            echo "</form>";
          }
        ?>
      </div>

		<!--Liens pour faciliter l'accès aux différentes parties du site-->
			<nav>
				<ul>
					<li><a href="accueil.php">Accueil</a></li>

				</ul>

			</nav>
		</header>

    <form method='post'>
      <label for='pseudo'>Changer de nom d'utilisateur : </label>
      <input type='text' id='pseudo' name='id' maxlength='25' 
      placeholder='25 caractères maximum' /> <br>
      <br>
      <label for='old_mdp'>Ancien mot de passe : </label>
      <input type='password' id='old_mdp' name='ancien_mdp' /> <br>
      <br>
      <label for='new_mdp'>Nouveau mot de passe : </label>
      <input type='password' id='new_mdp' name='nouv_mdp' /> <br>
      <br>
      <label for="email">Changer votre adresse email : </label>
      <input type="text" name="mail" id="email" />
      <br>
      <br>
      <label for='town'>Changer de ville : </label>
      <input type='text' id='town' name='ville' maxlength='25'
       placeholder='25 caractères maximum' /> <br>
      <br>
      <label for="country">Changer de pays : </label>

      <?php
        include "connexion_base.php";
        $pseudo = $_SESSION['pseudo'];
        $requete = "SELECT pays FROM profil";
        $res = $connexion->query($requete);
        $lignes = $res->fetchAll();
        $k = 0;
        foreach($lignes as $data){
          if ($data['pays'] === 'uk') {
            $k = 1;
          } else if ($data['pays'] === 'us') {
            $k = 2;
          }
        }
        if ($k === 0) {
          echo '<select name="pays" id="country">
            <option value="fr">France</option>
            <option value="uk">United Kingdom</option>
            <option value="us">USA</option>
          </select>';
        } else if ($k === 1) {
          echo '<select name="pays" id="country">
            <option value="fr">France</option>
            <option value="uk" selected>United Kingdom</option>
            <option value="us">USA</option>
          </select>';
        } else {
          echo '<select name="pays" id="country">
            <option value="fr">France</option>
            <option value="uk">United Kingdom</option>
            <option value="us" selected>USA</option>
          </select>';
        }
        ?>
				<br>

				<p>Modifier le jeu de couleur pour l'affichage du calendrier :
					<select name="couleurs">
						<option value="none"> -</option>
						<option value="neutre">Neutre</option>
						<option value="chaud">Tons chauds</option>
						<option value="froid">Tons froids</option>
					</select> </p>
				<br>
				<input type='submit' value='Valider' name='submit'/> <br>

			</form>

			<form method="post">
				<p>Choisir la plage d'événements à afficher :
					<input type="number" name="jour" value="7" min="1" max="366" step="1"/>
					<input type="submit" value="Entrer" name='submit2'/>
				</p>
			</form>
			<br>

      <form method="post">
				<p>Choisir le style des événements :
					<select name="style">
            <option value = "underline">Souligné</option>
            <option value = "wavy">Vagues</option>
            <option value = "dotted">Pointillés</option>
            <option value = "overline">Encadré</option>
          </select>
          <input type="submit" value="Entrer" name='submit3'/>
          

				</p>
			</form>
			<br>



			<?php
			if(isset($_REQUEST['submit'])){
				include "connexion_base.php";
				$pseudo = $_SESSION['pseudo'];
				// on cherche à changer le pseudo tout en vérifiant si un tel pseudo n'est pas déjà utilisé
				if(isset($_REQUEST['id']) and !empty($_REQUEST['id'])){
					$id = htmlentities($_REQUEST['id'], ENT_QUOTES);
					$requete = "SELECT pseudo FROM profil";
					$res = $connexion->query($requete);
					$erreur_inscription = false;
					$lignes = $res->fetchAll();
					foreach($lignes as $data){
						if($id == $data['pseudo']){
							$erreur_inscription = true;
						}
					}
					//si la variable erreur est définie à true on affiche le message d'erreur
					if($erreur_inscription == true) {
						echo "Pseudo déjà utilisé<br>
            Veuillez réessayer avec de nouvelles données</br>";
					} else {
					//sinon on entre les données dans la table

						$request2 = "UPDATE profil SET pseudo= :id WHERE pseudo= :pseudo";
						$res2 = $connexion->prepare($request2);
						$res2->bindParam(":id", $id);
						$res2->bindParam(":pseudo", $pseudo);
						$res2->execute();
						if(!$res2) {
							die('Erreur');
						}else{
							echo "Mise à jour effectuée, vous portez maintenant le pseudo $id !</br>";
							$_SESSION['pseudo'] = $id;
							$pseudo = $id;
						}
            unset($res2);
          }
				}

				// on cherche à changer le mail tout en vérifiant si une telle adresse n'est pas déjà utilisée
				if(isset($_REQUEST['mail']) and !empty($_REQUEST['mail'])){
					$mail = $_REQUEST['mail'];
					//on vérifie le format de l'adresse mail
					$er = "/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$/i";
					if (!preg_match($er, $mail)) {
						echo "Cette adresse email n’est pas valide<br>";
						$erreur_inscription = true;
					} else {

            $requete = "SELECT mail FROM profil";
            $res = $connexion->query($requete);
            $erreur_inscription = false;
            $lignes = $res->fetchAll();
            foreach($lignes as $data){
              if($mail == $data['mail']){
                $erreur_inscription = true;
              }
            }
          }
					//si la variable erreur est définie à true on affiche le message d'erreur
					if($erreur_inscription == true) {
						echo "Adresse mail déjà utilisée<br>
            Veuillez réessayer avec de nouvelles données</br>";
					} else {
					//sinon on entre les données dans la table
						$pseudo = $_SESSION['pseudo'];
						$request2 = "UPDATE profil SET mail= :mail WHERE pseudo= :pseudo";
						$res2 = $connexion->prepare($request2);
						$res2->bindParam(":mail", $mail);
						$res2->bindParam(":pseudo", $pseudo);
						$res2->execute();
						if(!$res2) {
							die('Erreur');
						}else{
							echo "Mise à jour effectuée, vous pouvez maintenant vous connecter
               avec cette adresse $mail !</br>";
						}
            unset($res2);
          }
				}
				//si l'utilisateur cherche à changer son mot de passe
				if(isset($_REQUEST['ancien_mdp']) and isset($_REQUEST['nouv_mdp']) 
        and !empty($_REQUEST['ancien_mdp']) and !empty($_REQUEST['nouv_mdp'])){
					$old_mdp = htmlentities($_REQUEST['ancien_mdp'], ENT_QUOTES);
					$new_mdp = htmlentities($_REQUEST['nouv_mdp'], ENT_QUOTES);
					$erreur_mdp = false;
					$changement_mdp = false;
					$requete = "SELECT mdp FROM profil ";
					$res = $connexion->query($requete);

					//on cherche dans la base son ancien mot de passe pour l'actualiser
					$lignes = $res->fetchAll();
					$n = 0;
					foreach($lignes as $data) {
            $hash = $data['mdp'];
						if (password_verify($old_mdp, $hash)) {
							$request2 = "UPDATE profil SET mdp= :new_mdp 
              WHERE pseudo= :pseudo and mdp= :old_mdp";
							$res2 = $connexion->prepare($request2);
              $new_mdp = password_hash($new_mdp, PASSWORD_DEFAULT);
							$res2->bindParam(":new_mdp", $new_mdp);
							$res2->bindParam(":pseudo", $pseudo);
							$res2->bindParam(":old_mdp", $hash);
							$res2->execute();
							if(!$res2){
								die('Erreur');
							} else {
								if ($n == 0) {
									echo "Mise à jour effectuée, votre mot de passe a 
                  bien été modifié</br>";
									++$n;
									$changement_mdp = true;
								}
							}
						} else {
							$erreur_mdp = true;
						}
            unset($res2);
					}
					if(($erreur_mdp == true) and ($changement_mdp == false)) {
						echo "Mot de passe incorrect, veuillez réessayer</br>";
					}
        }




				//Si l'utilisateur souhaite changer le jeu de couleurs du calendrier :
          if(isset($_REQUEST['couleurs'])) {
            $couleur = $_REQUEST['couleurs'];
            if($couleur != "none") {
              $request3 = "UPDATE profil SET couleur= :couleur 
              WHERE pseudo= :pseudo";
              $res3 = $connexion->prepare($request3);
              $res3->bindParam(":couleur", $couleur);
              $res3->bindParam(":pseudo", $pseudo);
              $res3->execute();
              if(!$res3){
                die('Erreur');
              } else {
                $_SESSION['couleur'] = $couleur;
                echo "Mise à jour effectuée, les couleurs
                ont bien été changées</br>";
              }
            }
            unset($res3);
          }
          





        
    // si l'utilisateur cherche à modifier sa ville

        if (isset($_REQUEST['ville']) && !empty($_REQUEST['ville'])) {
          include "connexion_base.php";
          $ville = $_REQUEST['ville'];
          $ville = htmlentities($ville, ENT_QUOTES);
          $pseudo = $_SESSION['pseudo'];
          $request = "UPDATE profil SET ville= :ville WHERE pseudo= :pseudo";
          $res4 = $connexion->prepare($request);
          $res4->bindParam(":ville", $ville);
          $res4->bindParam(":pseudo", $pseudo);
          $res4->execute();
					if(!$res4) {
						die('Erreur');
					}else{
						echo "Mise à jour effectuée !</br>";
					}
          unset($res4);
        }

      // si l'utilisateur cherche à modifier son pays

        if (isset($_REQUEST['pays'])) {
          include "connexion_base.php";
          $pays = $_REQUEST['pays'];
          $requete = "SELECT pays FROM profil";
          $res = $connexion->query($requete);
          $lignes = $res->fetchAll();
          $p = -1;
          $k = 0;
          foreach($lignes as $data){
            if ($data['pays'] === 'uk') {
              $k = 1;
            } else if ($data['pays'] === 'us') {
              $k = 2;
            }
          }
          if ($pays === 'fr') {
            $p = 0;
          } else if ($pays === 'uk') {
            $p = 1;
          } else {
            $p = 2;
          }
          $pseudo = $_SESSION['pseudo'];
          if ($k != $p) {
            $request = "UPDATE profil SET pays= :pays WHERE pseudo= :pseudo";
            $res5 = $connexion->prepare($request);
            $res5->bindParam(":pays", $pays);
            $res5->bindParam(":pseudo", $pseudo);
            $res5->execute();
            if(!$res5) {
              die('Erreur');
            }else{
              $_SESSION['pays'] = $pays;
              echo "Mise à jour effectuée !</br>";
              header("Refresh: 2; URL=profil.php");
            }
            unset($res5);
          }
        }




				unset($connexion);
			}

			if(isset($_REQUEST['submit2'])) {
				include "connexion_base.php";
				$pseudo = $_SESSION['pseudo'];
				//Modification de la plage d'affichage des événements dans la base
				$jours = $_REQUEST['jour'];
				$request = "UPDATE profil SET nombre_jours= :jours 
        WHERE pseudo= :pseudo";
        $res2 = $connexion->prepare($request);
        $res2->bindParam(":jours", $jours);
					$res2->bindParam(":pseudo", $pseudo);
					$res2->execute();
					if(!$res2) {
						die('Erreur');
					}else{
						echo "Mise à jour effectuée, vous pouvez maintenant afficher les événements de ces $jours prochains jours !</br>";
					}
				unset($res2);
			}

      if(isset($_REQUEST['submit3'])) {
				include "connexion_base.php";
				$pseudo = $_SESSION['pseudo'];
				//Modification du style des événements dans la base
				$style = $_REQUEST['style'];
				$request = "UPDATE profil SET style= :style WHERE pseudo= :pseudo";
        $res3 = $connexion->prepare($request);
        $res3->bindParam(":style", $style);
        $res3->bindParam(":pseudo", $pseudo);
        $res3->execute();
        if(!$res3) {
          die('Erreur');
        }else{
          $_SESSION['style'] = $style;
          echo "Mise à jour effectuée !</br>";
        }
				unset($res3);
			}






			?>





			<form method='post' action='profil.php'>
				<input type='submit' value='Supprimer le compte' name='sup_compte' />
			</form>


			<?php
			// dans le cas où l'utilisateur souhaite supprimer son compte
			ini_set('display_errors', 1);
      if(isset($_REQUEST['sup_compte'])){
					//on lui propose de confirmer sa décision, évitant ainsi les suppressions involontaires
        echo "<form method='post' action='profil.php'>
          <p>Etes-vous sûr de vouloir supprimer votre compte ?
            OUI<input type='radio' name='choix' value='oui' />
            NON<input type='radio' name='choix' value='non' /></p>
          <p><input type='submit' name='submit' value='Valider' /></p>
        </form>";

				}
				if(isset($_REQUEST['choix'])) {
					//on étudie la réponse apportée par l'utilisateur
          switch($_REQUEST['choix']) {
							//si l'utilisateur s'est rétracté, on lui signale que l'opération a été annulée
            case "non" :
              echo "Aucun changement n'a été apporté";
              break;
            case "oui":
							//s'il confirme, on lui demande par sécurité son mot de passe
              echo "<form method='post'><p><label for='mdp_conf'>
              Veuillez confirmer en saisissant votre mot de passe : </label>
                <input type='password' id='mdp_conf' name='confirm_mdp' /></p>
                <input type='submit' value='Valider'/></form>";
              break;
          }
				}
				if (isset($_REQUEST['confirm_mdp'])) {
					include "connexion_base.php";
					//on vérifie donc que le mot de passe est bon
					$request_verif = "SELECT * from profil WHERE pseudo= :pseudo";
					$res_verif = $connexion->prepare($request_verif);
					$s = $_SESSION['pseudo'];
					$res_verif->bindParam(":pseudo", $s);
					$res_verif->execute();
					$lignes = $res_verif->fetchAll();
					foreach ($lignes as $data) {
            $hash = $data['mdp'];
            $confirm = htmlentities($_REQUEST['confirm_mdp'], ENT_QUOTES);
						//si c'est le cas, on exécute la requête et on supprime le compte après avoir supprimé les événements associés
						if(password_verify($confirm, $hash)) {
							if (!isset($_SESSION['numcompte'])) {
								echo "Erreur lors de la supression";
								header("Refresh: 3; URL=profil.php");
							} else {
								//on supprime les événements associés au profil
								$id_compte = $_SESSION['numcompte'];
								$request_pre_delete = "DELETE FROM events WHERE id_compte=:id_compte";
								$res_pre_delete = $connexion->prepare($request_pre_delete);
								$res_pre_delete->bindParam(":id_compte", $id_compte);
								$res_pre_delete->execute();
								//puis le profil dans la base
								$request3 = "DELETE FROM profil WHERE pseudo= :pseudo";
								$res3 = $connexion->prepare($request3);
								$res3->bindParam(":pseudo", $s);
								$res3->execute();
								if(!$res3){
									die('Erreur');
								} else {
                  echo "Compte supprimé";
                  session_destroy();
                  header("location:accueil.php");
                }
							}
							//sinon on lui signale une erreur de mot de passe
						} else {
              echo "Mot de passe incorrect";
            }
          }
          unset($res_verif);
          unset($res3);
          unset($connexion);
        }
      ?>
	</body>
</html>
