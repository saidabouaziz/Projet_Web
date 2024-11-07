<?php
// Models/User.php
class User {
    private $pdo;
    private $table = 'users';

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function create($username, $password, $role, $full_name, $email, $phone) {
        $sql = "INSERT INTO " . $this->table . " (username, password, role, full_name, email, phone) VALUES (:username, :password, :role, :full_name, :email, :phone)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);

        return $stmt->execute();
    }

    public function readAll() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
