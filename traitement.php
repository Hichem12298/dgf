<?php
// Inclusion du fichier de connexion à la base de données
include 'db.php';

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formulaire Forêt
    if (isset($_POST['submit_foret'])) {
        $nom_foret = $_POST['nom_foret'];
        $localisation_foret = $_POST['localisation_foret'];
        
        // SQL pour insérer les données dans la table Foret
        $sql = "INSERT INTO Foret (nom, localisation) VALUES (:nom, :localisation)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom', $nom_foret);
        $stmt->bindParam(':localisation', $localisation_foret);
        
        // Exécuter la requête
        $stmt->execute();
    }

    // Pour chaque autre entité, vous répétez un processus similaire...
    // Par exemple pour Canton, Espèce, etc.

    echo "Les données ont été enregistrées avec succès !";
}
?>
