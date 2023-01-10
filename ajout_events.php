<?php session_start() ;

if(!isset($_SESSION['pseudo'])) {
	header("location:accueil.php");
}?>

<!DOCTYPE html>

<html lang="fr">
  <head>
    <title>Ajout d'événements</title>
    <meta charset="utf-8"/>
	<link rel="stylesheet" href="css/event.css" />

  </head>

  <body>
    <nav>
      <h1>Ajout d'événements à l'agenda</h1>
      <a href="accueil.php">Retour à l'accueil</a>
    </nav>
    <form method="post">
      <p>
        Nom :
        <input type="text" name="nom" maxlength="50" required /> <br/>
        <br>
        Description :
        <input type="text" name="desc" maxlength="500" required /><br/>
        <br>
        Localisation :
        <input type="text" name="lieu" maxlength="100" required /><br/>
        <br>
        <?php 
          if (!(isset($_GET['jour']) && isset($_GET['mois']) 
          && isset($_GET['annee']))) {
            echo "Date de début : ";
            echo '<input type="date" name="date_déb" required /><br/>';
            echo '<br/>';
          } else {
            $jour = $_GET['jour'];
            $mois = $_GET['mois'];
            $annee = $_GET['annee'];
            $date_debut = "$annee-$mois-$jour";
            echo "Date de début : ";
            echo "<input type='date' name='date_déb' value='$date_debut'/>
            <br/>";
            echo '<br/>';
          }
        ?>
        Heure de début :
        <input type="time" name="heure_déb" required /><br/>
        <br>
        Date de fin :
        <input type="date" name="date_fin" required /><br/>
        <br>
        Heure de fin :
        <input type="time" name="heure_fin" required /><br/>
        <br>
        <input type="submit" name="submit" value="Ajouter" />
        </p>
      </form>

      <?php
      include "connexion_base.php";

      if(isset($_REQUEST['submit'])){
        $nom = htmlentities($_REQUEST['nom'], ENT_QUOTES);
        $desc = htmlentities($_REQUEST['desc'], ENT_QUOTES);
        $lieu = htmlentities($_REQUEST['lieu'], ENT_QUOTES);
        $date_debut = $_REQUEST['date_déb'];
        $heure_debut = $_REQUEST['heure_déb'];
        $heure_fin = $_REQUEST['heure_fin'];
        $date_fin = $_REQUEST['date_fin'];
        $diffdate = strtotime($date_fin) - strtotime($date_debut);
        $diffdate = $diffdate / 60 / 60 / 24;
        
        $diffheure = strtotime($heure_fin) - strtotime($heure_debut);
        $diffheure = $diffheure / 3600;
        if ($diffdate < 0 || ($diffdate == 0 && $diffheure < 0)) {
          echo "<p class='error'>
          Erreur ! Date de fin inférieure à la date de début\n
          </p>";
        } else {
          $id_compte = $_SESSION['numcompte'];

          $sql = "INSERT INTO events(nom, localisation, description, id_compte, 
          date_debut, date_fin, diffdate, heure_debut, heure_fin)
          VALUES(:nom, :localisation, :description, :id_compte, :date_debut, 
          :date_fin, :diffdate, :heure_debut, :heure_fin)";


          $reqprep = $connexion->prepare($sql);
          $reqprep->bindParam(":nom", $nom);
          $reqprep->bindParam(":localisation", $lieu);
          $reqprep->bindParam(":description", $desc);
          $reqprep->bindParam(":id_compte", $id_compte);
          $reqprep->bindParam(":date_debut", $date_debut);
          $reqprep->bindParam(":date_fin", $date_fin);
          $reqprep->bindParam(":diffdate", $diffdate);

          $reqprep->bindParam(":heure_debut", $heure_debut);
          $reqprep->bindParam(":heure_fin", $heure_fin);
          $reqprep->execute();
          echo "Evenement ajouté";
          unset($reqprep);
          unset($connexion);
          header("location:accueil.php");
        }
      }
    ?>
  </body>
</html>
