<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/Livre.css">
    <title>Enregistrement d'un Livre</title>
</head>
<body>
    <div class="form" >
        <form action="../controller/controllerLivre.php" method="post">
            <h1>Livre</h1>
            <div class="field">
                <label for="titre">Titre:</label>
                <input type="text" name="titre" id="titre" placeholder="entrer votre nom" required>
            </div>
            <div class="field">
                <label for="editeur">Editeur: </label>
                <input type="text" name="editeur" id="editeur" placeholder="entrer l'editeur du livre" required>
            </div>
            <div class="field">
                <label for="prix">Prix: </label>
                <input type="text" name="prix" id="prix" placeholder="entrer le prix" required>
            </div>
            <div class="field">
                <label for="qte">quantite: </label>
                <input type="number" name="qte" id="qte" placeholder="entrer la quantite" required>
            </div>
            <input type="submit" value="Enregistrer">
        </form>
    </div>
</body>
</html>