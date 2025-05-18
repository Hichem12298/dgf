<?php
// Configuration de la connexion à la base de données
$host = "localhost"; // Remplace par l'adresse de ton serveur
$dbname = "ta_base_de_donnees"; // Remplace par le nom de ta base de données
$username = "ton_utilisateur"; // Remplace par ton nom d'utilisateur MySQL
$password = "ton_mot_de_passe"; // Remplace par ton mot de passe MySQL

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les données du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            die("L'email existe déjà.");
        }

        // Hacher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertion de l'utilisateur dans la base de données
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, password, role, accepte) 
                VALUES (?, ?, ?, ?, ?, 1)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $hashed_password, $role]);

        // Return a JSON response indicating success
        echo json_encode(["success" => true, "message" => "Utilisateur ajouté avec succès !"]);
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
