<?php
require_once "../../Config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    try {
        $sql = "INSERT INTO users (username, password, role, full_name, email, phone) VALUES (:username, :password, :role, :full_name, :email, :phone)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        
        if ($stmt->execute()) {
            // Redirect to viewAllUsers.php after successful insertion
            header("Location: viewAllUsers.php");
            exit();
        } else {
            echo "Erreur lors de l'ajout de l'utilisateur.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
</head>
<body>
    <form action="addUser.php" method="POST">
        <label>Nom d'utilisateur:</label>
        <input type="text" name="username" required><br>

        <label>Mot de passe:</label>
        <input type="password" name="password" required><br>

        <label>Rôle:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="medecin">Médecin</option>
            <option value="patient">Patient</option>
        </select><br>

        <label>Nom complet:</label>
        <input type="text" name="full_name"><br>

        <label>Email:</label>
        <input type="email" name="email"><br>

        <label>Téléphone:</label>
        <input type="text" name="phone"><br>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</body>
</html>
