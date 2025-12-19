<?php
//Classe Instrument avec les fonctions associées

class Instruments {
    public $id_instru;
    public $nom_instru;
    public $desc_instru;
    public $prix_instru;
    public $type_instru;
    public $reference_instru;
    public $etat_instru;
    public $date_post_instru;
    public $id_user;
    public $visible_instru;


    function chargePOST($id_user) {
        $erreurs = [];

        if (isset($_POST['id_instru'])) {
            $this->id_instru = $_POST['id_instru'];
        }

        if (isset($_POST['nom_instru']) && !empty($_POST['nom_instru'])) {
            $this->nom_instru = $_POST['nom_instru'];
            $this->nom_instru = strip_tags($this->nom_instru);
        } else {
            $erreurs['nom_instru'] = 'Le nom de l\'instrument est obligatoire';
        }

        if (isset($_POST['desc_instru']) && !empty($_POST['desc_instru'])) {
            $this->desc_instru = $_POST['desc_instru'];
            $this->desc_instru = strip_tags($this->desc_instru);
        } else {
            $erreurs['desc_instru'] = 'La description de l\'instrument est obligatoire';
        }

        if (isset($_POST['prix_instru']) && !empty($_POST['prix_instru'])) {
            $this->prix_instru = $_POST['prix_instru'];
            if (!is_numeric($this->prix_instru) || $this->prix_instru < 0) {
                $erreurs['prix_instru'] = 'Le prix doit être un nombre positif';
            }
        } else {
            $erreurs['prix_instru'] = 'Le prix de l\'instrument est obligatoire';
        }

        if (isset($_POST['type_instru']) && !empty($_POST['type_instru'])) {
            $this->type_instru = $_POST['type_instru'];
            $this->type_instru = htmlspecialchars($this->type_instru);
            $this->type_instru = strip_tags($this->type_instru);
        } else {
            $erreurs['type_instru'] = 'Le type d\'instrument est obligatoire';
        }

        if (isset($_POST['reference_instru']) && !empty($_POST['reference_instru'])) {
            $this->reference_instru = $_POST['reference_instru'];
            $this->reference_instru = strip_tags($this->reference_instru);
        } else {
            $erreurs['reference_instru'] = 'La référence de l\'instrument est obligatoire';
        }

        if (isset($_POST['etat_instru']) && !empty($_POST['etat_instru'])) {
            $this->etat_instru = $_POST['etat_instru'];
            $this->etat_instru = htmlspecialchars($this->etat_instru);
            $this->etat_instru = strip_tags($this->etat_instru);
        } else {
            $erreurs['etat_instru'] = 'L\'état de l\'instrument est obligatoire';
        }

        $this->id_user = $id_user;

        if (isset($_POST['visible_instru'])) {
            $this->visible_instru = $_POST['visible_instru'];
        }

        return $erreurs;
    }


    static function readAll()
	{
		$sql = 'select * from instruments';

		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->execute();

		$tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Instruments');
		return $tableau;
	}


    static function readOne($id) {
        $sql= 'select * from instruments where id_instru = :valeur';

        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':valeur', $id, PDO::PARAM_INT);
        $query->execute();

        $objet = $query->fetchObject('Instruments');

        return $objet;
    }


    function update($id) {
        $sql = 'UPDATE instruments SET nom_instru = :nom_instru, desc_instru = :desc_instru, prix_instru = :prix_instru, type_instru = :type_instru, reference_instru = :reference_instru, etat_instru = :etat_instru, visible_instru = :visible_instru WHERE id_instru = :id';

        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $this->id_instru, PDO::PARAM_INT);
        $query->bindValue(':nom_instru', $this->nom_instru, PDO::PARAM_STR);
        $query->bindValue(':desc_instru', $this->desc_instru, PDO::PARAM_STR);
        $query->bindValue(':prix_instru', $this->prix_instru, PDO::PARAM_STR);
        $query->bindValue(':type_instru', $this->type_instru, PDO::PARAM_STR);
        $query->bindValue(':reference_instru', $this->reference_instru, PDO::PARAM_STR);
        $query->bindValue(':etat_instru', $this->etat_instru, PDO::PARAM_STR);
        $query->bindValue(':visible_instru', $this->visible_instru, PDO::PARAM_STR); //visible_instru = si l'annonce est visible ou non (changement client du 18/12)
        $query->execute();
        return [];
    }


    function create() {
        $sql = 'INSERT INTO instruments (nom_instru, desc_instru, prix_instru, type_instru, reference_instru, etat_instru, id_user, visible_instru) VALUES (:nom_instru, :desc_instru, :prix_instru, :type_instru, :reference_instru, :etat_instru, :id_user, :visible_instru);';
        $pdo = connexion();

        $query = $pdo->prepare($sql);
        $query->bindValue(':nom_instru', $this->nom_instru, PDO::PARAM_STR);
        $query->bindValue(':desc_instru', $this->desc_instru, PDO::PARAM_STR);
        $query->bindValue(':prix_instru', $this->prix_instru, PDO::PARAM_STR);
        $query->bindValue(':type_instru', $this->type_instru, PDO::PARAM_STR);
        $query->bindValue(':reference_instru', $this->reference_instru, PDO::PARAM_STR);
        $query->bindValue(':etat_instru', $this->etat_instru, PDO::PARAM_STR);
        $query->bindValue(':id_user', $this->id_user, PDO::PARAM_INT);
        $query->bindValue(':visible_instru', $this->visible_instru, PDO::PARAM_STR);
        $query->execute();
        $this->id_instru = $pdo->lastInsertId();
        return [];
    }


    static function delete($id) {
        $sql = 'DELETE FROM instruments WHERE id_instru = :id_instru';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id_instru', $id, PDO::PARAM_INT);
        $query->execute();
    }


    static function nombre_instruments() { //compte le nombre d'annonces instruments total pour le dashboard admin
        $sql = 'SELECT COUNT(*) FROM instruments';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->execute();
        $nombre_instruments = $query->fetchColumn();
        return $nombre_instruments;
    }

    static function annonces_user($id) { // pour que chaque utilisateur voit ses annonces dans le profil
        $sql = 'SELECT * FROM instruments WHERE id_user = :id';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Instruments');
        return $tableau;
    }

    function update_visible($id) { //pour que le responsable_annonces actualise la donnée "visible_instru" des annonces instruments (changement client du 18/12)
        $sql = 'UPDATE instruments SET visible_instru = :visible_instru WHERE id_instru = :id';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':visible_instru', $this->visible_instru, PDO::PARAM_INT);
        $query->execute();
        return [];
    }

}
