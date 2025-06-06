CREATE DATABASE IF NOT EXISTS bibliotheque;

USE bibliotheque;

-- ------------ creation des tables ---------------

-- Création de la table adherent

CREATE TABLE Adherent (
    Id_Adh INT AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    suspendu Boolean default 0,
    CONSTRAINT PK_adherent PRIMARY KEY (Id_Adh)
) ENGINE=InnoDB;

-- Table Emprunt

CREATE TABLE Emprunt (
    Id_Emp INT AUTO_INCREMENT,  
    dateEmp DATE NOT NULL,
    actif Boolean,                          
    Id_Adh INT,
    CONSTRAINT PK_Emprunt PRIMARY KEY (Id_Emp), 
    CONSTRAINT FK_Adherent FOREIGN KEY (Id_Adh) REFERENCES Adherent(Id_Adh) ON DELETE CASCADE 
) ENGINE=InnoDB;

-- Table Livre

CREATE TABLE Livre (
    ref_livre INT AUTO_INCREMENT,     
    titre VARCHAR(255) NOT NULL,           
    editeur VARCHAR(255) NOT NULL,     
    prix INT NOT NULL,
    dispo Boolean,
    qte INT NOT NULL,             
    CONSTRAINT PK_livre PRIMARY KEY (ref_livre)
) ENGINE=InnoDB;  

-- Création de la table concerner

CREATE TABLE Concerner (
    Id_concerner INT AUTO_INCREMENT,
    Id_Emp INT, 
    ref_livre INT,
    qte INT NOT NULL,  
    CONSTRAINT PK_concerner PRIMARY KEY (Id_concerner),
    CONSTRAINT FK_livre FOREIGN KEY (ref_livre) REFERENCES Livre(ref_livre) ON DELETE CASCADE,  
    CONSTRAINT FK_emprunter FOREIGN KEY (Id_Emp) REFERENCES Emprunt(Id_Emp) ON DELETE CASCADE   
) ENGINE=InnoDB;

-- Création de la table Retourner

CREATE TABLE Retourner (
    Id_retour INT AUTO_INCREMENT,
    date_retour DATE NOT NULL,
    Id_Emp INT, 
    CONSTRAINT PK_retourner PRIMARY KEY (Id_retour),
    CONSTRAINT FK_emprunt FOREIGN KEY (Id_Emp) REFERENCES Emprunt(Id_Emp) ON DELETE CASCADE  
) ENGINE=InnoDB;