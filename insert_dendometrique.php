<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $espece = $_POST['species'] ?? '';
    $diametre = $_POST['diameter'] ?? 0;
    $hauteur = $_POST['height'] ?? 0;
    $localisation = $_POST['location'] ?? '';
    $superficie = $_POST['superficie'] ?? 0;

    if (empty($espece) || empty($diametre) || empty($hauteur) || empty($localisation) || empty($superficie)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
        exit;
    }

    try {
        $sql = "INSERT INTO donnees_dendrometrique (espece, diametre, hauteur, localisation, superficie) VALUES (:espece, :diametre, :hauteur, :localisation, :superficie)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':espece' => $espece,
            ':diametre' => $diametre,
            ':hauteur' => $hauteur,
            ':localisation' => $localisation,
            ':superficie' => $superficie
        ]);

        echo json_encode(['success' => true, 'message' => 'Donnée ajoutée avec succès.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}
?>