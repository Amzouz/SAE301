<?php
//Ce controller gère la page profil, avec la possibilité de voir les informations, de les supprimer, d'avoir accès à ses annonces, et pour le responsable_annonce, de valider la visibilité de celles-ci (changement client du 18/12)

include(ROOT_PATH . '/src/models/cours.php');
include(ROOT_PATH . '/src/models/instruments.php');
include(ROOT_PATH . '/src/models/partitions.php');

switch ($action) {

    case 'profil_edit' :
        $user = User::readOne($id);
        $modele = 'profil/profil_form.twig';
        $data = [
            'user' => User::ReadOne($id)
        ];
        break;


    case 'profil_update' :
        $user = new User();
        $user->chargePOST();
        $user->update_profil($id);
        header('Location: index.php?page=profil&action=read&id='.$id);
        exit;
        break;

    case 'read' :
        $modele = 'profil/profil.twig';
        $data = [
            'user' => User::readOne($id),
        ];
        break;

    case 'read_annonces' :
        $modele = 'profil/profil_annonces.twig';
        $data = [
            'user' => User::readOne($id),
            'instruments' => Instruments::annonces_user($id),
            'partitions' => Arrangements::annonces_user($id),
        ];
        break;

    case 'gestion_annonces' :
        $modele = 'profil/profil_gestion_annonces.twig';
        $data = [
            'instruments' => Instruments::readAll()
        ];
        break;

    case 'gestion_annonces_edit' :
        $modele = 'profil/profil_gestion_annonces_form.twig';
        $data = [
            'instruments' => Instruments::readOne($id)
        ];
        break;

    case 'visible_update' : //Pour que le responsable_annonce valide si une annonce d'instrument postée par un "visiteur" soit visible ou non (changement client du 18/12)
        requireRole('reponsable_annonces');
        $instrument = Instruments::readOne($id);
        $instrument->visible_instru = $_POST['visible_instru'];
        $instrument->update_visible($id);
        header('Location: index.php?page=profil&action=gestion_annonces');
        exit;
        break;

    default:
        $modele = 'profil/profil.twig';
        $data = [
            'user' => User::readOne($id),
        ];
        break;

}
