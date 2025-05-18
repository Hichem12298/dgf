<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "arbres";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion");
}

$sql = "SELECT id, species, diameter, height, location, date_enregistrement FROM donnees_dendrometriques ORDER BY id DESC";
$result = $conn->query($sql);

$donnees = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donnees[] = $row;
    }
}

echo json_encode($donnees);
$conn->close();
?>
