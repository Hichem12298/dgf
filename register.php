<?php
header('Content-Type: application/json');
require_once 'db.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $role = $data['role'] ?? '';

    if (empty($email) || empty($password) || empty($role)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Email is already registered."]);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, password, role, accepte) VALUES (?, ?, ?, 1)");
    $stmt->execute([$email, $hashed_password, $role]);

    echo json_encode(["success" => true, "message" => "Registration successful."]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
?>