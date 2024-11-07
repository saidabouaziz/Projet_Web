<?php
$host = "localhost"; // Your database host
$db_name = "clinique"; // Your database name
$username = "root"; // Your database username
$password = ""; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
