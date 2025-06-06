<?php
include ("../models/Modele.php");

// Pour la suspension d'un adherent, j'ai ajoute un champ suspendu dans adherent de telle sorte que ce champ
// passera a 1 dans le cas ou on a suspendu l'adherent concerner
// Ainsi avant d'afficher n'importe quoi, on teste d'abord si suspendu est a 1 ou 0

$bd= Database::getInstance();

$adherent = new Adherent($bd);
$emprunts = new Emprunt($bd);  // Pour recuperer et stocker dans le fichier XML tous les emprunts de cet adherent
$retours = new Retour($bd);    // ---//--- Tous les retours de cet adherent
$id_adh = $_GET['idAdh'];


$adherent->suspendreOuRestaurerAdherent($id_adh, 1);
$listeEmpruntsAdherent = $emprunts->lireEmpruntAdherent($id_adh);

$filename = "adherents.xml";
$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;

if (file_exists($filename)) {
    $xml->load($filename);
    $root = $xml->getElementsByTagName("adherents")->item(0);
} else {
    $root = $xml->createElement("adherents");
    $xml->appendChild($root);
}
// insertion dans le fichier xml

$noeudAdherent = $xml->createElement("adherent");
$adherentConcerner = $adherent->lireUnAdherent($id_adh);

foreach (['Id_Adh', 'nom', 'adresse'] as $field) {
    $child = $xml->createElement($field, htmlspecialchars($adherentConcerner[$field]));
    $noeudAdherent->appendChild($child);
}

$noeudsEmprunts = $xml->createElement("emprunts");
    foreach ($listeEmpruntsAdherent as $emprunt) {
        $noeudEmprunt = $xml->createElement("emprunt");
        $noeudEmprunt->appendChild($xml->createElement("Id_Emp", $emprunt['Id_Emp']));
        $noeudEmprunt->appendChild($xml->createElement("dateEmp", $emprunt['dateEmp']));
        $noeudEmprunt->appendChild($xml->createElement("actif", $emprunt['actif']));
        $noeudsEmprunts->appendChild($noeudEmprunt);
    }
    $noeudAdherent->appendChild($noeudsEmprunts);

$noeudsRetours = $xml->createElement("retours");
    foreach ($listeEmpruntsAdherent as $emprunt) {
        $unRetour = $retours->lireRetourAdherent($emprunt['Id_Emp']);
        if ($unRetour!=false) {
            $etat = 1;
            $noeudRetour = $xml->createElement("retour");
            $noeudRetour->appendChild($xml->createElement("Id_retour", $unRetour['Id_retour']));
            $noeudRetour->appendChild($xml->createElement("date_retour", $unRetour['date_retour']));
            $noeudRetour->appendChild($xml->createElement("Id_Emp", $unRetour['Id_Emp']));
            $noeudsRetours->appendChild($noeudRetour);
        }
    }
    $noeudAdherent->appendChild($noeudsRetours);  

    $root->appendChild($noeudAdherent);

$xml->save("adherents.xml");
echo"La suspension a bien eu lieu et l'adherent a ete mis dans le fichier XML";
?>
