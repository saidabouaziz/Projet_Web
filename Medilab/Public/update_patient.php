<?php
require_once '../Config/database.php';
require_once '../controllers/PatientController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new PatientController($db);

$id = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$date_naissance = $_POST['date_naissance'];
$adresse = $_POST['adresse'];
$telephone = $_POST['telephone'];

if ($controller->updatePatient($id, $nom, $prenom, $date_naissance, $adresse, $telephone)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
