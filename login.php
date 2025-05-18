<?php
session_start();
include 'db.php'; // Fichier avec la connexion PDO à la base

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Veuillez remplir tous les champs."]);
        exit;
    }

    // Ajout de journaux pour déboguer
    error_log("Email reçu : $email");

    // Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        error_log("Utilisateur trouvé : " . json_encode($user));
    } else {
        error_log("Utilisateur non trouvé pour l'email : $email");
        echo json_encode(["status" => "error", "message" => "Utilisateur non trouvé."]);
        exit;
    }

    // Vérification du mot de passe
    if (password_verify($password, $user['password'])) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        echo json_encode(["status" => "success", "message" => "Connexion réussie !"]);
    } else {
        error_log("Mot de passe incorrect pour l'utilisateur : $email");
        echo json_encode(["status" => "error", "message" => "Mot de passe incorrect."]);
    }
}
?>
