<?php

    include ("../models/Modele.php");
   
        $bd= Database::getInstance();
        $nom=$_POST["nom"];
        $adresse=$_POST["adresse"];

        $bureau = new Adherent($bd);
        $bureau->InsererAdherent($nom, $adresse);
      
?>