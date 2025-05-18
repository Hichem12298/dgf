<?php
header('Content-Type: application/json');
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $espece = $_POST['espece'] ?? null;
    $diametre = $_POST['diametre'] ?? null;
    $hauteur = $_POST['hauteur'] ?? null;
    $localisation = $_POST['localisation'] ?? null;

    // Ajouter des journaux pour vérifier les données reçues
    error_log("Données reçues : " . json_encode($_POST));

    // Vérifier si des champs sont manquants
    if (!$espece || !$diametre || !$hauteur || !$localisation) {
        error_log("Champs manquants : espece=$espece, diametre=$diametre, hauteur=$hauteur, localisation=$localisation");
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
        exit;
    }

    try {
        // Insérer les données dans la table 'donnee'
        $stmt = $pdo->prepare("INSERT INTO donnees_dendrometriques (espece, diametre, hauteur, localisation) VALUES (?, ?, ?, ?)");
        $stmt->execute([$espece, $diametre, $hauteur, $localisation]);

        echo json_encode(['success' => true, 'message' => 'Donnée ajoutée avec succès.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}