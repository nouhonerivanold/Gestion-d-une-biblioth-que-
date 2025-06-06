<?php

    include ("../models/Modele.php");
    

        $bd= Database::getInstance();
        $nom=$_POST["nom"];
        $nbreBureau=$_POST["nbrebureau"];
        $valeurselectionne=$_POST["immeuble"];

        $etage = new Etage($bd);
        $etage->InsererEtage($nom,$nbreBureau,$valeurselectionne);
?>