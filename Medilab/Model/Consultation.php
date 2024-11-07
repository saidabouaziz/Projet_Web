<?php
// Models/Consultation.php
class Consultation {
    private $pdo;
    private $table = 'consultations';

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function create($appointment_id, $consultation_date, $notes, $prescription) {
        $sql = "INSERT INTO " . $this->table . " (appointment_id, consultation_date, notes, prescription) VALUES (:appointment_id, :consultation_date, :notes, :prescription)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':appointment_id', $appointment_id);
        $stmt->bindParam(':consultation_date', $consultation_date);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':prescription', $prescription);

        return $stmt->execute();
    }

    public function readAll() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
