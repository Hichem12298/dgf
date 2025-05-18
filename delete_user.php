<?php
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id'])) {
    $userId = $data['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
        $stmt->execute([':id' => $userId]);

        echo json_encode(['success' => true, 'message' => 'Utilisateur supprimé avec succès.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID utilisateur manquant.']);
}
?>