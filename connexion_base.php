<?php
	try {
    $password = "password";
		$dsn = "mysql:host=localhost;dbname=vanliflo";
		$connexion = new PDO($dsn, "vanliflo", $password);
	} catch (PDOException $e) {
		exit('Erreur : '.$e->getMessage());
	}
?>
