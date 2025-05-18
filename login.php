<?php
header('Content-Type: application/json');
require_once 'db.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Email and password are required."]);
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $redirect = match ($user['role']) {
            'admin' => 'admin.html',
            'agent' => 'dendometrique.html',
            'analyste' => 'analyse.html',
            'conservation' => 'ajout.html',
            'surveillance' => 'surveillance.html',
            'public' => 'voir_donnees.html',
            default => 'index.html',
        };
        echo json_encode(["success" => true, "redirect" => $redirect]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid email or password."]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
?>