<?php
// Fonction pour afficher les fichiers par bureau
function displayFilesByOffice($directory, $officeName) {
    // Vérifier si le répertoire du bureau existe
    $officeDirectory = $directory . '/' . $officeName;
    if (is_dir($officeDirectory)) {
        $files = scandir($officeDirectory);
        // Enlever les fichiers . et ..
        $files = array_diff($files, array('.', '..'));

        // Vérifier s'il y a des fichiers dans ce répertoire
        if (empty($files)) {
            echo "<p>لا توجد ملفات محفوظة في $officeName.</p>";
        } else {
            echo "<div class='office-zone'>";
            echo "<h4>$officeName</h4>";  // Titre du bureau
            echo "<ul>";
            foreach ($files as $file) {
                echo "<li><a href='$officeDirectory/$file' target='_blank'>$file</a></li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    } else {
        echo "<p>لا يوجد دليل لـ $officeName. Vérifiez si le répertoire '$officeDirectory' existe.</p>";
    }
}

// Fonction pour gérer l'upload du fichier
function handleFileUpload($file, $directory, $officeName) {
    $targetDir = $directory . '/' . $officeName . '/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Créer le répertoire si il n'existe pas
    }

    $targetFile = $targetDir . basename($file["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image, PDF, ou autre type autorisé
    if ($file["size"] > 500000) { // Limiter la taille du fichier à 500 Ko (par exemple)
        echo "Désolé, votre fichier est trop grand.";
        $uploadOk = 0;
    }

    // Vérifier le type de fichier (image, pdf, etc.)
    if ($uploadOk == 1) {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            echo "Le fichier " . htmlspecialchars(basename($file["name"])) . " a été téléchargé avec succès.";
        } else {
            echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملفات المحفوظة للمصالح والمكاتب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            text-align: center;
            padding-top: 50px;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        h2 {
            color: #2c3e50;
        }

        h3 {
            color: #34495e;
        }

        h4 {
            color: #2980b9;
            margin-top: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .office-zone {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .office-zone h4 {
            font-size: 20px;
            color: #2c3e50;
        }

        .office-zone ul {
            margin-top: 10px;
        }

        input[type="file"] {
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
            width: 100%;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <h2>الملفات المحفوظة للمصالح والمكاتب</h2>

    <div class="container">
        <!-- Afficher les fichiers pour chaque bureau -->
        
        <?php
            // Liste des bureaux pour lesquels vous voulez afficher les fichiers
            $offices = [
                'bureau_tawassia',
                'bureau_gard',
                'bureau_police',
                'bureau_etudes',
                'bureau_protections',
                'bureau_prevention',
                'bureau_rh',
                'bureau_budget'
            ];

            // Affichage des fichiers pour chaque bureau
            foreach ($offices as $office) {
                echo "<div class='office-zone'>";
                echo "<h4>$office</h4>";
                
                // Formulaire de téléchargement de fichiers
                echo "<form action='' method='POST' enctype='multipart/form-data'>";
                echo "<input type='file' name='fileToUpload' id='fileToUpload'>";
                echo "<button type='submit' name='upload'>Télécharger le fichier</button>";
                echo "</form>";

                // Si un fichier a été téléchargé, appelez la fonction pour le gérer
                if (isset($_POST['upload'])) {
                    if (isset($_FILES['fileToUpload'])) {
                        $file = $_FILES['fileToUpload'];
                        handleFileUpload($file, 'uploads', $office); // Appel de la fonction pour uploader le fichier
                    }
                }

                // Afficher les fichiers sauvegardés pour ce bureau
                displayFilesByOffice('uploads', $office);
                echo "</div>";
            }
        ?>
    </div>

</body>
</html>
