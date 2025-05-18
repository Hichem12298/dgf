<?php
$pdo = new PDO("mysql:host=localhost;dbname=gestion_entites;charset=utf8", "root", "");
$donnees = $pdo->query("SELECT * FROM donnees_dendrometriques")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Données Enregistrées</title>
    <style>
        body { font-family: Arial; background-color: #f9f9f9; padding: 20px; }
        table { width: 90%; margin: auto; border-collapse: collapse; background: #fff; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #2c3e50; color: white; }
        .btn-delete { background: red; color: white; border: none; padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>

<h2>Données Dendrométriques Enregistrées</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Espèce</th>
        <th>Diamètre (cm)</th>
        <th>Hauteur (m)</th>
        <th>Localisation</th>
        <th>Action</th>
    </tr>

    <?php foreach ($donnees as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d['id']) ?></td>
            <td><?= htmlspecialchars($d['espece']) ?></td>
            <td><?= htmlspecialchars($d['diametre']) ?></td>
            <td><?= htmlspecialchars($d['hauteur']) ?></td>
            <td><?= htmlspecialchars($d['localisation']) ?></td>
            <td>
                <form action="supprimer_donnee.php" method="POST" onsubmit="return confirm('Supprimer ?');">
                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                    <button type="submit" class="btn-delete">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault(); // Empêcher le rechargement de la page

                const formData = new FormData(this);
                const id = formData.get('id');

                try {
                    const response = await fetch('supprimer_donnee.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.text();
                    if (result.includes('succès')) {
                        alert('Donnée supprimée avec succès !');
                        this.closest('tr').remove(); // Supprimer la ligne du tableau
                    } else {
                        alert('Erreur : ' + result);
                    }
                } catch (error) {
                    console.error('Erreur lors de la suppression :', error);
                    alert('Une erreur est survenue. Veuillez réessayer.');
                }
            });
        });
    </script>

</body>
</html>
