<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=bibliotheque", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "connexion a la BD reussi";
        echo "<br>";
    } catch(PDOException $e) {
        echo "connextion a la BD non reussi: " . $e->getMessage();
    }
?>