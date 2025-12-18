<?php
include(ROOT_PATH . '/src/models/cours.php');


switch ($action) {

    case 'read' :
        if ($id > 0) {
            $modele = 'cours/cours_detail.twig';
            $data = [
                'cours' => Cours::readOne($id),
            ];
        } else {
            $modele = 'cours/cours.twig';
            $data = [
                'cours' => Cours::readAll()
            ];
        }
        break;

    case 'check_compte' :
        if (!$_SESSION) {
            $modele = 'authentification/connexion.twig';
            $data = ['erreur_cours' => 'Vous devez être connecté pour vous inscrire à un cours'];
        } else {
            $modele = 'cours/cours_inscription.twig';
            $data = [];
        }
        break;

    case 'nouveau' :
        $modele = 'cours/cours_form.twig';
        $data = [];
        break;

    case 'create' :
        $cours = new Cours();
        $id_user = $_SESSION['id_user'];
        $erreurs = $cours->chargePOST($id_user);
        if (empty($erreurs)) {
            $cours->create();
            header('Location: index.php?page=cours&action=read&id='.$cours->id_cours);
        } else {
            $modele = 'cours/cours_form.twig';
            $data = [
                'cours' => $cours,
                'erreurs' => $erreurs
            ];
        }
        break;


    case 'edit' :
        requireRole('musicien');
        $cours = Cours::readOne($id);
        if (!checkOwner($cours->id_user)) {
            $modele = 'cours/cours_detail.twig';
            $data = [
                'erreur_droit' => 'Accès refusé, vous n\'avez pas les droits pour modifier ce cours.',
                'cours' => Cours::readOne($id)
            ];
        } else {
            $modele = 'cours/cours_form.twig';
            $data = [
                'cours' => Cours::ReadOne($id)
            ];
        }
        break;

    case 'update' :
        $cours = new Cours();
        $id_user = $_SESSION['id_user'];
        $erreurs = $cours->chargePOST($id_user);

        if (empty($erreurs)) {
            $cours->update($id);
            header('Location: index.php?page=cours&action=read&id='.$cours->id_cours);
            exit;
        } else {
            $modele = 'cours/cours_form.twig';
            $data = [
                'cours' => $cours,
                'erreurs' => $erreurs
            ];
        }
        break;

    case 'delete':
        requireRole('musicien');
        $cours = Cours::readOne($id);
        if (!checkOwner($cours->id_user)) {
            $modele = 'cours/cours_detail.twig';
            $data = [
                'erreur_droit' => 'Accès refusé, vous n\'avez pas les droits pour supprimer ce cours.',
                'cours' => Cours::readOne($id)
            ];
        } else {
        Cours::delete($id);
		header('Location: index.php?page=cours&action=read');
        }
        break;


    default:
        $modele = 'cours/cours.twig';
        $data = [
            'cours' => Cours::readAll()
        ];
        break;




}

