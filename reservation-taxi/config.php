<?php
// Informations de connexion à la base de données Hostinger
$host = 'srv1469.hstgr.io';  // Hôte MySQL
$db_name = 'u564203145_hopyou_db';  // Nom de la base de données
$username = 'u564203145_hopyou_admin';  // Utilisateur MySQL
$password = 'Hopyou@2024';  // Mot de passe MySQL

try {
    // Connexion via PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    
    // Activer les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>