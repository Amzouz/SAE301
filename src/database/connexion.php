<?php

// Fichier de configuration avec les login et mots de passe
include ('config.php');

function connexion() {
        // Connexion à la base de données
        $pdo = new PDO('mysql:host='.SERVER.';dbname='.BDD.';charset=utf8', USER, PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
}
