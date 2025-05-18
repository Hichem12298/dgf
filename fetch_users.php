<?php
header('Content-Type: application/json');
require 'db.php';

try {
    // Récupérer tous les utilisateurs, qu'ils soient validés ou non
    // Modify the query to include email and password
    $stmt = $pdo->query("SELECT id, email, password, role, accepte FROM utilisateurs");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>