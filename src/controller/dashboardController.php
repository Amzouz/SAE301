<?php
include(ROOT_PATH . '/src/models/cours.php');
include(ROOT_PATH . '/src/models/instruments.php');
include(ROOT_PATH . '/src/models/partitions.php');

switch ($action) {

    case 'read' :
        requireRole('administrateur');
        $modele = 'dashboard/dashboard.twig';
        $data = [
            'page_active' => 'accueil',
            'nombre_cours' => Cours::nombre_cours(),
            'nombre_instruments' => Instruments::nombre_instruments(),
            'nombre_partitions' => Arrangements::nombre_partitions(),
            'nombre_user' => User::nombre_user()
        ];
        break;

    case 'cours_read' :
        requireRole('administrateur');
        $modele = 'dashboard/dashboard_cours.twig';
        $data = [
            'cours' => Cours::readAll(),
            'page_active' => 'cours'
        ];
        break;

    case 'instruments_read':
        requireRole('administrateur');
        $modele = 'dashboard/dashboard_instruments.twig';
        $data = [
            'instruments' => Instruments::readAll(),
            'page_active' => 'instruments'
        ];
        break;

    case 'partitions_read':
        requireRole('administrateur');
        $modele = 'dashboard/dashboard_partitions.twig';
        $data = [
            'partitions' => Arrangements::readAll(),
            'page_active' => 'partitions'
        ];
        break;

    case 'user_read':
        requireRole('administrateur');
        $modele = 'dashboard/dashboard_user.twig';
        $data = [
            'user' => User::readAll(),
            'page_active' => 'user'
        ];
        break;


    case 'role_edit' :
        requireRole('administrateur');
        $user = User::readOne($id);
        $modele = 'dashboard/dashboard_role_user.twig';
        $data = [
            'user' => User::ReadOne($id)
        ];
        break;


    case 'role_update' :
        requireRole('administrateur');
        $user = new User();
        $user->chargePOST();
        $user->update_role($id);
        header('Location: index.php?page=dashboard&action=user_read');
        exit;
        break;


    default:
        requireRole('administrateur');
        $modele = 'dashboard/dashboard.twig';
        $data = [
            'page_active' => 'accueil'
        ];
        break;
}
