<?php
    include ("../controller/controllerListeAdherent.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/listeAdherent.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Liste des Adherents</h2>
        <div class="table-responsive">
        <table class="table table-striped" id="tableEtages">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>adresse</th>
                        <th>restaurer</th>
                        <th>supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listeAdherent as $adherent) {
                        if ($adherent["suspendu"]==1) {
                            echo "<tr><td>".$adherent["nom"]."</td><td>".$adherent["adresse"]."</td> <td><a href=\"../controller/restaurerAdherent.php?idAdh=".$adherent["Id_Adh"]."\">restaurer</a></td><td><a href=\"../controller/supprimerAdherent.php?idAdh=".$adherent["Id_Adh"]."\">supprimer</a></td></tr>";
                        }
                    }  ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="./Javascript/listeAdherent.js"></script>
</body>
</html>


