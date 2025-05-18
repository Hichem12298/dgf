<?php
header('Content-Type: application/json');

require 'db.php';

// Récupérer les données envoyées
$data = json_decode(file_get_contents('php://input'), true);
$type = $data['type'];
$entiteData = $data['data'];

// Préparer la requête SQL en fonction du type d'entité
switch ($type) {
    case 'espece':
        $sql = "INSERT INTO Espece (nom) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['nom']]);
        break;
    case 'foret':
        $sql = "INSERT INTO Foret (nom, superficie) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['nom'], $entiteData['superficie']]);
        break;
    case 'canton':
        $sql = "INSERT INTO Canton (nom, id_foret) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['nom'], $entiteData['id_foret']]);
        break;
    case 'conservation':
        $sql = "INSERT INTO Conservation (nom, adresse, conservateur) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['nom'], $entiteData['adresse'], $entiteData['conservateur']]);
        break;
    case 'circonscription':
        $sql = "INSERT INTO Circonscription (nom, adresse) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['nom'], $entiteData['adresse']]);
        break;
    case 'district':
        $sql = "INSERT INTO District (nom, adresse) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['nom'], $entiteData['adresse']]);
        break;
    case 'agent':
        $sql = "INSERT INTO Agent (nom, prenom, email) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['nom'], $entiteData['prenom'], $entiteData['email']]);
        break;
    case 'analyste':
        $sql = "INSERT INTO Analyste (nom, prenom, email) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['nom'], $entiteData['prenom'], $entiteData['email']]);
        break;
    case 'analyse':
        $sql = "INSERT INTO Analyse (date) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['date']]);
        break;
    case 'operation':
        $sql = "INSERT INTO Operation (nom, description) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['nom'], $entiteData['description']]);
        break;
    case 'donnee':
        $sql = "INSERT INTO Donnee (hauteur, diametre, volume) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$entiteData['hauteur'], $entiteData['diametre'], $entiteData['volume']]);
        break;
    default:
        echo json_encode(['error' => 'Type d\'entité non reconnu']);
        exit;
}

// Réponse en cas de succès
echo json_encode(['message' => 'Entité ajoutée avec succès']);
?>
