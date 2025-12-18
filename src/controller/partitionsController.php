<?php
include(ROOT_PATH . '/src/models/partitions.php');


switch ($action) {

    case 'read' :
        if ($id > 0) {
            $modele = 'produits/partitions_detail.twig';
            $data = [
                'partitions' => Arrangements::readOne($id),
            ];
        } else {
            $modele = 'produits/partitions.twig';
            $data = [
                'partitions' => Arrangements::readAll()
            ];
        }
        break;

    case 'check_compte' :
        if (!$_SESSION) {
            $modele = 'authentification/connexion.twig';
            $data = ['erreur_partitions' => 'Vous devez être connecté pour acheter une partition'];
        } else {
            $modele = 'produits/produits_achat.twig';
            $data = [];
        }
        break;

    case 'nouveau' :
        $modele = 'produits/partitions_form.twig';
        $data = [];
        break;

    case 'create' :
        $partitions = new Arrangements();
        $id_user = $_SESSION['id_user'];
        $erreurs = $partitions->chargePOST($id_user);
        if (empty($erreurs)) {
            $partitions->create();
            header('Location: index.php?page=partitions&action=read&id='.$partitions->id_partitions);
        } else {
            $modele = 'produits/partitions_form.twig';
            $data = [
                'partitions' => $partitions,
                'erreurs' => $erreurs
            ];
        }
        break;


    case 'edit' :
        $partitions = Arrangements::readOne($id);
        if (!checkOwner($partitions->id_user)) {
            $modele = 'produits/partitions_detail.twig';
            $data = [
                'erreur_droit_partition' => 'Accès refusé, vous n\'avez pas les droits pour modifier cette partition.',
                'partitions' => Arrangements::readOne($id)
            ];
        } else {
            $modele = 'produits/partitions_form.twig';
            $data = [
                'partitions' => Arrangements::ReadOne($id)
            ];
        }
        break;


    case 'update' :
        $partitions = new Arrangements();
        $id_user = $_SESSION['id_user'];
        $erreurs = $partitions->chargePOST($id_user);

        if (empty($erreurs)) {
            $partitions->update($id);
            header('Location: index.php?page=partitions&action=read&id='.$partitions->id_partitions);
            exit;
        } else {
            $modele = 'produits/partitions_form.twig';
            $data = [
                'partitions' => $partitions,
                'erreurs' => $erreurs
            ];
        }
        break;

    case 'delete':
        $partitions = Arrangements::readOne($id);
        if (!checkOwner($partitions->id_user)) {
            $modele = 'produits/partitions_detail.twig';
            $data = [
                'erreur_droit_partition' => 'Accès refusé, vous n\'avez pas les droits pour supprimer cette partition.',
                'partitions' => Arrangements::readOne($id)
            ];
        } else {
            Arrangements::delete($id);
            header('Location: index.php?page=partitions&action=read');
        }
        break;

    default:
        $modele = 'produits/partitions.twig';
        $data = [
            'partitions' => Arrangements::readAll()
        ];
        break;

}
