<?php
// Models/Appointment.php
class Appointment {
    private $pdo;
    private $table = 'appointments';

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function create($patient_id, $medecin_id, $appointment_date, $status) {
        $sql = "INSERT INTO " . $this->table . " (patient_id, medecin_id, appointment_date, status) VALUES (:patient_id, :medecin_id, :appointment_date, :status)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':medecin_id', $medecin_id);
        $stmt->bindParam(':appointment_date', $appointment_date);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    public function readAll() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
