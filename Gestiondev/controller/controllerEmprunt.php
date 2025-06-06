<?php
require_once("../models/Modele.php");

try {
    $bd = Database::getInstance();
    
    if (!isset($_POST['panier'])) {
        throw new Exception("Aucun emprunt à enregistrer");
    }

    $panier = json_decode($_POST['panier'], true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Format de données invalide");
    }

    $livre = new Livre($bd);
    $emprunt = new Emprunt($bd);
    $concerner = new Concerner($bd);
    $message="";
    if ($panier[0]['adherentId']==" ") {
           $message= "Veuillez choisir un adherent!!";
            header('Location: ../views/Emprunt.php?error=' . $message);
            exit();
           
        }
    if ($panier[0]['livreId']==" ") {
           $message= "Veuillez choisir un livre!!";
            header('Location: ../views/Emprunt.php?error=' . $message);
            exit();
           
        }
    foreach ($panier as $item) {

        if ($item['date']> date("Y-m-d")) {
           $message= "la date d'emprunt ne saurait depasser la date actuelle!!";
            header('Location: ../views/Emprunt.php?error=' . $message);
            exit();
           
        }
        else {
            
            // Vérification quantité
            $livreConcerne = $livre->lireUnLivre($item['livreId']);
            
            if ($item['qte'] > $livreConcerne["qte"]) {
                $message="La quantité demandée pour '{$livreConcerne['titre']}' dépasse le stock disponible";
                header('Location: ../views/Emprunt.php?error=' . $message);
                exit();
                
            }
            else {
                
                // Calcul nouvelle quantité
                $newqte = $livreConcerne["qte"] - $item['qte'];
                $disponible = $newqte > 0 ? 1 : 0;
        
                // Mise à jour du livre
                $livre->updateQteLivre($item['livreId'], $disponible, $newqte);
        
                // Création emprunt
                $emprunt->InsererEmprunt($item['date'], $item['adherentId']);
                $idEmprunt = $emprunt->lireDernierEmprunt();
        
                // Enregistrement dans Concerner
                $concerner->InsererConcerner($idEmprunt, $item['livreId'], $item['qte']);
            }
    
        }
    }

    // Réponse succès
    header('Location: ../views/Emprunt.php?success=Emprunts enregistrés avec succès');
    
} catch (Exception $e) {
    header('Location: ../views/Emprunt.php?error=' . urlencode($e->getMessage()));
}