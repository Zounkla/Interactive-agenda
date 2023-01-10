<?php
  if (isset($_SESSION['pseudo'])) {
    ini_set('display_errors', 1);
    $pseudo = $_SESSION['pseudo'];
    include "connexion_base.php";
	
	//On accède à la base de données pour récupérer les informations sur le nombre de jours à afficher
	//   selon la préférence de l'utilisateur
    $requete1 = "SELECT * FROM profil WHERE pseudo = :pseudo";
    $res1 = $connexion->prepare($requete1);
    $res1->bindParam(":pseudo", $pseudo);
    $res1->execute();
    $lignes = $res1->fetchAll();
	//$nombre : nombre d'événements associé à la plage choisie
    $nombre = 0;
    foreach ($lignes as $data) {
      $id_user = $data['id'];
      $n = $data['nombre_jours'];
      if (!isset($n)) {
        $n = 7;
      }
    }
    echo "<span id='liste_prochains_events'>
    Vos événements dans les $n prochains jours : ";
    unset($res1);
    $requete2 = "SELECT * FROM events 
    WHERE id_compte = :id_user ORDER BY date_debut";
    $res2 = $connexion->prepare($requete2);
    $res2->bindParam(":id_user", $id_user);
    $res2->execute();
    $k = 0;
    while ($data = $res2->fetch()) {
      $today = date("Y-m-d");
      $date = $data['date_debut'];
      $fin = $data['date_fin'];
      if ($k == 0) {
        $offset = strtotime($today. "+ $n days");
        $offset = date("Y-m-d", $offset);
        ++$k;
      }
      if (($today == $date || $today <= $fin) && $date <= $offset) {
        ++$nombre;
        $date = date("d/m/Y", strtotime($date));
        $fin = date("d/m/Y", strtotime($fin));
        echo "
        <details>
          <summary>
            $date - $fin de {$data['heure_debut']} à {$data['heure_fin']}: 
            {$data['nom']}<br>
          </summary>
          <p>{$data['description']}<br>
          Lieu : {$data['localisation']}</p>
        </details>";
      }
    }
	
    if ($nombre == 0) {
      echo "Aucun événement enregistré dans ces $n prochains jours";
    }
    echo "</span>";
    unset($res2);
    unset($connexion);
  }
?>
