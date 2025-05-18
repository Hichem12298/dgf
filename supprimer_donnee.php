<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "gestion_entites";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM donnees_dendrometriques WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Donnée supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    echo "ID manquant ou méthode non autorisée.";
}

$conn->close();
?>
