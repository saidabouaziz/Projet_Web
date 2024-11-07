<?php
class Patient {
    private $conn;
    private $table = "patients";

    public $id;
    public $nom;
    public $prenom;
    public $date_naissance;
    public $adresse;
    public $telephone;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create (ajouter un patient)
    public function create() {
        $query = "INSERT INTO " . $this->table . " (nom, prenom, date_naissance, adresse, telephone) VALUES (:nom, :prenom, :date_naissance, :adresse, :telephone)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":date_naissance", $this->date_naissance);
        $stmt->bindParam(":adresse", $this->adresse);
        $stmt->bindParam(":telephone", $this->telephone);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read (afficher tous les patients)
    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update (mettre à jour un patient)
    public function update() {
        $query = "UPDATE " . $this->table . " SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, adresse = :adresse, telephone = :telephone WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":date_naissance", $this->date_naissance);
        $stmt->bindParam(":adresse", $this->adresse);
        $stmt->bindParam(":telephone", $this->telephone);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete (supprimer un patient)
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
