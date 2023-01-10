<?php
  echo "<div id='cadre_event'>";
  include ('affiche_ferie.php');
  $_SESSION['affiche'] = 0;
  ini_set('display_errors', 1);
  if(isset($_SESSION['pseudo'])) {
    $pseudo = $_SESSION['pseudo'];
    include "connexion_base.php";
    $requete1 = "SELECT * FROM profil WHERE pseudo = :pseudo";
    $res1 = $connexion->prepare($requete1);
    $res1->bindParam(":pseudo", $pseudo);
    $res1->execute();
    $lignes = $res1->fetchAll();
    foreach ($lignes as $data) {
       $id_user = $data['id'];
    }
    unset($res1);
    $requete2 = "SELECT * FROM events WHERE id_compte = :id_user 
    ORDER BY heure_debut";
    $res2 = $connexion->prepare($requete2);
    $res2->bindParam(":id_user", $id_user);
    $res2->execute();
    $n = 0;

    while ($data = $res2->fetch()) {
      $date = $data['date_debut'];
      $diff = $data['diffdate'];
        if (isset($_GET['jour']) && isset($_GET['mois']) 
          && isset($_GET['annee'])) {
          $jour = $_GET['jour'];
          $mois = twoInt($_GET['mois']);
          $annee = $_GET['annee'];
          $y = substr($date, 0, 4);
          $m =  twoInt(substr($date, 5, 2));
          $d = (substr($date, 8, 2));
          ++$_SESSION['affiche'];
          $resultat = "$annee-$mois-$jour";
          for ($k = 0 ; $k <= $diff ; ++$k) {
            $y = substr($date, 0, 4);
            $m =  twoInt(substr($date, 5, 2));
            $d = (substr($date, 8, 2));
            if ($d > nbJours($m, $y)) {
              ++$m;
              $d = "01";
              if ($m > 12) {
                ++$y;
                $m = "01";
              }
            }
            $tab[$k] = "$y-$m-$d";
            ++$date;
            if ($resultat == $tab[$k]) {
              echo "<br>";
              echo "$jour / $mois  / $annee : ";
              $fin = date("d/m/Y", strtotime($data['date_fin']));
              $debut = date("d/m/Y", strtotime($data['date_debut']));
              echo "
              <details>
                <summary>
                  Depuis le $debut à {$data['heure_debut']} jusqu'au $fin 
                  à {$data['heure_fin']}: {$data['nom']}<br>
                </summary>
                <p>{$data['description']}<br>
                Lieu : {$data['localisation']}</p>
              </details>";;
              echo "<div id='modif_event'>
              <form action='modification_event.php' method='post'>";
              echo "<input type='hidden' name='id_event' 
              value ='{$data['id_event']}'/>";
              echo "<input type='submit' value='Modifier' /></form></div>";
              echo "<div id='sup_event'>
              <form action='modification_event.php' method='post'>";
              echo "<input type='hidden' name='id_event' 
              value ='{$data['id_event']}'/>";
              echo "<input type='submit' name='delete' value='Supprimer' />
              </form></div><br>";
              $_SESSION['affiche-mois'] = $mois;
              $_SESSION['affiche-annee'] = $annee;
              ++$n;
            }
          }
        }
      }
	 
      if (isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee'])
        && isset($n) && $n == 0) {
        $jour = $_GET['jour'];
        $mois = $_GET['mois'];
        $annee = $_GET['annee'];
        $_SESSION['affiche-mois'] = $mois;
        $_SESSION['affiche-annee'] = $annee;
        echo "$jour / $mois / $annee : ";
        echo "Pas d'événements pour ce jour";
        echo "<br/>";
        echo "<br/>";
      }
      if (isset($_GET['jour']) && isset($_GET['mois'])
        && isset($_GET['annee'])) {
        $jour = $_GET['jour'];
        $mois = $_GET['mois'];
        $annee = $_GET['annee'];
        $jour = urlencode($jour);
        $url = "ajout_events.php?jour=".$jour."&mois=".$mois."&annee=".$annee;
        echo "<div id='ajout_event_jour'><form action='$url' method=post>
        <input type='submit' value='Ajouter un événement pour ce jour' />
        </form></div><br>";
      }
      if (isset($_GET['jour']) && isset($_GET['mois']) 
        && isset($_GET['annee'])) {
        $mois = $_GET['mois'];
        $annee = $_GET['annee'];
        $_SESSION['affiche-mois'] = $mois;
        $_SESSION['affiche-annee'] = $annee;
        ++$_SESSION['affiche'];
        echo "<form method='post' action='accueil.php'>";
        echo "<div class='close_event'><input type='submit' id='close' 
        name='close' value='Fermer onglet'/></div>";
        echo  "</form>";
        if (isset($_REQUEST['close'])) {
          header('Location: accueil.php');
        }
      }
      unset($res2);
      unset($connexion);
    } else {
      if (isset($_GET['jour']) && isset($_GET['mois']) 
        && isset($_GET['annee'])) {
        $mois = $_GET['mois'];
        $annee = $_GET['annee'];
        $_SESSION['affiche-mois'] = $mois;
        $_SESSION['affiche-annee'] = $annee;
        ++$_SESSION['affiche'];
        echo "<p><br>Aucun événement prévu ce jour, 
        veuillez vous connecter pour en enregistrer</p>";
        echo "<form method='post' action='accueil.php'>";
        echo "<div class='close_event'><input type='submit' id='close' name='close' value='Fermer onglet'/></div>";
        echo  "</form>";
        if (isset($_REQUEST['close'])) {
          header('Location: accueil.php');
        }
      }
    }
    echo "</div>";
?>


