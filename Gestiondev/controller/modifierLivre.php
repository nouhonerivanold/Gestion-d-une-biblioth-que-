<?php
    include("../models/Modele.php");
    $bd= Database::getInstance();

    $livre = new Livre($bd);
    if (isset($_POST["leLivre"])) {
        $dispo = true;
        $livre->modifierLivre($_POST["leLivre"], $_POST["titre"], $_POST["editeur"], $_POST["prix"], $dispo, $_POST["qte"]);
        header("Location: ../views/listeLivre.php");
    }else{
        if (isset($_GET['idLivre'])) {
           $leLivre = $_GET['idLivre'];
            $livreConcerner = $livre->lireUnLivre($leLivre);
        
            header("Location: ../views/miseAjourLivre.php?titre=". $livreConcerner["titre"]. "&editeur=". $livreConcerner["editeur"]. "&prix=". $livreConcerner["prix"]. "&qte=". $livreConcerner["qte"]. "&id=". $leLivre);
        }
        
    }

?>