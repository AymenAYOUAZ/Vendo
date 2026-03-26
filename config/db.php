<?php
// config/db.php
// bon hna mdina brk les variable
$host = 'localhost';
$dbname = 'Vendo'; 
$user = 'root';
$pass = 'root'; 

try {                  // hna kayn l connection b PDO 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {      // hna kayn l error handling ila ma t9derch t connecta
    die("Erreur de connexion : " . $e->getMessage());
}
?>