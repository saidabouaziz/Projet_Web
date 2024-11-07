<?php
// Models/DossierMedical.php
class DossierMedical {
    private $pdo;
    private $table = 'dossier_medical';

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function create($patient_id, $diagnosis, $treatment, $notes) {
        $sql = "INSERT INTO " . $this->table . " (patient_id, diagnosis, treatment, notes) VALUES (:patient_id, :diagnosis, :treatment, :notes)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':diagnosis', $diagnosis);
        $stmt->bindParam(':treatment', $treatment);
        $stmt->bindParam(':notes', $notes);

        return $stmt->execute();
    }

    public function readAll() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
