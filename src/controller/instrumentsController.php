<?php
include(ROOT_PATH . '/src/models/instruments.php');

switch ($action) {

    case 'read' :
        if ($id > 0) {
            $modele = 'produits/instruments_detail.twig';
            $data = [
                'instruments' => Instruments::readOne($id),
            ];
        } else {
            $modele = 'produits/instruments.twig';
            $data = [
                'instruments' => Instruments::readAll()
            ];
        }
        break;

    case 'check_compte' :
        if (!$_SESSION) {
            $modele = 'authentification/connexion.twig';
            $data = ['erreur_instruments' => 'Vous devez être connecté pour acheter un instruments'];
        } else {
            $modele = 'produits/produits_achat.twig';
            $data = [];
        }
        break;

    case 'nouveau' :
        $modele = 'produits/instruments_form.twig';
        $data = [];
        break;

    case 'create' :
        $instruments = new Instruments();
        $id_user = $_SESSION['id_user'];
        $erreurs = $instruments->chargePOST($id_user);
        if (empty($erreurs)) {
            $instruments->create();
            header('Location: index.php?page=instruments&action=read&id='.$instruments->id_instru);
        } else {
            $modele = 'produits/instruments_form.twig';
            $data = [
                'instruments' => $instruments,
                'erreurs' => $erreurs
            ];
        }
        break;


    case 'edit' :
        $instruments = Instruments::readOne($id);
        if (!checkOwner($instruments->id_user)) {
            $modele = 'produits/instruments_detail.twig';
            $data = [
                'erreur_droit_instru' => 'Accès refusé, vous n\'avez pas les droits pour modifier cet instrument.',
                'instrument' => Instruments::readOne($id)
            ];
        } else {
            $modele = 'produits/instruments_form.twig';
            $data = [
                'instruments' => Instruments::ReadOne($id)
            ];
        }
        break;


    case 'update' :
        $instruments = new Instruments();
        $id_user = $_SESSION['id_user'];
        $erreurs = $instruments->chargePOST($id_user);

        if (empty($erreurs)) {
            $instruments->update($id);
            header('Location: index.php?page=instruments&action=read&id='.$instruments->id_instru);
            exit;
        } else {
            $modele = 'produits/instruments_form.twig';
            $data = [
                'instruments' => $instruments,
                'erreurs' => $erreurs
            ];
        }
        break;

    case 'delete':
        $instruments = Instruments::readOne($id);
        if (!checkOwner($instruments->id_user)) {
            $modele = 'produits/instruments_detail.twig';
            $data = [
                'erreur_droit_instru' => 'Accès refusé, vous n\'avez pas les droits pour supprimer cet instrument.',
                'instruments' => Instruments::readOne($id)
            ];
        } else {
        Instruments::delete($id);
        header('Location: index.php?page=instruments&action=read');
        }
        break;

    default:
        $modele = 'produits/instruments.twig';
        $data = [
            'instruments' => Instruments::readAll()
        ];
        break;

}
