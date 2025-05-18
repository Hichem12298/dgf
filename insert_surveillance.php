<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $speciesName = $_POST['speciesName'] ?? '';
    $speciesLocation = $_POST['speciesLocation'] ?? '';
    $speciesHeight = $_POST['speciesHeight'] ?? 0;
    $speciesWidth = $_POST['speciesWidth'] ?? 0;
    $speciesArea = $_POST['speciesArea'] ?? 0;
    $speciesDate = $_POST['speciesDate'] ?? '';

    if (empty($speciesName) || empty($speciesLocation) || empty($speciesDate)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs obligatoires doivent être remplis.']);
        exit;
    }

    try {
        // Vérifier si les données existent déjà
        $checkSql = "SELECT * FROM surveillance_data WHERE species_name = :speciesName AND location = :speciesLocation";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([
            ':speciesName' => $speciesName,
            ':speciesLocation' => $speciesLocation
        ]);

        $existingData = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingData) {
            // Vérifier si les données sont identiques
            $hasChanged = (
                $existingData['height'] != $speciesHeight ||
                $existingData['width'] != $speciesWidth ||
                $existingData['area'] != $speciesArea ||
                $existingData['observation_date'] != $speciesDate
            );

            if (!$hasChanged) {
                echo json_encode(['success' => false, 'message' => 'Les données n\'ont pas changé.']);
                exit;
            }

            // Mettre à jour uniquement les données modifiées
            $updateSql = "UPDATE surveillance_data SET height = :speciesHeight, width = :speciesWidth, area = :speciesArea, observation_date = :speciesDate WHERE id = :id";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                ':speciesHeight' => $speciesHeight,
                ':speciesWidth' => $speciesWidth,
                ':speciesArea' => $speciesArea,
                ':speciesDate' => $speciesDate,
                ':id' => $existingData['id']
            ]);

            echo json_encode(['success' => true, 'message' => 'Les données ont été mises à jour.']);
        } else {
            // Insérer de nouvelles données
            $insertSql = "INSERT INTO surveillance_data (species_name, location, height, width, area, observation_date) VALUES (:speciesName, :speciesLocation, :speciesHeight, :speciesWidth, :speciesArea, :speciesDate)";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->execute([
                ':speciesName' => $speciesName,
                ':speciesLocation' => $speciesLocation,
                ':speciesHeight' => $speciesHeight,
                ':speciesWidth' => $speciesWidth,
                ':speciesArea' => $speciesArea,
                ':speciesDate' => $speciesDate
            ]);

            echo json_encode(['success' => true, 'message' => 'Les données ont été enregistrées avec succès.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}
?>