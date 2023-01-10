<?php session_start() ;

if(!isset($_SESSION['pseudo'])) {
	header("location:accueil.php");
} 
?>

<!DOCTYPE html>

<html lang="fr">
  <head>
    <title>Modification d'événements</title>
    <meta charset="utf-8"/>
	<link rel="stylesheet" href="css/event.css" />

  </head>

  <body>
    <nav>
      <h1>Modification d'événements dans l'agenda</h1>
      <a href="accueil.php">Retour à l'accueil</a>
    </nav>
	
    <?php 
    if(isset($_REQUEST['delete'])) {
      //Supression d'un événement
      if(isset($_REQUEST['id_event'])) {
        $id_event = $_REQUEST['id_event'];
        $_SESSION['id_event'] = $id_event;
      }
      include "connexion_base.php";
      $id_compte = $_SESSION['numcompte'];
      $request_pre_delete = "DELETE FROM events WHERE id_event=:id_event";
      $res_pre_delete = $connexion->prepare($request_pre_delete);
      $res_pre_delete->bindParam(":id_event", $_SESSION['id_event']);
      $res_pre_delete->execute();
      
      echo "Evenement supprimé";
      
      header("location:accueil.php");
    }
    if(isset($_REQUEST['id_event'])) {
      $id_event = $_REQUEST['id_event'];
    } else if (isset($_SESSION['id_event'])) {
      $id_event = $_SESSION['id_event'];
    }
    if (isset($id_event)) {
      $_SESSION['id_event'] = $id_event;
      include "connexion_base.php";
      //On cherche à afficher grâce à une requête préparée les valeurs de l'événement à modifier
      // dans les champs, de manière à les préremplir
      $requete = "SELECT * FROM events WHERE id_event = :id_event";
      $reqprep = $connexion->prepare($requete);
      $reqprep->bindParam(":id_event", $id_event);
      $reqprep->execute();
      $lignes = $reqprep->fetchAll();
      foreach($lignes as $data) {
        $id_compte = $data['id_compte'];
        echo "<form method='post'>
          <p>
          Nom :
          <input type='text' name='nom' value='{$data['nom']}' 
          maxlength='50' required /> <br>
          <br>
          Description :
          <input type='text' name='desc' value='{$data['description']}'
           maxlength='500' required /><br>
          <br>
          Localisation :
          <input type='text' name='lieu' value='{$data['localisation']}' 
          maxlength='100' required /><br>
          <br>
          Date de début : 
          <input type='date' name='date_déb' value='{$data['date_debut']}'/><br>
          <br>
          Heure de début :
          <input type='time' name='heure_déb' 
          value='{$data['heure_debut']}' required /><br>
          <br>
          Date de fin :
          <input type='date' name='date_fin' 
          value='{$data['date_fin']}' required /><br>
          <br>
          Heure de fin :
          <input type='time' name='heure_fin'
           value='{$data['heure_fin']}' required /><br>
          <br>
          <input type='submit' name='submit' value='Ajouter' />
          </p>
        </form>";
      }
      unset($reqprep);
    }
    ?>


    <?php
    include_once "connexion_base.php";
    if(isset($_REQUEST['submit'])){
      if (!isset($_SESSION['id_event']) || $_SESSION['id_event'] === 0) {
        echo "Erreur, renvoi à la page principale...";
        header("Refresh: 5;URL=accueil.php");
      } else {
        $id_event = $_SESSION['id_event'];
        $nom = htmlentities($_REQUEST['nom'], ENT_QUOTES);
        $desc = htmlentities($_REQUEST['desc'], ENT_QUOTES);
        $lieu = htmlentities($_REQUEST['lieu'], ENT_QUOTES);

        $date_debut = $_REQUEST['date_déb'];
        $heure_debut = $_REQUEST['heure_déb'];
        $date_fin = $_REQUEST['date_fin'];
        $diffdate = strtotime($date_fin) - strtotime($date_debut);
        $diffdate = $diffdate / 60 / 60 / 24;
        $heure_fin = $_REQUEST['heure_fin'];
        $diffheure = strtotime($heure_fin) - strtotime($heure_debut);
        $diffheure = $diffheure / 3600;
        if ($diffdate < 0 || ($diffdate == 0 && $diffheure < 0)) {
          echo "<p class='error'>
          Erreur ! Date de fin inférieure à la date de début\n 
          </p>";
          //header("location:modification_event.php");
        } else {
          $req = "SELECT * FROM events";
          $res = $connexion->query($req);
          $lignes = $res->fetchAll();
          foreach($lignes as $data) {
            if ($data['id_event'] === $id_event){
              $old_nom = $data['nom'];
              $requete = "UPDATE events SET nom='$nom', 
              description='$desc',
              localisation='$lieu',
              date_debut='$date_debut',
              date_fin='$date_fin',
              diffdate='$diffdate',
              heure_debut='$heure_debut',
              heure_fin='$heure_fin'
              WHERE id_event='$id_event' AND nom='$old_nom'";
              $retour = $connexion->exec($requete);
              if($retour === false) { // === permet de distinguer false et 0
                die("Erreur");
              } else {
                echo "$retour valeurs ont ete changees";
                header("location:accueil.php");
              }
            } else {
              echo "Evenement non trouvé";
            }
          }
        }
      }
    }

    unset($connexion);
               
    ?>
    
  </body>

</html>
