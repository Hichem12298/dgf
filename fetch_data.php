<?php
header("Content-Type: application/json");

require 'db.php';

$results = [];

function fetchAll($pdo, $table, $type) {
    $stmt = $pdo->query("SELECT * FROM $table");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return array_map(fn($row) => ['type' => $type, 'data' => $row], $data);
}

try {
    $results = array_merge(
        fetchAll($pdo, "espece", "espece"),
        fetchAll($pdo, "foret", "foret"),
        fetchAll($pdo, "canton", "canton"),
        fetchAll($pdo, "conservation", "conservation"),
        fetchAll($pdo, "circonscription", "circonscription"),
        fetchAll($pdo, "district", "district"),
        fetchAll($pdo, "agent", "agent"),
        fetchAll($pdo, "analyste", "analyste"),
        fetchAll($pdo, "analyse", "analyse"),
        fetchAll($pdo, "operation", "operation"),
        fetchAll($pdo, "donnee", "donnee")
    );

    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>