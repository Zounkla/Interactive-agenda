<?php
function twoInt($n) {
  if ($n >= 0 && $n <= 9) {
    return $n.' ';
  }
  return $n;
}



function is_bi($year) {
  return ($year % 4 == 0) &&($year % 400 == 0 || $year % 100 != 0);
}


function nbJours($month, $year) {
  $n = 0;
  if ($month == 1 || $month == 3 || $month == 5 || $month == 7 
  || $month == 8 || $month == 10 || $month == 12) {
    $n = 31;
  } else if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
    $n = 30;
  } else {
    if (is_bi($year)) {
      $n = 29;
    } else {
      $n = 28;
    }
  }
  return $n;
}
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
  $p = 1;
  while ($data = $res2->fetch()) {
    $date = $data['date_debut'];
    $diff = $data['diffdate'];
    $y = substr($date, 0, 4);
    $m =  twoInt(substr($date, 5, 2));
    $d = (substr($date, 8, 2));
    while ($diff >= 0) {
      if ($d > nbJours($m, $y)) {
        ++$m;
        $d = "01";
        if ($m > 12) {
          ++$y;
          $m = "01";
        }
      }
      echo "<input type='hidden' name='style-event-y' 
      id='style-event-y$p' value=$y>";
      echo "<input type='hidden' name='style-event-m' 
      id='style-event-m$p' value=$m>";
      echo "<input type='hidden' name='style-event-d' 
      id='style-event-d$p' value=$d>";
      --$diff;
      ++$p;
      ++$d;
    }
      
  }
  echo "<input type='hidden' name='nb-event' id='nb-event' value=$p>";
}
?>
