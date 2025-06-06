<?php


    include ("../models/Modele.php");
   
        $bd= Database::getInstance();
        $titre=$_POST["titre"];
        $editeur=$_POST["editeur"];
        $prix=$_POST["prix"];
        $qte=$_POST["qte"];
        $dispo= true;

        $bureau = new Livre($bd);
        $bureau->InsererLivre($titre, $editeur,$prix, $dispo, $qte);
      
?>
