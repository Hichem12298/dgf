<?php
require_once 'db.php';

header('Content-Type: application/json');

try {
    $sql = "SELECT id, espece, diametre, hauteur, localisation, superficie, date_enregistrement FROM donnees_dendrometrique";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erreur lors de la récupération des données : ' . $e->getMessage()]);
}
?>