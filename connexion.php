<?php
session_start();

// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=gestion_entites;charset=utf8";
$user = "root";  // Change selon ton serveur
$pass = "";  // Mot de passe MySQL (souvent vide sur XAMPP)

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Vérifier si l'utilisateur administrateur existe, sinon l'ajouter automatiquement
    $adminEmail = "administrateur@gmail.com";
    $adminPassword = "123"; // Mot de passe par défaut

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$adminEmail]);
    $existingAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingAdmin) {
        $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, password, role, accepte) VALUES (?, ?, ?, ?)");
        $stmt->execute([$adminEmail, $hashedPassword, 'admin', true]);
        error_log("Administrateur ajouté automatiquement.");
    }

    // Vérification des identifiants de connexion
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if (empty($email) || empty($password)) {
            echo json_encode(["status" => "error", "message" => "Veuillez remplir tous les champs."]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                "id" => $user['id'],
                "email" => $user['email'],
                "role" => $user['role']
            ];

            // Retourner uniquement les informations de l'utilisateur pour l'interface
            echo json_encode([
                "status" => "success",
                "message" => "Connexion réussie !",
                "user" => $_SESSION['user']
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Identifiants incorrects."]);
        }
    }
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
