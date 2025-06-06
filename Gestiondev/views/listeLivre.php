<?php
    include ("../controller/controllerListeLivre.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Livres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/listeLivre.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Liste des Livres</h2>
        <div class="table-responsive">
            <table class="table table-striped" id="tableEtages">
                <thead class="table-dark">
                    <tr>
                        <th>titre</th>
                        <th>Editeur</th>
                        <th>prix</th>
                        <th>disponible</th>
                        <th>quantite</th>
                        <th>modifier</th>
                        <th>supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listeLivre as $livre) {
                        if ($livre["dispo"] == 1) {
                            echo "<tr><td>".$livre["titre"]."</td><td>".$livre["editeur"]."</td><td>".$livre["prix"]."</td><td>true</td><td>".$livre["qte"]."</td> <td><a href=\"../controller/modifierLivre.php?idLivre=".$livre["ref_livre"]."\">modifier</a></td><td><a href=\"../controller/supprimerLivre.php?idLivre=".$livre["ref_livre"]."\">supprimer</a></td></tr>";
                        }
                        else {
                            echo "<tr><td>".$livre["titre"]."</td><td>".$livre["editeur"]."</td><td>".$livre["prix"]."</td><td>false</td><td>".$livre["qte"]."</td> <td><a href=\"../controller/modifierLivre.php?idLivre=".$livre["ref_livre"]."\">modifier</a></td><td><a href=\"../controller/supprimerLivre.php?idLivre=".$livre["ref_livre"]."\">supprimer</a></td></tr>";
                        }
                    }  ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="./Javascript/listeLivre.js"></script>
</body>
</html>