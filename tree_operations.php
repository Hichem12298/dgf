<?php
require_once 'db.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$action = $_GET['action'] ?? $input['action'] ?? '';

try {
    if ($action === 'create') {
        $data = $input['data'] ?? [];

        $sql = "INSERT INTO dendometrique (location, species, diameter, height) VALUES (:location, :species, :diameter, :height)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':location' => $data['location'],
            ':species' => $data['species'],
            ':diameter' => $data['diameter'],
            ':height' => $data['height']
        ]);

        echo json_encode(['success' => true]);
    } elseif ($action === 'read') {
        $sql = "SELECT * FROM dendometrique";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $data]);
    } elseif ($action === 'delete') {
        $id = $input['id'] ?? 0;

        $sql = "DELETE FROM dendometrique WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Action non reconnue.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>