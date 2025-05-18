<?php
header('Content-Type: application/json');
require 'db.php';

// Récupérer les données envoyées
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$type = $data['type'] ?? null;

// Ajouter des journaux pour déboguer
error_log("Données reçues : " . json_encode($data));

if (!$id || !$type) {
    error_log("ID ou type manquant : ID = $id, Type = $type");
    echo json_encode(['success' => false, 'error' => 'ID ou type manquant.']);
    exit;
}

try {
    // Préparer la requête SQL en fonction du type d'entité
    switch ($type) {
        case 'espece':
            $sql = "DELETE FROM Espece WHERE id = ?";
            break;
        case 'foret':
            $sql = "DELETE FROM Foret WHERE id = ?";
            break;
        case 'canton':
            $sql = "DELETE FROM Canton WHERE id = ?";
            break;
        case 'conservation':
            $sql = "DELETE FROM Conservation WHERE id = ?";
            break;
        case 'circonscription':
            $sql = "DELETE FROM Circonscription WHERE id = ?";
            break;
        case 'district':
            $sql = "DELETE FROM District WHERE id = ?";
            break;
        case 'agent':
            $sql = "DELETE FROM Agent WHERE id = ?";
            break;
        case 'analyste':
            $sql = "DELETE FROM Analyste WHERE id = ?";
            break;
        case 'analyse':
            $sql = "DELETE FROM Analyse WHERE id = ?";
            break;
        case 'operation':
            $sql = "DELETE FROM Operation WHERE id = ?";
            break;
        case 'donnee':
            $sql = "DELETE FROM Donnee WHERE id = ?";
            break;
        default:
            echo json_encode(['success' => false, 'error' => 'Type d\'entité non reconnu.']);
            exit;
    }

    // Exécuter la requête de suppression
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    // Vérifier si une ligne a été affectée
    if ($stmt->rowCount() > 0) {
        error_log("Entité supprimée avec succès : ID = $id, Type = $type");
        echo json_encode(['success' => true, 'message' => 'Entité supprimée avec succès.']);
    } else {
        error_log("Aucune entité trouvée pour suppression : ID = $id, Type = $type");
        echo json_encode(['success' => false, 'error' => 'Aucune entité trouvée pour suppression.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erreur : ' . $e->getMessage()]);
}
