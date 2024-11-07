<?php
/* Inclure le fichier config */
require_once "../Config/database.php"; // Assurez-vous que ce fichier crée une connexion PDO

/* Définir les variables */
$user_id = $birth_date = $address = "";
$user_id_err = $birth_date_err = $address_err = "";

// Fetch users for the dropdown
$users = [];
try {
    $sql = "SELECT user_id, full_name FROM users WHERE user_id > -1 ORDER BY user_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $th) {
    echo "<br>";
    echo $th->getMessage();
    echo "<br>";
    echo $sql;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* Validate user_id */
    $input_user_id = trim($_POST["user_id"]);
    if (empty($input_user_id)) {
        $user_id_err = "Veuillez entrer l'ID de l'utilisateur.";
    } elseif (!filter_var($input_user_id, FILTER_VALIDATE_INT)) {
        $user_id_err = "Veuillez entrer un ID valide.";
    } else {
        $user_id = $input_user_id;
    }

    /* Validate birth_date */
    $input_birth_date = trim($_POST["birth_date"]);
    if (empty($input_birth_date)) {
        $birth_date_err = "Veuillez entrer une date de naissance.";
    } else {
        $birth_date = $input_birth_date;
    }

    /* Validate address */
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Veuillez entrer une adresse.";     
    } else {
        $address = $input_address;
    }

    /* Vérifiez les erreurs avant enregistrement */
    if (empty($user_id_err) && empty($birth_date_err) && empty($address_err)) {
        try {
            /* Prepare an insert statement */
            $sql = "INSERT INTO patients (user_id, birth_date, address) VALUES (:user_id, :birth_date, :address)";
            $stmt = $pdo->prepare($sql); // $pdo est votre instance PDO

            /* Bind les paramètres */
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':birth_date', $birth_date);
            $stmt->bindParam(':address', $address);
            
            /* Exécutez la requête */
            if ($stmt->execute()) {
                /* opération effectuée, retour */
                header("location: index.php"); // Redirigez vers une page de votre choix
                exit();
            } else {
                echo "Oops! Une erreur est survenue.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    /* Fermer la connexion */
    $pdo = null; // Si vous souhaitez fermer la connexion explicitement
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Ajouter un Patient</h2>
                    <p>Remplir le formulaire pour enregistrer un patient dans la base de données</p>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>ID de l'utilisateur</label>
                            <select name="user_id" class="form-control <?php echo (!empty($user_id_err)) ? 'is-invalid' : ''; ?>">
                                <option value="">Sélectionnez un utilisateur</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?php echo $user['user_id']; ?>" <?php echo ($user_id == $user['user_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($user['full_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $user_id_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date de naissance</label>
                            <input type="date" name="birth_date" class="form-control <?php echo (!empty($birth_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($birth_date); ?>">
                            <span class="invalid-feedback"><?php echo $birth_date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Adresse</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo htmlspecialchars($address); ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
