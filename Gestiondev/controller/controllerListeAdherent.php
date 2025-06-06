<?php

    include ("../models/Modele.php");
    

        $bd= Database::getInstance();
   
        $adherent = new Adherent($bd);
       $listeAdherent = $adherent->lireAdherent();
  
?>