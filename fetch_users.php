<?php
header('Content-Type: application/json');
require 'db.php';

try {
    $stmt = $pdo->query("SELECT id, email, role, accepte FROM utilisateurs");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>