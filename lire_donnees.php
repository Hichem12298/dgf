<?php
require_once 'db.php';

header('Content-Type: application/json');

try {
    $sql = "SELECT id, species, diameter, height, location, date_enregistrement FROM dendometrique";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la récupération des données : ' . $e->getMessage()]);
}
?>