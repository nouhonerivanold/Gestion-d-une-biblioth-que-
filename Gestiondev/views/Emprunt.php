<?php
     include ("../models/Modele.php");
    $bd= Database::getInstance();

    $adherent = new Adherent($bd);
    $stmt = $adherent->lireAdherent();
    $adherent = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $livre = new Livre($bd);
    $stmt = $livre->lireLivre();
    $livre = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/Emprunt.css">
    <script src="./Javascript/Emprunt.js" defer></script>
    <title>Enregistrement d'un Emprunt</title>
</head>
<body>
    <div class="form" >
        <?php
            if (isset($_GET['error'])) {
                echo "<h3>".$_GET['error']."</h3>";
            }
        ?>
        <form action="../controller/controllerEmprunt.php" method="post">
            <h1>Emprunt</h1> 
            
            <label for="adherent">L'adherent Concerne</label>
            <select  name="adherent" id="adherent" class="form-select"  required>
                <option value=" " selected disabled>Sélectionnez L'adherent concerne</option>
                <?php foreach($adherent as $p): 
                    if (!$p["suspendu"]) {
                        # code...
                ?>
                    <option value="<?php echo $p['Id_Adh']; ?>">
                        <?php echo htmlspecialchars($p['nom']); ?>
                    </option>
                    <?php } endforeach; ?>
            </select>
            <label for="livre">Le livre Concerne</label>
            <select name="livre" id="livre" class="form-select">
                <option value=" " selected disabled>Sélectionnez Le livre concerne</option>
                <?php foreach($livre as $p): ?>
                    <option value="<?php echo $p['ref_livre']; ?>">
                        <?php echo htmlspecialchars($p['titre']); ?>
                    </option>
                    <?php endforeach; ?>
            </select>
            <div class="field">
                <label for="qte">Quantite:</label>
                <input type="number" min=1 name="qte" id="qte" placeholder="entrer la quantite" required>
            </div>
            
            <div class="field">
                <label for="date">Date Emprunt:</label>
                <input type="date" name="date" id="date" placeholder="entrer la date de l'emprunt" required>
            </div>
            <div class="panier">
                <h3>Panier d'emprunts</h3>
                <ul></ul>
                <button id="ajouterPanier">Ajouter au panier</button>
            </div>
            <div class="actions">
                <button type="button" id="soumissionFinale">Enregistrer tous les emprunts</button>
                <button type="reset">Annuler</button>
            </div>
        </form>
    </div>
</body>
</html>