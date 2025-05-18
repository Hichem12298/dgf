<?php
header('Content-Type: application/json');
require 'db.php';

if (!isset($_GET['id'])) {
    echo json_encode(["success" => false, "message" => "ID utilisateur manquant."]);
    exit();
}

$id = intval($_GET['id']);

try {
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Utilisateur supprimé avec succès."]);
    } else {
        echo json_encode(["success" => false, "message" => "Aucun utilisateur trouvé avec cet ID."]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur de base de données : " . $e->getMessage()]);
}
?>