<?php


switch ($action) {
    case 'connexion':
		$user = new User();
		$modele = 'accueil.twig';
        $data = ['message' => 'Vous être connecté'];
		break;

    case 'check_connexion':
        $user = new User();
        $erreurs = $user->chargePOST();

        $erreurs_connexion = [];
        if (isset($erreurs['mail'])) {
            $erreurs_connexion['mail'] = $erreurs['mail'];
        }
        if (isset($erreurs['mot_de_passe'])) {
            $erreurs_connexion['mot_de_passe'] = $erreurs['mot_de_passe'];
        }

        if (empty($erreurs_connexion)) {
            $readUser = $user->checkUser();
            if ($readUser) {
                // utilisateur trouvé, on le stocke en session
                $_SESSION['pseudo'] = $readUser->pseudo;
                $_SESSION['role'] = $readUser->role;
                $_SESSION['id_user'] = $readUser->id_user;
                header('Location: index.php?page=authentification&action=connexion');
                exit;
            } else {
                // utilisateur non trouvé, retour au formulaire de login
                $modele = 'authentification/connexion.twig';
                $data = [
                    'erreur_compte' => 'Ces informations ne correspondent à aucun compte',
                    'user' => $user
                ];
            }
        } else {
            $modele = 'authentification/connexion.twig';
            $data = [
                'erreurs' => $erreurs_connexion,
                'user' => $user
            ];
        }
        break;

    case 'deconnexion':
        session_unset(); //vérifier si c'est comme ça
		header('Location: index.php?page=authentification&action=check_connexion');
        break;

    case 'inscription' :
        $modele = 'authentification/choix_inscription.twig';
        $data = [];
        break;

    case 'inscription_musicien':
        $user = new User();
        $erreurs = $user->chargePOST();

        if (empty($erreurs)) {
            $mailExiste = $user->checkMail();

            if ($mailExiste) {
                $modele = 'authentification/choix_inscription.twig';
                $data = [
                    'erreur_musicien_mail' => 'Ce mail est déja utilisé',
                    'user_musicien' => $user
                ];
            } else {
                $user->create();
                $modele = 'authentification/choix_inscription.twig';
                $data = [
                    'message_musicien' => 'Le compte a bien été créé',
                ];
            }
        } else {
            $modele = 'authentification/choix_inscription.twig';
            $data = [
                'erreurs_musicien' => $erreurs,
                'user_musicien' => $user
            ];
        }
        break;

    case 'inscription_user':
        $user = new User();
        $erreurs = $user->chargePOST(); //mtn on utilise la variable

        if (empty($erreurs)) {
            $mailExiste = $user->checkMail();

            if ($mailExiste) {
                $modele = 'authentification/choix_inscription.twig';
                $data = [
                    'erreur_user' => 'Ce mail est déja utilisé',
                    'message_user' => '',
                    'user_user' => $user
                ];
            } else {
                $user->create();
                $modele = 'authentification/choix_inscription.twig';
                $data = [
                    'message_user' => 'Le compte a bien été créé',
                    'erreur_user' => ''
                ];
            }
        } else {
            $modele = 'authentification/choix_inscription.twig';
            $data = [
                'erreurs_user' => $erreurs,
                'user_user' => $user
            ];
        }
        break;

    default:
        $modele = 'accueil.twig';
        $data = [];
        break;
}
