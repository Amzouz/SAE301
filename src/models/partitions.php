<?php

class Arrangements {
    public $id_partitions;
    public $titre_partitions;
    public $desc_partitions;
    public $prix_partitions;
    public $instru_partitions;
    public $niveau_partitions;
    public $date_post_partitions;
    public $id_user;


    function chargePOST($id_user) {
        $erreurs = [];

        if (isset($_POST['id_partitions'])) {
            $this->id_partitions = $_POST['id_partitions'];
        }

        if (isset($_POST['titre_partitions']) && !empty($_POST['titre_partitions'])) {
            $this->titre_partitions = $_POST['titre_partitions'];
            $this->titre_partitions = strip_tags($this->titre_partitions);
        } else {
            $erreurs['titre_partitions'] = 'Le titre de la partition est obligatoire';
        }

        if (isset($_POST['desc_partitions']) && !empty($_POST['desc_partitions'])) {
            $this->desc_partitions = $_POST['desc_partitions'];
            $this->desc_partitions = strip_tags($this->desc_partitions);
        } else {
            $erreurs['desc_partitions'] = 'La description de la partition est obligatoire';
        }

        if (isset($_POST['prix_partitions']) && !empty($_POST['prix_partitions'])) {
            $this->prix_partitions = $_POST['prix_partitions'];
            if (!is_numeric($this->prix_partitions) || $this->prix_partitions < 0) {
                $erreurs['prix_partitions'] = 'Le prix doit être un nombre positif';
            }
        } else {
            $erreurs['prix_partitions'] = 'Le prix de la partition est obligatoire';
        }

        if (isset($_POST['instru_partitions']) && !empty($_POST['instru_partitions'])) {
            $this->instru_partitions = $_POST['instru_partitions'];
            $this->instru_partitions = strip_tags($this->instru_partitions);
        } else {
            $erreurs['instru_partitions'] = 'L\'instrument de la partition est obligatoire';
        }

        if (isset($_POST['niveau_partitions']) && !empty($_POST['niveau_partitions'])) {
            $this->niveau_partitions = $_POST['niveau_partitions'];
            $this->niveau_partitions = htmlspecialchars($this->niveau_partitions);
            $this->niveau_partitions = strip_tags($this->niveau_partitions);
        } else {
            $erreurs['niveau_partitions'] = 'Le niveau de la partition est obligatoire';
        }

        $this->id_user = $id_user;

        return $erreurs;
    }


    static function readAll()
    {
        $sql = 'select * from arrangements';

        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->execute();

        $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Arrangements');
        return $tableau;
    }


    static function readOne($id) {
        $sql= 'select * from arrangements where id_partitions = :valeur';

        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':valeur', $id, PDO::PARAM_INT);
        $query->execute();

        $objet = $query->fetchObject('Arrangements');

        return $objet;
    }


    function update($id) {
        $sql = 'UPDATE arrangements SET titre_partitions = :titre_partitions, desc_partitions = :desc_partitions, prix_partitions = :prix_partitions, instru_partitions = :instru_partitions, niveau_partitions = :niveau_partitions WHERE id_partitions = :id';

        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $this->id_partitions, PDO::PARAM_INT);
        $query->bindValue(':titre_partitions', $this->titre_partitions, PDO::PARAM_STR);
        $query->bindValue(':desc_partitions', $this->desc_partitions, PDO::PARAM_STR);
        $query->bindValue(':prix_partitions', $this->prix_partitions, PDO::PARAM_STR);
        $query->bindValue(':instru_partitions', $this->instru_partitions, PDO::PARAM_STR);
        $query->bindValue(':niveau_partitions', $this->niveau_partitions, PDO::PARAM_STR);
        $query->execute();
        return [];
    }


    function create() {
        $sql = 'INSERT INTO arrangements (titre_partitions, desc_partitions, prix_partitions, instru_partitions, niveau_partitions, id_user) VALUES (:titre_partitions, :desc_partitions, :prix_partitions, :instru_partitions, :niveau_partitions, :id_user);';
        $pdo = connexion();

        $query = $pdo->prepare($sql);
        $query->bindValue(':titre_partitions', $this->titre_partitions, PDO::PARAM_STR);
        $query->bindValue(':desc_partitions', $this->desc_partitions, PDO::PARAM_STR);
        $query->bindValue(':prix_partitions', $this->prix_partitions, PDO::PARAM_STR);
        $query->bindValue(':instru_partitions', $this->instru_partitions, PDO::PARAM_STR);
        $query->bindValue(':niveau_partitions', $this->niveau_partitions, PDO::PARAM_STR);
        $query->bindValue(':id_user', $this->id_user, PDO::PARAM_INT);
        $query->execute();
        $this->id_partitions = $pdo->lastInsertId();
        return [];
    }


    static function delete($id) {
        $sql = 'DELETE FROM arrangements WHERE id_partitions = :id_partitions';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id_partitions', $id, PDO::PARAM_INT);
        $query->execute();
    }

    static function nombre_partitions() {
        $sql = 'SELECT COUNT(*) FROM arrangements';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->execute();
        $nombre_partitions = $query->fetchColumn();
        return $nombre_partitions;
    }

    static function annonces_user($id) {
        $sql = 'SELECT * FROM arrangements WHERE id_user = :id';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Arrangements');
        return $tableau;
    }
}
