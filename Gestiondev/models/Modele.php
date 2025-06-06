<?php

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=localhost;dbname=bibliotheque", 
                "root", 
                ""
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Erreur de connexion: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}

    class Adherent{
        public $nom;
        public  $adresse;
        public $suspendu;
        public $table='adherent';
        
        public function __construct( $bd) {
            $this->conn=$bd;
        }

        public function InsererAdherent ($nom, $adresse) :void{
            try {
                $sql = "INSERT INTO adherent (nom,adresse)
                VALUES ('$nom', '$adresse')";
                include ("connexionBD.php");
                $conn->exec($sql);
                echo "enregistrement dans la BD effectue avec succes";
                echo "<br>";
            } catch(PDOException $e) {
                 echo $sql . "<br>" . $e->getMessage();
            }
        
        }
        public function lireAdherent() {
            $query = "SELECT Id_Adh,nom,adresse,suspendu FROM " . $this->table . " ORDER BY nom ASC";
            $requete = $this->conn->prepare($query);
            $requete->execute();
            
            return $requete;
        }
        public function lireUnAdherent($id_adh) {
            $query = "SELECT Id_Adh, nom, adresse FROM " . $this->table . " WHERE Id_Adh=:id_adh";
            $requete = $this->conn->prepare($query);
            $requete->execute([
                ':id_adh' => $id_adh
            ]);
            $result = $requete->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function supprimerAdherent($id_adh){
           try {
                $query = "DELETE FROM " . $this->table . " WHERE Id_Adh=". $id_adh;
                $requete = $this->conn->prepare($query);
                $requete->execute();
                return true;
           } catch (PDOException $e) {
            return false;
           } 
            
        }

        public function suspendreOuRestaurerAdherent($id_adh, $suspendu){
            try {
                $sql = "UPDATE {$this->table} SET suspendu = :suspendu WHERE Id_Adh = :id_adh";
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([
                    ':suspendu' => $suspendu,
                    ':id_adh' => $id_adh
                ]);
            } catch(PDOException $e) {
                error_log("Erreur updateQteLivre (ref: $ref_livre): " . $e->getMessage());
                return false;
            }
        }
    }

    class Livre{
        public  $titre;
        public $editeur;
        public $prix;
        public $qte;
        public $dispo;
        public $idLIivre;
        public $ref_livre;
        public $table='livre';
        

        public function __construct( $bd) {
            $this->conn=$bd;
        }

        public function InsererLivre($titre,$editeur,$prix, $dispo, $qte) :void{

            try {
                $sql = "INSERT INTO livre (titre, editeur, prix, dispo, qte)
                VALUES (:titre, :editeur, :prix, :dispo, :qte)";
                include ("connexionBD.php");
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':titre' => $titre,
                    ':editeur' => $editeur,
                    ':prix' => $prix,
                    ':dispo' => $dispo,
                    ':qte' => $qte
                ]);
                // $conn->exec($sql);
                echo "enregistrement effectue avec succes";
            } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        }

         public function lireUnLivre($idLivre) {
            $query = "SELECT titre,editeur,prix,dispo,qte FROM " . $this->table . " WHERE ref_livre=". $idLivre;
            $requete = $this->conn->prepare($query);
            $requete->execute();
            $result = $requete->fetch(PDO::FETCH_ASSOC);
            return $result;
        }


        public function lireLivre() {
            $query = "SELECT ref_livre,titre,editeur,prix,dispo,qte FROM " . $this->table . " ORDER BY titre ASC";
            $requete = $this->conn->prepare($query);
            $requete->execute();
            
            return $requete;
        }

        public function modifierLivre($ref_livre, $titre, $editeur, $prix, $dispo, $qte) {
            try {
                $sql = "UPDATE livre SET 
                        titre = :titre,
                        editeur = :editeur,
                        prix = :prix,
                        dispo = :dispo,
                        qte = :qte
                        WHERE ref_livre = :ref_livre";
                
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([
                    ':titre' => $titre,
                    ':editeur' => $editeur,
                    ':prix' => $prix,
                    ':dispo' => $dispo,
                    ':qte' => $qte,
                    ':ref_livre' => $ref_livre
                ]);
            } catch(PDOException $e) {
                error_log("Erreur lors de la modification du livre: " . $e->getMessage());
                return false;
            }
        }

        public function updateQteLivre(string $ref_livre, int $dispo, int $qte): bool{
            try {
                $sql = "UPDATE {$this->table} SET dispo = :dispo, qte = :qte WHERE ref_livre = :ref_livre";
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([
                    ':dispo' => $dispo,
                    ':qte' => $qte,
                    ':ref_livre' => $ref_livre
                ]);
            } catch(PDOException $e) {
                error_log("Erreur updateQteLivre (ref: $ref_livre): " . $e->getMessage());
                return false;
            }
        }

        public function supprimerLivre($ref_livre){
            try {
                $query = "DELETE FROM " . $this->table . " WHERE ref_livre=". $ref_livre;
                $requete = $this->conn->prepare($query);
                $requete->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
            
        }
    }

    class Emprunt{
        public $dateEmprunt;
        public $idEmprunt;
        public  $idAdherent;
        public $actif;
        public $table='emprunt';
        
        public function __construct( $bd) {
            $this->conn=$bd;
        }
        public function updateEtatEmprunt($idEmprunt){
            try {
                $sql = "UPDATE {$this->table} SET actif=0 WHERE Id_Emp =".$idEmprunt;
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute();
            } catch(PDOException $e) {
                error_log("Erreur updateQteLivre (ref: $ref_livre): " . $e->getMessage());
                return false;
            }
        }
        // Ajoutez cette méthode à votre classe Emprunt
        public function InsererEmprunt($dateEmprunt, $idAdherent) {
            try {
                    $sql = "INSERT INTO emprunt (dateEmp, Id_Adh, actif) VALUES (:date, :adherent, 1)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([
                        ':date' => $dateEmprunt,
                        ':adherent' => $idAdherent
                    ]);
                    return true;
            } catch(PDOException $e) {
                    error_log("Erreur lors de l'insertion d'emprunt: " . $e->getMessage());
                    return false;
            }
        }

        public function lireEmpruntAdherent($id_adh) {
            $query = "SELECT Id_Emp, dateEmp, actif FROM " . $this->table . " WHERE Id_Adh= ". $id_adh . " ORDER BY Id_Emp ASC";
            $requete = $this->conn->prepare($query);
            $requete->execute();
            $result = $requete->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function lireDernierEmprunt() {
            $query = "SELECT Id_Emp FROM " . $this->table . " ORDER BY Id_Emp DESC LIMIT 1";
            $requete = $this->conn->prepare($query);
            $requete->execute();
            $result = $requete->fetch(PDO::FETCH_ASSOC);
            return $result["Id_Emp"];
        }

        public function lireEmpruntAdherent1($id_adh) {
            $query = "SELECT e.Id_Emp, e.dateEmp, e.actif, 
                            GROUP_CONCAT(l.titre SEPARATOR ', ') AS livres,
                            GROUP_CONCAT(c.qte SEPARATOR ', ') AS quantites
                    FROM " . $this->table . " e
                    LEFT JOIN concerner c ON e.Id_Emp = c.Id_Emp
                    LEFT JOIN livre l ON c.ref_livre = l.ref_livre
                    WHERE e.Id_Adh = :id_adh
                    GROUP BY e.Id_Emp
                    ORDER BY e.Id_Emp ASC";
            
            $requete = $this->conn->prepare($query);
            $requete->bindParam(':id_adh', $id_adh, PDO::PARAM_INT);
            $requete->execute();
    
            return $requete;
        }
        
        public function lireUnEmprunt($id) {
                $query = "SELECT Id_Emp,dateEmp,actif FROM " . $this->table . " WHERE Id_Emp=". $id;
                $requete = $this->conn->prepare($query);
                $requete->execute();
                $result = $requete->fetch(PDO::FETCH_ASSOC);
                return $result;
            }
     }


    class Concerner{
        public $idEmprunt;
        public $ref_livre;
        public  $qte;
        public $table='concerner';

        public function __construct( $bd) {
            $this->conn=$bd;
        }

        public function InsererConcerner($idEmprunt,$ref_livre, $qte) :void{
            try {
                $sql = "INSERT INTO concerner (Id_Emp,ref_livre, qte)
                VALUES ($idEmprunt, $ref_livre,$qte)";
                include ("connexionBD.php");
                $conn->exec($sql);
                echo "enregistrement effectue avec succes";
            } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        }

        public function lireEtage() {
            $query = "SELECT NoEtage, nom,nbrebureau FROM " . $this->table . " ORDER BY nom ASC";
            $requete = $this->conn->prepare($query);
            $requete->execute();
            
            return $requete;
        }

        public function modifierEtage($NoEtage, $nom, $nbreBureau) {
            $query = "UPDATE " . $this->table . " 
                     SET nom = :nom, nbrebureau = :nbrebureau 
                     WHERE NoEtage = :NoEtage";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':NoEtage', $NoEtage);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':nbrebureau', $nbreBureau, PDO::PARAM_INT);
            
            return $stmt->execute();
        }
        
        public function LireQteEmprunt ($idEmprunt) {
            $query = "SELECT ref_livre, qte FROM " . $this->table . " WHERE Id_Emp = ".$idEmprunt;
            $requete = $this->conn->prepare($query);
            $requete->execute();
            $result = $requete->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    
    class Retour{
        public $idEmprunt;
        public $dateRetour;
        public $table='retourner';

        public function __construct( $bd) {
            $this->conn=$bd;
        }

        public function InsererRetour($dateRetour,$idEmprunt) :void{
            try {
                $sql = "INSERT INTO retourner (date_retour,Id_Emp)
                VALUES ('$dateRetour', $idEmprunt)";
                include ("connexionBD.php");
                $conn->exec($sql);
                echo "enregistrement effectue avec succes";
            } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        }

        public function lireRetourAdherent($Id_Emp){
            $query = "SELECT Id_retour, date_retour, Id_Emp FROM " . $this->table . " WHERE Id_Emp =". $Id_Emp;
            $requete = $this->conn->prepare($query);
            $requete->execute();
            $result = $requete->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }

?>