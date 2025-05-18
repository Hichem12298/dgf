<?php
header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? '';
    $type = $data['type'] ?? '';

    if (empty($id) || empty($type)) {
        echo json_encode(['success' => false, 'error' => 'ID ou type manquant.']);
        exit;
    }

    // Liste des tables autorisées pour éviter les injections SQL
    $allowedTables = ['espece', 'foret', 'canton', 'conservation', 'circonscription', 'district', 'agent', 'analyste', 'analyse', 'operation', 'donnee'];
    if (!in_array($type, $allowedTables)) {
        echo json_encode(['success' => false, 'error' => 'Type de table non autorisé.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM `$type` WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(['success' => true, 'message' => 'Entité supprimée avec succès.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur de base de données : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
}
?>