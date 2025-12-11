<?php

// Définir la racine du projet
define('ROOT_PATH', __DIR__ . '/..');
//le root_path ça veut dire qu'on part toujours de la racine

include(ROOT_PATH . '/src/database/connexion.php');
include(ROOT_PATH . '/include/twig.php');

$twig = init_twig();

$page = $_GET['page'] ?? "";
$action = $_GET['action'] ?? "read";
$id = $_GET['id'] ?? 0;

// Routeur - Dirige vers le bon contrôleur
switch ($page) {
  case 'accueil':
    $modele = 'accueil.twig';
    $data = [];
    break;

  case 'authentification':
    include(ROOT_PATH . '/src/controller/authentificationController.php');
    break;


  default:
    $modele = 'accueil.twig';
    $data = [];
    break;
}

echo $twig->render($modele, $data);
