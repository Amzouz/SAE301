<?php
//Classe User avec toutes les fonctions liées aux utilisateurs

class User {
    public $id_user;
    public $mail;
    public $nom;
    public $prenom;
    public $pseudo;
    public $tel;
    public $rgpd;
    public $mot_de_passe;
    public $role;

    function chargePOST() {
        $erreurs = [];

        if (isset($_POST['id_user'])) {
            $this->id_user = $_POST['id_user'];
        }

        if (isset($_POST['mail']) && !empty($_POST['mail'])) {
            $this->mail = $_POST['mail'];
            $this->mail = trim($this->mail);
            $this->mail = htmlspecialchars($this->mail);
            $this->mail = strip_tags($this->mail);
        } else {
            $erreurs['mail'] = 'Le mail est obligatoire';
        }


        if (isset($_POST['nom']) && !empty($_POST['nom'])) {
            $this->nom = $_POST['nom'];
            $this->nom = strip_tags($this->nom);
        } else {
            $erreurs['nom'] = 'Le nom est obligatoire';
        }

        if (isset($_POST['prenom']) && !empty($_POST['prenom'])) {
            $this->prenom = $_POST['prenom'];
            $this->prenom = strip_tags($this->prenom);
        } else {
            $erreurs['prenom'] = 'Le prénom est obligatoire';
        }

        if (isset($_POST['pseudo']) && !empty($_POST['pseudo'])) {
            $this->pseudo = $_POST['pseudo'];
            $this->pseudo = strip_tags($this->pseudo);
        } else {
            $erreurs['pseudo'] = 'Le pseudo est obligatoire';
        }

        if (isset($_POST['tel']) && !empty($_POST['tel'])) {
            $this->tel = $_POST['tel'];
            $this->tel = trim($this->tel);
            $this->tel = htmlspecialchars($this->tel);
            $this->tel = strip_tags($this->tel);
        } else {
            $this->tel = null;
        }

        if (isset($_POST['rgpd'])) {
            // Checkbox cochée → on met la date actuelle
            $this->rgpd = date("Y-m-d H:i:s");
        } else {
            // Checkbox non cochée → pas de consentement
            $erreurs['rgpd'] = 'Vous devez accepter les conditions d\'utilisation';
        }

        if (isset($_POST['mot_de_passe']) && !empty($_POST['mot_de_passe'])) {
            $this->mot_de_passe = $_POST['mot_de_passe'];
        } else {
            $erreurs['mot_de_passe'] = 'Le mot de passe est obligatoire';
        }

        if (isset($_POST['role']) && !empty($_POST['role'])) {
            $this->role = $_POST['role'];
            $this->role = htmlspecialchars($this->role);
            $this->role = strip_tags($this->role);
        }

        return $erreurs;
    }


    static function readAll() {
		$sql = 'select * from user';

		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->execute();

		$tableau = $query->fetchAll(PDO::FETCH_CLASS, 'User');
		return $tableau;
	}


    static function readOne($id) {
        $sql= 'select * from user where id_user = :valeur';

        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':valeur', $id, PDO::PARAM_INT);
        $query->execute();

        $objet = $query->fetchObject('User');

        return $objet;
    }


    function create() {
		// définit la requête
		$sql = 'INSERT INTO user (mail, nom, prenom, pseudo, tel, rgpd, mot_de_passe, role)
				VALUES (:mail, :nom, :prenom, :pseudo, :tel, NOW(), :mot_de_passe, :role)';

		// prépare et exécute la requête
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':mail', $this->mail, PDO::PARAM_STR);
		$query->bindValue(':nom', $this->nom, PDO::PARAM_STR);
		$query->bindValue(':prenom', $this->prenom, PDO::PARAM_STR);
        $query->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        if ($this->tel !== null) {
            $query->bindValue(':tel', $this->tel, PDO::PARAM_INT);
        } else {
            $query->bindValue(':tel', null, PDO::PARAM_NULL);
        }
        $query->bindValue(':mot_de_passe', $this->mot_de_passe, PDO::PARAM_STR);
        $query->bindValue(':role', $this->role, PDO::PARAM_STR);
		$query->execute();

		// récupère la clé de l'auteur créé (auto-incrément)
		$this->id_user = $pdo->lastInsertId();
	}

    function checkMail() { //pour voir si un mmail existe déja dans la base de donnée lors de la création de compte
    	  $sql = 'select * from user where mail = :mail';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $query->execute();
        $objet = $query->fetchObject('User');
        return $objet;
    }

    function checkUser() //pour voir si le compte existe bien lors de la connexion à un compte
	{
		$sql = 'select * from user where mail = :mail and mot_de_passe = :mot_de_passe';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':mail', $this->mail, PDO::PARAM_STR);
		$query->bindValue(':mot_de_passe', $this->mot_de_passe, PDO::PARAM_STR);
		$query->execute();
		$objet = $query->fetchObject('User');
		return $objet;
	}

    function update_role($id) { //pour que l'admin change les rôles des utilisateurs
        $sql = 'UPDATE user SET role = :role WHERE id_user = :id';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $this->id_user, PDO::PARAM_INT);
        $query->bindValue(':role', $this->role, PDO::PARAM_STR);
        $query->execute();
        return [];
    }

    function update_profil($id) { //pour qu'un utilisateur puisse changer ses informations personnelles dans le profil
        $sql = 'UPDATE user SET mail = :mail, nom = :nom, prenom = :prenom, pseudo = :pseudo, tel = :tel, mot_de_passe = :mot_de_passe WHERE id_user = :id';

        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $query->bindValue(':nom', $this->nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $this->prenom, PDO::PARAM_STR);
        $query->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        $query->bindValue(':tel', $this->tel, PDO::PARAM_STR);
        $query->bindValue(':mot_de_passe', $this->mot_de_passe, PDO::PARAM_STR);
        $query->execute();
        return [];
    }

    static function nombre_user() { //compte le nombres d'utilisateurs du site pour le dashboard
        $sql = 'SELECT COUNT(*) FROM user';
        $pdo = connexion();
        $query = $pdo->prepare($sql);
        $query->execute();
        $nombre_user = $query->fetchColumn();
        return $nombre_user;
    }
}







