<?php


switch ($action) {
    case 'connexion':
		$user = new User();
		$modele = 'authentification/connexion.twig';
        $data = [];
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
                $_SESSION['mail'] = $readUser->mail;
                $_SESSION['nom'] = $readUser->nom;
                $_SESSION['prenom'] = $readUser->prenom;
                $_SESSION['tel'] = $readUser->tel;
                $_SESSION['rgpd'] = $readUser->rgpd;
                $_SESSION['role'] = $readUser->role;
                $_SESSION['id_user'] = $readUser->id_user;
                header('Location: index.php');
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
		header('Location: index.php?page=authentification&action=connexion');
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
                ];
            } else {
                $user->create();
                $modele = 'authentification/connexion.twig';
                $data = [
                    'message_musicien' => 'Le compte a bien été créé, veuillez vous connecter',
                ];
            }
        } else {
            $modele = 'authentification/choix_inscription.twig';
            $data = [
                'erreurs_musicien' => $erreurs,
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
                ];
            } else {
                $user->create();
                $modele = 'authentification/connexion.twig';
                $data = [
                    'message_user' => 'Le compte a bien été créé, veuillez vous connecter',
                ];
            }
        } else {
            $modele = 'authentification/choix_inscription.twig';
            $data = [
                'erreurs_user' => $erreurs,
            ];
        }
        break;

    default:
        $modele = 'accueil.twig';
        $data = [];
        break;
}
