<?php
//Là c'est des fonctions pour permettre les accès à des rôles et pas à d'autres, on les a trouvé avec Terence

// Fonction qui vérifie les rôles utilisateur pour donner les accès
//ya que le rôle qu'on précise et l'admin qui ont le droit d'accéder à certaines fonctionnalités, exemple : créer un cours = que pour les musiciens
function requireRole($role) {
    if (empty($_SESSION['role']) || ($_SESSION['role'] !== $role && $_SESSION['role'] !== 'administrateur')) {
    header('Location: index.php');
    exit();
    }
}


// Permet de vérifier si le contenu appartient à un utilisateur spécifique
// C'est pour éviter que des personnes visiteurs viennent modifier les annonces d'instruments d'autres visiteurs, ou que des musiciens modifient des cours qu'ils n'ont pas créé
function checkOwner($id_user) {
    // Vérifier que la session existe
    if (!isset($_SESSION['id_user'])) {
        return false;
    }

    return $_SESSION['id_user'] == $id_user || (isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur');
}
//L'admin peut tout faire lui
