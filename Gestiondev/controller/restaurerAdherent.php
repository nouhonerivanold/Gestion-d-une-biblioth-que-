<?php
include ("../models/Modele.php");

$bd= Database::getInstance();

$adherentObject = new Adherent($bd);

$id_adh = $_GET['idAdh'];
$filename = "adherents.xml";

if (file_exists($filename)) {
    $xml = simplexml_load_file($filename);

    foreach ($xml->adherent as $adherent) {
        if ((string)$adherent->Id_Adh == $id_adh) {
            $adherentObject->suspendreOuRestaurerAdherent($id_adh, 0);
            echo " L'adherent suivant a bien ete restauré: <br>";
            echo "Nom : " . $adherent->nom . "<br>";
            echo "Adresse : " . $adherent->adresse . "<br>";
            $dom = dom_import_simplexml($adherent);
            $dom->parentNode->removeChild($dom);
            $xml->asXML($filename);
            break; 
        }
    }
} else {
    echo "Fichier XML non trouvé.";
}


?>