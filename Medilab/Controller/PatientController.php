<?php
require_once 'models/Patient.php';

class PatientController {
    private $db;
    private $patientModel;

    public function __construct($db) {
        $this->db = $db;
        $this->patientModel = new Patient($db);
    }

    public function createPatient($data) {
        $this->patientModel->nom = $data['nom'];
        $this->patientModel->prenom = $data['prenom'];
        $this->patientModel->date_naissance = $data['date_naissance'];
        $this->patientModel->adresse = $data['adresse'];
        $this->patientModel->telephone = $data['telephone'];

        return $this->patientModel->create();
    }

    public function getAllPatients() {
        return $this->patientModel->readAll();
    }

    public function updatePatient($data) {
        $this->patientModel->id = $data['id'];
        $this->patientModel->nom = $data['nom'];
        $this->patientModel->prenom = $data['prenom'];
        $this->patientModel->date_naissance = $data['date_naissance'];
        $this->patientModel->adresse = $data['adresse'];
        $this->patientModel->telephone = $data['telephone'];

        return $this->patientModel->update();
    }

    public function deletePatient($id) {
        $this->patientModel->id = $id;
        return $this->patientModel->delete();
    }
}
?>
