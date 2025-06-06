<?php
include ("../models/Modele.php");
    
  // Pour la suppression d'un adherent je pense qu'on peut juste faire un On delete cascade. On supprime l'enregistrement adherent et automatiquement tout ce qui le concerne part
$bd= Database::getInstance();

$adherent = new Adherent($bd);
$id_adh = $_GET['idAdh'];
$adherentConcerner = $adherent->lireUnAdherent($id_adh);
$resultat = $adherent->supprimerAdherent($id_adh);
if ($resultat) {
    echo " L'adherent suivant a bien été supprimé: <br>";
    echo "Nom : " . $adherentConcerner["nom"] . "<br>";
    echo "Adresse : " . $adherentConcerner["adresse"] . "<br>";
}
else {
    echo "Erreur lors de la suppression de l'adherent.";
}
?>