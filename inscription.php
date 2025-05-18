<?php
header('Content-Type: application/json');

// Inclure le fichier de configuration pour la connexion à la base de données
require 'db.php';

// Récupérer les données envoyées en JSON
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier que toutes les données nécessaires sont présentes
if (!empty($data['email']) && !empty($data['password']) && !empty($data['role'])) {
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT); // Hachage du mot de passe
    $role = $data['role'];

    try {
        // Préparer la requête pour insérer un nouvel utilisateur avec 'accepte' par défaut à FALSE
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, password, role, accepte) VALUES (:email, :password, :role, :accepte)");
        $stmt->execute([
            ':email' => $email,
            ':password' => $password,
            ':role' => $role,
            ':accepte' => false // Par défaut, l'utilisateur n'est pas accepté
        ]);

        // Réponse en cas de succès
        echo json_encode(['success' => true, 'message' => 'Inscription réussie. Veuillez attendre l\'activation de votre compte.']);
    } catch (PDOException $e) {
        // Gérer les erreurs, comme un email déjà utilisé
        if ($e->getCode() == 23000) { // Violation de contrainte UNIQUE
            echo json_encode(['success' => false, 'error' => 'Cet email est déjà utilisé.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erreur : ' . $e->getMessage()]);
        }
    }
} else {
    // Réponse en cas de données manquantes
    echo json_encode(['success' => false, 'error' => 'Tous les champs sont obligatoires.']);
}
?>