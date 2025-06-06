<?php

    include ("../models/Modele.php");
    

        $bd= Database::getInstance();
   
        $livre = new Livre($bd);
       $listeLivre = $livre->lireLivre();
  
?>