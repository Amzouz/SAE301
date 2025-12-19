<?php
//Classe Cours, avec toutes les fonctions associées

class Cours {
    public $id_cours;
    public $titre_cours;
    public $desc_cours;
    public $prix_cours;
    public $type_cours;
    public $date_creation_cours;
    public $id_user;



    function chargePOST($id_user) {
        $erreurs = [];

        if (isset($_POST['id_cours'])) {
            $this->id_cours = $_POST['id_cours'];
        }

        if (isset($_POST['titre_cours']) && !empty($_POST['titre_cours'])) {
            $this->titre_cours = $_POST['titre_cours'];
            $this->titre_cours = strip_tags($this->titre_cours);
        } else {
            $erreurs['titre_cours'] = 'Le titre du cours est obligatoire';
        }

        if (isset($_POST['desc_cours']) && !empty($_POST['desc_cours'])) {
            $this->desc_cours = $_POST['desc_cours'];
            $this->desc_cours = strip_tags($this->desc_cours);
        } else {
            $erreurs['desc_cours'] = 'La description du cours est obligatoire';
        }

        if (isset($_POST['prix_cours']) && !empty($_POST['prix_cours'])) {
            $this->prix_cours = $_POST['prix_cours'];
            if (!is_numeric($this->prix_cours) || $this->prix_cours < 0) {
                $erreurs['prix_cours'] = 'Le prix doit être un nombre positif';
            }
        } else {
            $erreurs['prix_cours'] = 'Le prix du cours est obligatoire';
        }

        if (isset($_POST['type_cours']) && !empty($_POST['type_cours'])) {
            $this->type_cours = $_POST['type_cours'];
            $this->type_cours = htmlspecialchars($this->type_cours);
            $this->type_cours = strip_tags($this->type_cours);
        } else {
            $erreurs['type_cours'] = 'Le type de cours est obligatoire';
        }

            $this->id_user = $id_user;

        return $erreurs;
    }


    static function readAll()
	{
		$sql = 'select * from cours';

		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->execute();

		$tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Cours');
		return $tableau;
	}



    static function readOne($id) {
        $sql= 'select * from cours where id_cours = :valeur';

        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':valeur', $id, PDO::PARAM_INT);
        $query->execute();

        $objet = $query->fetchObject('Cours');

        return $objet;
    }


    function update($id) {
        $sql = 'UPDATE cours SET titre_cours = :titre_cours, desc_cours = :desc_cours, prix_cours = :prix_cours, type_cours = :type_cours WHERE id_cours = :id';

        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $this->id_cours, PDO::PARAM_INT);
        $query->bindValue(':titre_cours', $this->titre_cours, PDO::PARAM_STR);
        $query->bindValue(':desc_cours', $this->desc_cours, PDO::PARAM_STR);
        $query->bindValue(':prix_cours', $this->prix_cours, PDO::PARAM_STR);
        $query->bindValue(':type_cours', $this->type_cours, PDO::PARAM_STR);
        $query->execute();
        return [];
    }


    function create() {
        $sql = 'INSERT INTO cours (titre_cours, desc_cours, prix_cours, type_cours, id_user) VALUES (:titre_cours, :desc_cours, :prix_cours, :type_cours, :id_user);';
        $pdo = connexion();

        $query = $pdo->prepare($sql);
        $query->bindValue(':titre_cours', $this->titre_cours, PDO::PARAM_STR);
        $query->bindValue(':desc_cours', $this->desc_cours, PDO::PARAM_STR);
        $query->bindValue(':prix_cours', $this->prix_cours, PDO::PARAM_STR);
        $query->bindValue(':type_cours', $this->type_cours, PDO::PARAM_STR);
        $query->bindValue(':id_user', $this->id_user, PDO::PARAM_INT);
        $query->execute();
        $this->id_cours = $pdo->lastInsertId();
        return [];
    }


    static function delete($id) {
        $sql = 'DELETE FROM cours WHERE id_cours = :id_cours';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id_cours', $id, PDO::PARAM_INT);
        $query->execute();
    }

    static function nombre_cours() { // pour compter le nombre de cours existants dans le dashoard de l'administrateur
        $sql = 'SELECT COUNT(*) FROM cours';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->execute();
        $nombre_cours = $query->fetchColumn();
        return $nombre_cours;
    }

}
