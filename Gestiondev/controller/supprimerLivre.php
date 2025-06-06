<?php
include ("../models/Modele.php");
    
  // Pour la suppression d'un adherent je pense qu'on peut juste faire un On delete cascade. On supprime l'enregistrement adherent et automatiquement tout ce qui le concerne part
$bd= Database::getInstance();

$livre = new Livre($bd);
$ref_livre = $_GET['idLivre'];
$livreConcerner = $livre->lireUnLivre($ref_livre);
$resultat = $livre->supprimerLivre($ref_livre);
if ($resultat) {
    echo " Le Livre suivant a bien été supprimé: <br>";
    echo "Titre : " . $livreConcerner["titre"] . "<br>";
    echo "Editeur : " . $livreConcerner["editeur"] . "<br>";
    echo "Prix : " . $livreConcerner["prix"] . "<br>";
    echo "Quantite : " . $livreConcerner["qte"] . "<br>";
}
else {
    echo "Erreur lors de la suppression du livre.";
}
?>