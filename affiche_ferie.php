<?php

function nthDayofMonth($month, $year, $number, $day) {
  $date =  mktime(0,0,0, $month - 1, 1, $year);
  $days[] = 0;
  $k = 1;
  $j = 0;
  while ($k <= 31) {
    if (date("l", mktime(0, 0, 0, $month, $k, $year)) == "$day") {
      ++$j;
      if ($j == $number) {
        return $k;
      }
    }
    ++$k;
    $date = mktime(0,0,0, $month - 1, $k, $year);
  }
  return $j;
}

function ferie($event) {
  echo $event;
  echo "<br>";
  echo "<br>";
}

  if (isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee'])) {
    $jour = $_GET['jour'];
    $mois = $_GET['mois'];
    $annee = $_GET['annee'];
    
    $G = $annee % 19;

    $C = (int) ($annee / 100);

    $H = ($C - (int) ($C / 4) - (int) ((8 * $C + 13) / 25) + 19 * $G + 15) % 30;

    $I = $H - (int) ($H / 28) * (1 - (int) ($H / 28) * (int) (29 / ($H + 1)) * 
    (int) ((21 - $G) / 11));

    $J = ($annee * 1 + (int) ($annee / 4) + $I + 2 - $C + (int) ($C / 4)) % 7;

    $L = $I - $J;

    $MoisPaques = 3 + (int) (($L + 40) / 44);

    $JourPaques = $L + 28 - 31 * (int) ($MoisPaques / 4);
    
    
    
    $number = nbJours($mois, $annee);
    $JourAscension = $JourPaques + 40;
    $MoisAscension = $MoisPaques;

    if ($JourAscension > $number) {
      $JourAscension = $JourAscension - $number;
      ++$MoisAscension;
    }
    if ($JourAscension > nbJours($mois + 1, $annee)) {
      $JourAscension = $JourAscension - nbJours($mois + 1, $annee) - 1;
      ++$MoisAscension;
    }
    
    $JourPentecote = $JourPaques + 50;
      $MoisPentecote = $MoisPaques;

      if ($JourPentecote > nbJours($mois, $annee)) {
        $JourPentecote = $JourPentecote - nbJours($mois, $annee);
        ++$MoisPentecote;
      }

      if ($JourPentecote > nbJours($mois + 1, $annee)) {
        $JourPentecote = $JourPentecote - nbJours($mois + 1, $annee) - 1;
        ++$MoisPentecote;
      }
    
    if ((isset($_SESSION['pays']) 
      && $_SESSION['pays'] === "fr") || !isset($_SESSION['pays'])) {
      
      if ($jour == 25 && $mois == 12) {
        ferie("Noël");
      }
      
      if ($jour == 1 && $mois == 11) {
        ferie("Toussaint");
      }
      
      if ($jour == 11 && $mois == 11) {
        ferie("Armistice");
      }
      
      if ($jour == 1 && $mois == 1) {
        ferie("Jour de l'An");
      }
      
      if ($jour == 1 && $mois == 5) {
        ferie("Fête du travail");
      }
      
      if ($jour == 8 && $mois == 5) {
        ferie("Victoire des Alliés 1945");
      }
      
      if ($jour == 14 && $mois == 7) {
        ferie("Fête nationale");
      }
      
      if ($jour == 15 && $mois == 8) {
        ferie("Assomption");
      }
      
      if ($jour == 26 && $mois == 12) {
        ferie("Saint-Etienne");
      }
      

      if ($jour == $JourPaques && $mois == $MoisPaques) {
        ferie("Pâques");
      }

      if ($JourPaques == 31 && $jour == 1 && $mois == $MoisPaques + 1
      || $JourPaques == 2 && $jour == 31 && $mois == $MoisPaques - 1
      || $JourPaques == 1 && $jour == 30 && $mois == $MoisPaques - 1
      || $jour == $JourPaques + 1 && $mois == $MoisPaques) {
        ferie("lundi de Pâques");
      }

      if ($jour == $JourPaques - 2 && $mois == $MoisPaques) {
        ferie("Vendredi Saint");
      }

      
      if ($jour == $JourAscension && $mois == $MoisAscension) {
        ferie("Ascension");
      }

      

      if ($jour == $JourPentecote && $mois == $MoisPentecote) {
        ferie("Pentecôte");
      }

      if ($jour == $JourPentecote + 1 && $mois == $MoisPentecote) {
        ferie("Lundi de Pentecôte");
      }
    } else if ($_SESSION['pays'] === "uk") {
      if ($jour == 25 && $mois == 12) {
        ferie("Christmas");
      }
      
      if ($jour == 26 && $mois == 12) {
        ferie("Boxing day");
      }
      
      if ($jour == 1 && $mois == 1) {
        ferie("New year");
      }
      
      if ($jour == 2 && $mois == 1) {
        ferie("bank holiday");
      }
      
      if ($jour == 17 && $mois == 3) {
        ferie("Saint Patrick's Day");
      }
      
      if ($jour == $JourPaques && $mois == $MoisPaques) {
        ferie("Easter");
      }

      if ($JourPaques == 31 && $jour == 1 && $mois == $MoisPaques + 1
      || $JourPaques == 2 && $jour == 31 && $mois == $MoisPaques - 1
      || $JourPaques == 1 && $jour == 30 && $mois == $MoisPaques - 1
      || $jour == $JourPaques + 1 && $mois == $MoisPaques) {
        ferie("Easter Monday");
      }

      if ($jour == $JourPaques - 2 && $mois == $MoisPaques) {
        ferie("Good Friday");
      }

      
      if ($jour == $JourAscension && $mois == $MoisAscension) {
        ferie("Ascension");
      }
      
      if ($jour == 12 && $mois == 7) {
        ferie("Orangemen’s Day");
      }
      
      if ($jour == 30 && $mois == 11) {
        ferie("St Andrew’s Day");
      }
      
      if ($jour == nthDayofMonth(5, $annee, 1, "Monday") && $mois == 5) {
        ferie("May Day Bank Holiday");
      }
      
      if ($jour == nthDayofMonth(5, $annee, 5, "Monday") && $mois == 5) {
        ferie("Spring Bank Holiday");
      }
      
      
      if ($jour == nthDayofMonth(8, $annee, 5, "Monday") && $mois == 8) {
        ferie("Summer Bank Holiday (England, Wales, Northern Ireland)");
      }
      
      
      if ($jour == nthDayofMonth(8, $annee, 1, "Monday") && $mois == 8) {
        ferie("Summer Bank Holiday (Scotland)");
      }
      
    } else {
      
      if ($jour == 1 && $mois == 1) {
        ferie("New year");
      }
      
      if ($jour == nthDayofMonth(1, $annee, 3, "Monday") && $mois == 1) {
        ferie("Martin Luther King Junior Day");
      }
      
      if ($jour == nthDayofMonth(2, $annee, 3, "Monday") && $mois == 2) {
        ferie("President’s Day");
      }
      
      if ($jour == $JourPaques && $mois == $MoisPaques) {
        ferie("Easter");
      }

      if ($JourPaques == 31 && $jour == 1 && $mois == $MoisPaques + 1
      || $JourPaques == 2 && $jour == 31 && $mois == $MoisPaques - 1
      || $JourPaques == 1 && $jour == 30 && $mois == $MoisPaques - 1
      || $jour == $JourPaques + 1 && $mois == $MoisPaques) {
        ferie("Easter Monday");
      }

      if ($jour == $JourPaques - 2 && $mois == $MoisPaques) {
        ferie("Good Friday");
      }
      
      if ($jour == $JourAscension && $mois == $MoisAscension) {
        ferie("Ascension");
      }
      
      if ($jour == nthDayofMonth(5, $annee, 5, "Monday") && $mois == 5) {
        ferie("Memorial Day");
      }
      
      if ($jour == 19 && $mois == 6) {
        ferie("Juneteenth");
      }
      
      if ($jour == 4 && $mois == 7) {
        ferie("Independence Day");
      }
      
      if ($jour == nthDayofMonth(9, $annee, 1, "Monday") && $mois == 9) {
        ferie("Labor Day");
      }
      
      if ($jour == nthDayofMonth(10, $annee, 2, "Monday") && $mois == 10) {
        ferie("Columbus Day");
      }
      
      if ($jour == 11 && $mois == 11) {
        ferie("Veteran's Day");
      }
      
      if ($jour == nthDayofMonth(11, $annee, 4, "Thursday") && $mois == 11) {
        ferie("Thanksgiving Day");
      }
      
      if ($jour == 25 && $mois == 12) {
        ferie("Christmas");
      }
      
    }
    
    
    
  }

?>
