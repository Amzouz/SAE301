<?php


switch ($action) {
    case 'connexion':
		$user = new User();
		$modele = 'accueil.twig';
        $data = ['message' => 'Vous être connecté'];
		break;

    case 'check_connexion':
		$user = new User();
		$user->chargePOST();
		$readUser = $user->checkUser();
		if ($readUser) {
			// utilisateur trouvé, on le stocke en session
			$_SESSION['pseudo'] = $readUser->pseudo;
            $_SESSION['role'] = $readUser->role;
            $_SESSION['id_user'] = $readUser->id_user;
			header('Location: index.php?page=authentification&action=connexion');
		} else {
			// utilisateur non trouvé, retour au formulaire de login
			$modele = 'connexion.twig';
            $data = ['erreur' => 'Ces informations ne correspondent à aucun compte'];
		}
		break;

    case 'deconnexion':
        session_unset(); //vérifier si c'est comme ça
		header('Location: index.php?page=authentification&action=check_connexion');
        break;

    case 'inscription' :
        $modele = 'choix_inscription.twig';
        $data = [];
        break;

    case 'inscription_musicien':
        $user = new User();
        $user->chargePOST();    // utilise maintenant la vraie variable $_POST
        $mailExiste = $user->checkMail();

        if ($mailExiste) {
            $modele = 'choix_inscription.twig';
            $data = [
            'erreur_musicien' => 'Ce mail est déja utilisé',
            'message_musicien' => ''
            ];
        } else {
        $user->create();
        $modele = 'choix_inscription.twig';
        $data = [
            'message_musicien' => 'Le compte a bien été créé',
            'erreur_musicien' => ''
        ];
        }
        break;

    case 'inscription_user':
        $user = new User();
        $user->chargePOST();    // utilise maintenant la vraie variable $_POST
        $mailExiste = $user->checkMail();

        if ($mailExiste) {
            $modele = 'choix_inscription.twig';
            $data = [
            'erreur_user' => 'Ce mail est déja utilisé',
            'message_user' => ''
            ];
        } else {
        $user->create();
        $modele = 'choix_inscription.twig';
        $data = [
            'message_user' => 'Le compte a bien été créé',
            'erreur_user' => ''
        ];
        }
        break;

    default:
        $modele = 'accueil.twig';
        $data = [];
        break;
}
