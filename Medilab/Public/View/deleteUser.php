<?php
require_once "../../Config/database.php";

if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];

    try {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: viewAllUsers.php?success=deleted");
            exit();
        } else {
            echo "Erreur lors de la suppression de l'utilisateur.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "ID de l'utilisateur manquant.";
}
?>
