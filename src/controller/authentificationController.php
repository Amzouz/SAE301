<?php

switch ($action) {
  case 'connexion':
    $modele = 'connexion.twig';
    $data = [];
    break;

  case 'inscription_user':
    $modele = 'inscription.twig';
    $data = [];
    break;

    case 'inscription_musicien':
    $modele = 'inscription.twig';
    $data = [];
    break;

  default:
    $modele = 'accueil.twig';
    $data = [];
    break;
}
