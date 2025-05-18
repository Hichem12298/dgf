<?php
header('Content-Type: application/json');
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['type'] ?? '';

    // Whitelist of allowed table names
    $allowedTables = ['espece', 'foret', 'canton', 'conservation', 'circonscription', 'district', 'agent', 'analyste', 'analyse', 'operation', 'donnee', 'donnees_dendrometrique'];

    if (empty($type) || !in_array($type, $allowedTables)) {
        echo json_encode(['success' => false, 'error' => 'Type invalide ou non spécifié.']);
        exit;
    }

    try {
        $sql = "SELECT * FROM $type";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $data]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur de base de données : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
}
?>