<?php
     include ("../models/Modele.php");
    $bd= Database::getInstance();

    $adherent = new Adherent($bd);
    $stmt = $adherent->lireAdherent();
    $adherent = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/retour.css">
    <script src="./Javascript/retour.js" defer></script>
    <title>Enregistrement d'un retour</title>
</head>
<body>
    <div class="form" >
        <form id="monFormulaire" action="../controller/controllerRetour.php" method="post">
            <h1>Retour</h1>            
            <label for="adherent">l'adherent Concerne</label>
            <select name="adherent" id="adherent" class="form-select" onchange=ChangerListeEmprunt()>
                <?php
                    echo "<option disabled selected>Selectionner un adherent</option>" ;
                    foreach($adherent as $p)
                        if(isset($_GET['id']))
                            if($p['Id_Adh']==$_GET['id'])
                                echo "<option selected value=". $p['Id_Adh'].">". $p['nom'] ."</option>" ;
                            else
                                echo "<option value=". $p['Id_Adh'].">". $p['nom'] ."</option>" ;
                        else
                            echo "<option value=". $p['Id_Adh'].">". $p['nom'] ."</option>" ;
                ?>
            </select>
            <div class="field">
                <label for="date">Date retour:</label>
                <input type="date" name="date" id="date" required>
            </div>
            <p>listes des emprunts</p>
            <div class="listes">
                   <?php
                   if(isset($_GET['id'])){ 
                        $id_adh = $_GET['id'];
                        $emprunt = new Emprunt($bd);
                        $emprunt = $emprunt->lireEmpruntAdherent1($id_adh);
                        foreach($emprunt as $p){
                            if($p['actif']){
                                echo "<div class='emprunt-item'>";
                                echo "<p><strong>Date emprunt:</strong>" .$p['dateEmp'] . "</p>";
                                if (!empty($p['livres'])) {
                                    $livres = explode(', ', $p['livres']);
                                $quantites = explode(', ', $p['quantites']);
                                echo "<p><strong>Livres:</strong></p>";
                                echo "<ul>";
                                foreach ($livres as $index => $titre) {
                                    $qte = $quantites[$index] ?? '';
                                    echo "<li>" . $titre . " (Qte: " . $qte . ")</li>";
                                }
                                echo "</ul>";
                            }
                                else {
                                    echo "<p>Aucun livre associé</p>";
                                }
                                echo "<input type=\"checkbox\" value=". $p['Id_Emp'] .">";  
                                echo "</div>";
                                echo "<hr>";
                            
                            } 
                        }
                    }
                    ?>
            </div>
            <input type="submit" value="Enregistrer" id="soumission">
            <input type="reset" value="annuler">
        </form>
    </div>
</body>
</html>