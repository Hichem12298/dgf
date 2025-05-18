<?php
header("Content-Type: application/json");

require 'db.php';

try {
    $stmt = $pdo->query("SELECT id, nom FROM foret");
    $forets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($forets);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>