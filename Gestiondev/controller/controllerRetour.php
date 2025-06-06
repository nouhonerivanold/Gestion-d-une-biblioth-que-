<?php
require_once("../models/Modele.php");

$db = Database::getInstance();
$date_retour = $_POST['date'];
$id_adherent = $_POST['adherent'];
$listeEmprunts = json_decode($_POST['tableauEmprunts'], true);
$concerner = new Concerner($db);
$retour = new Retour($db);
$livre = new Livre($db);
$updateEtatEmprunt = new Emprunt($db);

$etat = 0;
foreach ($listeEmprunts as $emprunt) {
    $empruntConcerner = $updateEtatEmprunt->lireUnEmprunt($emprunt);
    if ($date_retour < $empruntConcerner["dateEmp"]) {
        $etat = 1;
    }
}
if ($etat) {
    echo " Veuillez modifier la date de retour car au moins un emprunt selectionné a une date superieure a celle du retour";
} else {
    foreach ($listeEmprunts as $emprunt) {
        $resultat = $concerner->LireQteEmprunt($emprunt);
        $retour->InsererRetour($date_retour, $emprunt);
        $updateEtatEmprunt->updateEtatEmprunt($emprunt);
        $leLivre = $livre->lireUnLivre($resultat['ref_livre']);
        $nouvelleQte = ($resultat['qte']/2) + $leLivre['qte'];
        $livre->updateQteLivre($resultat['ref_livre'], 1, $nouvelleQte);
    }
}

