<?php
header('Content-Type: application/json');
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $type = $data['type'] ?? '';
    $fields = $data['data'] ?? [];

    // Whitelist of allowed table names
    $allowedTables = ['espece', 'foret', 'canton', 'conservation', 'circonscription', 'district', 'agent', 'analyste', 'analyse', 'operation', 'donnee'];

    if (empty($type) || empty($fields) || !in_array($type, $allowedTables)) {
        echo json_encode(['success' => false, 'error' => 'Type invalide ou données manquantes.']);
        exit;
    }

    try {
        // Check if ID already exists
        if (isset($fields['id'])) {
            $checkSql = "SELECT COUNT(*) FROM $type WHERE id = :id";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->bindValue(':id', $fields['id']);
            $checkStmt->execute();

            if ($checkStmt->fetchColumn() > 0) {
                echo json_encode(['success' => false, 'error' => 'L\'ID existe déjà.']);
                exit;
            }
        }

        $columns = implode(", ", array_keys($fields));
        $placeholders = ":" . implode(", :", array_keys($fields));

        $sql = "INSERT INTO $type ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);

        foreach ($fields as $key => $value) {
            $stmt->bindValue(":" . $key, $value);
        }

        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Données insérées avec succès.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur de base de données : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
}
?>