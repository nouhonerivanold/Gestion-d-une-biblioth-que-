<?php
    $xmlFile = "Livre.xml";

    // Vérifie si le fichier XML existe
    if (!file_exists($xmlFile)) {
        die("Le fichier XML n'existe pas.");
    }

    $xml = simplexml_load_file($xmlFile);

    // Vérifie que le chargement a réussi
    if ($xml === false) {
        die("Erreur lors du chargement du fichier XML.");
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="iso-8859-1">
    <title>Liste des Livres</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
            margin: auto;
        }
        th, td {
            border: 1px solid #666;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ccc;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Liste des Livres</h1>
    <table>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Date</th>
        </tr>
        <?php foreach ($xml->livre as $livre): ?>
        <tr>
            <td><?php echo htmlspecialchars($livre->titre); ?></td>
            <td><?php echo htmlspecialchars($livre->auteur); ?></td>
            <td><?php echo htmlspecialchars($livre->date); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
