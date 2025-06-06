<?php
$titre = $_POST["titre"];
$auteur = $_POST["auteur"];
$date = $_POST["date"];

if (!file_exists("biblio5.xml")) {
    // Création d'un nouveau XML
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="iso-8859-1"?><biblio></biblio>');
    
    // Ajout du premier livre
    $livre = $xml->addChild('livre');
    $livre->addChild('titre', htmlspecialchars($titre));
    $livre->addChild('auteur', htmlspecialchars($auteur));
    $livre->addChild('date', htmlspecialchars($date));
    
    echo "Nouveau fichier XML créé avec le premier livre.";
} else {
    // Modification d'un XML existant
    $xml = simplexml_load_file("biblio5.xml");
    
    // Ajout d'un nouveau livre
    $livre = $xml->addChild('livre');
    $livre->addChild('titre', htmlspecialchars($titre));
    $livre->addChild('auteur', htmlspecialchars($auteur));
    $livre->addChild('date', htmlspecialchars($date));
    
    echo "Livre ajouté au fichier existant.";
}

// Enregistrement du fichier
$xml->asXML("Livre.xml");
echo "Opération réussie !";
?>