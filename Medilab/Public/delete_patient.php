<?php
require_once '../Config/database.php';
require_once '../controllers/PatientController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new PatientController($db);

$id = $_POST['id'];

if ($controller->deletePatient($id)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
