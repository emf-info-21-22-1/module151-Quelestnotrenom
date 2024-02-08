<?php
require_once 'Database.php';
$host = 'localhost';
$dbname = 'hockey_stats';
$username = 'root';
$password = 'emf123';

// Créez une instance de la classe Database
$database = new Database($host, $dbname, $username, $password);

// Exemple d'utilisation pour récupérer tous les titres des jeux vidéo
$sql = 'SELECT titre FROM hockey_stats';
$result = $database->fetchAll($sql);

// Affiche les résultats
foreach ($result as $row) {
    echo $row['titre'] . '<br>';
}
?>