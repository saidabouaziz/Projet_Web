<?php
// Include the database configuration file
require_once "../Config/database.php";

// Check if patient_id is set in the query parameters
if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    try {
        // Prepare a SELECT statement to fetch the patient details
        $sql = "SELECT p.patient_id, p.birth_date, p.address, u.username, u.full_name, u.email, u.phone
                FROM patients p
                JOIN users u ON p.user_id = u.user_id
                WHERE p.patient_id = :patient_id";
        
        $stmt = $pdo->prepare($sql);
        
        // Bind the patient_id parameter
        $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch the patient record
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if a patient was found
        if (!$patient) {
            echo "Patient non trouvé.";
        } else {
            // Display patient details
            ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Détails du patient</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body>
                <div class="container mt-5">
                    <h2>Détails du patient</h2>
                    <table class="table">
                        <tr>
                            <th>Nom d'utilisateur</th>
                            <td><?php echo htmlspecialchars($patient['username']); ?></td>
                        </tr>
                        <tr>
                            <th>Nom complet</th>
                            <td><?php echo htmlspecialchars($patient['full_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($patient['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                        </tr>
                        <tr>
                            <th>Date de naissance</th>
                            <td><?php echo htmlspecialchars($patient['birth_date']); ?></td>
                        </tr>
                        <tr>
                            <th>Adresse</th>
                            <td><?php echo htmlspecialchars($patient['address']); ?></td>
                        </tr>
                    </table>
                    <a href="index.php" class="btn btn-secondary">Retour</a>
                </div>
            </body>
            </html>
            <?php
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Erreur lors de la récupération du patient : " . htmlspecialchars($e->getMessage());
    }
} else {
    // Handle the case where patient_id is not provided
    echo "ID du patient manquant.";
}
?>
