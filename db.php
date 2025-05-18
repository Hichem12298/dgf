<?php
// Connexion à la base de données MySQL
$host = 'localhost';      // L'hôte de la base de données
$dbname = 'gestion_entites';  // Le nom de la base de données
$username = 'root';       // Nom d'utilisateur de MySQL (modifiez selon votre configuration)
$password = '';           // Mot de passe de MySQL (modifiez selon votre configuration)

try {
    // Créer une instance de PDO pour la connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définir l'option pour gérer les erreurs de manière d'exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la connexion échoue, afficher l'erreur
    die("Erreur de connexion : " . $e->getMessage());
}
?>
