<?php
//La session :
session_start();

// Définir la racine du projet
define('ROOT_PATH', __DIR__ . '/..');
//DIR = racine du projet
//le root_path ça veut dire qu'on part toujours de la racine

include(ROOT_PATH . '/src/database/connexion.php');
include(ROOT_PATH . '/include/twig.php');
include(ROOT_PATH . '/src/models/user.php');
include(ROOT_PATH . '/src/auth/fonctionsAcces.php');

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

    case 'cours':
        include(ROOT_PATH . '/src/controller/coursController.php');
        break;

    case 'instruments':
        include(ROOT_PATH . '/src/controller/instrumentsController.php');
        break;

    case 'partitions':
        include(ROOT_PATH . '/src/controller/partitionsController.php');
        break;

    case 'dashboard':
        include(ROOT_PATH . '/src/controller/dashboardController.php');
        break;

    case 'profil':
        include(ROOT_PATH . '/src/controller/profilController.php');
        break;

    default:
        $modele = 'accueil.twig';
        $data = [];
        break;
}


$twig->addGlobal('session', $_SESSION);
echo $twig->render($modele, $data);
