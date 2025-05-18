<?php
session_start();
$host = 'localhost'; // Votre hôte de base de données
$user = 'root'; // Votre utilisateur de base de données
$password = ''; // Votre mot de passe de base de données
$dbname = 'conservation_forêts'; // Nom de votre base de données

// Connexion à la base de données MySQL
$conn = new mysqli($host, $user, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Inscription d'un nouvel utilisateur
if (isset($_POST['inscription'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hasher le mot de passe
    $role = $_POST['role'];

    $sql = "INSERT INTO utilisateurs (email, password, role) VALUES ('$email', '$password', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

// Connexion d'un utilisateur existant
if (isset($_POST['connexion'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: website.html"); // Rediriger vers la page d'accueil après connexion
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }
}

$conn->close();
?>
