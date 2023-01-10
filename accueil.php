<?php session_start();

ini_set("display_errors", "1");
function liste_mois($m) {
  $tab = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", 
  "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
  echo "<select name='months' id='month-select'>";
  for ($k = 0; $k < 12; ++$k) {
    if ($k == $m - 1) {
      echo "<option value = '$tab[$k]' selected>";
      echo $tab[$k];
      echo "</option>";
    } else {
      echo "<option value='$tab[$k]'>";
      echo $tab[$k];
      echo "</option>";
    }
  }
  echo "</select>";
}
?>

<!DOCTYPE html>

<html lang="fr">
  <head>
    <title>Agenda</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/accueil.css" />
    <script src="js/horloge_dynamique.js"></script>
    <script src="js/calendrier.js"></script>
  </head>

  <body>

    <nav>
      <img src="images/logo_site.jpg" alt="Logo" /> <br />
      <?php
        if (!isset($_SESSION['pseudo'])){
          echo "<a href='connexion.php'>Connexion</a>\n";
          echo "<a href='inscription.php'>Inscription</a>\n";
        } else {
          echo "Bienvenue <a href='profil.php'><span class='pseudo_session'>
          {$_SESSION['pseudo']}</span></a><br> <form action ='deconnexion.php'>
          <button type='submit'> Déconnexion</button>
          </form>";
          echo "<br><a href='ajout_events.php'>Ajouter un événement</a>";
        }
      ?>
      <p id="heure">
        <script> heure(); </script>
      </p>
    </nav>

    <div class="calendrier">
      <input type ="submit" id ="prev" name="prev" value="Précédent"/>
      <?php
        $m = date("m");
        liste_mois($m);
      ?>
      <input type ="number" id="annee" name="annee" 
      value ="<?php echo date("Y"); ?>"/>
      <input type ="submit" id="confirm" name="confirm" value="Confirmer"/>
      <input type="submit" id ="next" name="next" value="Suivant"/>
		

      <p id ="calendar"> </p>
        <input type="submit" id ="now" name="now" 
        value="Retour au mois courant"/>
      <?php include('style_event.php'); ?>

      <p id ="ferie"></p>
			  <?php
          include('affiche_event.php');
          if (isset($_SESSION['affiche-mois']) 
            && isset($_SESSION['affiche-annee'])) {
            $affiche_mois = $_SESSION['affiche-mois'] + 0;
            $affiche_annee = $_SESSION['affiche-annee'];
            $affiche = $_SESSION['affiche'];
            echo "<input type ='hidden' id='affichem' name='affiche-mois' 
            value=$affiche_mois>";
            echo "<input type ='hidden' id='affichea' name='affiche-annee' 
            value=$affiche_annee>";
            echo "<input type ='hidden' id='affiche' name='affiche' 
            value=$affiche>";
          }
			  ?>

			<script>

				//~ //création de variables contenant le jour, le mois et l'année courants
				var affiche = document.getElementById('affiche');
				if (affiche != null && affiche.value != 0) {
					var month = document.getElementById('affichem').value;
					var year = document.getElementById('affichea').value;
					var date = new Date();
				  } else {
					var date = new Date();
					var day = date.getDate();
					var month = date.getMonth() + 1;
					var year = date.getFullYear();
				 }
      </script>




      <?php
        if (isset($_SESSION['couleur'])) {
          $couleur = $_SESSION['couleur'];
        } else {
          $couleur = "neutre";
        }
        echo  "<input type ='hidden' id='confirm-color' name='confirm-color'
         value=$couleur>";

        if (isset($_SESSION['style'])) {
          $style = $_SESSION['style'];
        } else {
          $style = "";
        }
        echo "<input type ='hidden' id='underline' name='underline' 
        value='underline'/>";
        echo  "<input type ='hidden' id='style' name='style' value=$style >";

        if (isset($_SESSION['pays'])) {
          $pays = $_SESSION['pays'];
          echo "<input type='hidden' id='pays' name='pays' value=$pays />";
        }

      ?>



      <script src="js/nav_calendrier.js">
      </script>
    </div>
	
    <?php include('liste_events.php'); ?>

    <?php unset($_SESSION['id_event']); ?>
  
    <footer>
    </footer>
  </body>
</html>
