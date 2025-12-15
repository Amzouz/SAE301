<?php

// Fonction qui vérifie les roles utilisateur pour donner les accès
function requireRole($role) {
    if (empty($_SESSION['role']) || ($_SESSION['role'] !== $role && $_SESSION['role'] !== 'Admin')) {
    header('Location: index.php');
    exit();
    }
}

// Permet de vérifier si le contenu appartient à un utilisateur spécifique
function checkOwner($id_user) {
    // Vérifier que la session existe
    if (!isset($_SESSION['id_user'])) {
        return false;
    }

    return $_SESSION['id_user'] == $id_user || (isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur');
}
