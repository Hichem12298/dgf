<?php
header('Content-Type: application/json');
require_once 'db.php';

if (!isset($_GET['id'])) {
    echo json_encode(["success" => false, "message" => "ID utilisateur manquant."]);
    exit();
}

$id = intval($_GET['id']);

try {
    // Ensure the ID exists before updating
    $checkStmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE id = ?");
    $checkStmt->execute([$id]);

    if ($checkStmt->rowCount() === 0) {
        echo json_encode(["success" => false, "message" => "Aucun utilisateur trouvé avec cet ID."]);
        exit();
    }

    // Update the 'accepte' field to 1
    $stmt = $pdo->prepare("UPDATE utilisateurs SET accepte = 1 WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["success" => true, "message" => "Utilisateur validé avec succès."]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur de base de données : " . $e->getMessage()]);
}
?>