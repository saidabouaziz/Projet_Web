<?php
require_once "../../Config/database.php";

if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];

    // Fetch user info
    $sql = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST["username"]);
            $role = trim($_POST["role"]);
            $full_name = trim($_POST["full_name"]);
            $email = trim($_POST["email"]);
            $phone = trim($_POST["phone"]);

            try {
                $update_sql = "UPDATE users SET username = :username, role = :role, full_name = :full_name, email = :email, phone = :phone WHERE user_id = :user_id";
                $update_stmt = $pdo->prepare($update_sql);

                $update_stmt->bindParam(":username", $username);
                $update_stmt->bindParam(":role", $role);
                $update_stmt->bindParam(":full_name", $full_name);
                $update_stmt->bindParam(":email", $email);
                $update_stmt->bindParam(":phone", $phone);
                $update_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

                if ($update_stmt->execute()) {
                    header("Location: viewAllUsers.php?success=updated");
                    exit();
                } else {
                    echo "Erreur lors de la mise à jour de l'utilisateur.";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    } else {
        echo "Utilisateur non trouvé.";
    }
} else {
    echo "ID de l'utilisateur manquant.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mettre à jour l'utilisateur</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?user_id=" . $user_id); ?>" method="post">
        <label>Nom d'utilisateur:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>

        <label>Role:</label>
        <select name="role" required>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="medecin" <?php if ($user['role'] == 'medecin') echo 'selected'; ?>>Médecin</option>
            <option value="patient" <?php if ($user['role'] == 'patient') echo 'selected'; ?>>Patient</option>
        </select><br>

        <label>Nom complet:</label>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label>Téléphone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br>

        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
