<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "username", "password", "database_name");

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Supposons que vous ayez l'ID du fichier dans l'URL
$fileId = $_GET['id'];

// Récupérer le chemin du fichier à partir de la base de données
$sql = "SELECT * FROM files WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $fileId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $filePath = $row['file_path']; // Le chemin du fichier dans la base de données
    
    // Vérifiez si le fichier existe sur le serveur
    if (file_exists($filePath)) {
        // Télécharger le fichier
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        readfile($filePath);  // Lire et envoyer le fichier au navigateur
        exit;
    } else {
        echo "Fichier non trouvé.";
    }
} else {
    echo "Fichier non trouvé dans la base de données.";
}

$conn->close();
?>
