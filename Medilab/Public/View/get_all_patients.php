<?php
// Include the database configuration file
require_once "../Config/database.php";

try {
    // Prepare a SELECT statement to fetch all patients
    $sql = "SELECT p.patient_id, u.username, u.full_name, u.email, u.phone, p.birth_date, p.address
            FROM patients p
            JOIN users u ON p.user_id = u.user_id";
    
    $stmt = $pdo->prepare($sql);
    
    // Execute the statement
    $stmt->execute();
    
    // Fetch all patient records
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if there are any patients
    if (count($patients) == 0) {
        echo "Aucun patient trouvé.";
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Liste des patients</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Liste des patients</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom d'utilisateur</th>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date de naissance</th>
                            <th>Adresse</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient) : ?>
                        <tr>
                            <td>
                                <a href="get_patients.php?patient_id=<?php echo $patient['patient_id']; ?>">
                                    <?php echo htmlspecialchars($patient['username']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($patient['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($patient['email']); ?></td>
                            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                            <td><?php echo htmlspecialchars($patient['birth_date']); ?></td>
                            <td><?php echo htmlspecialchars($patient['address']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="index.php" class="btn btn-secondary">Retour</a>
            </div>
        </body>
        </html>
        <?php
    }
} catch (PDOException $e) {
    // Handle any database errors
    echo "Erreur lors de la récupération des patients : " . htmlspecialchars($e->getMessage());
}
?>
