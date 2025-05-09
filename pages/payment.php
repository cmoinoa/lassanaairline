<?php
session_start();
$trips = json_decode(file_get_contents("../data/trips.json"), true);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Erreur : ID de voyage manquant ou invalide.");
}

$tripId = (int)$_GET['id'];

if (!isset($trips[$tripId])) {
    die("Erreur : Voyage introuvable.");
}

$trip = $trips[$tripId];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - <?= htmlspecialchars($trip['title']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <button id="toggle-theme">Changer de thème</button>
<link id="theme-link" rel="stylesheet" href="css/clair.css">

    <div class="container">
        <div class="card">
            <h1>Paiement pour <?= htmlspecialchars($trip['title']) ?></h1>
            <p>Prix : <?= htmlspecialchars($trip['total_price']) ?> €</p>

            <form action="process_payment.php" method="POST">
                <input type="hidden" name="trip_id" value="<?= $tripId ?>">

                <div class="form-group">
                    <label for="card_name">Nom et prénom :</label>
                    <input type="text" name="card_name" id="card_name" required><br>
                </div>

                <div class="form-group">
                    <label for="card_number">Numéro de carte :</label>
                    <input type="text" name="card_number" id="card_number" pattern="\d{16}" required><br>
                </div>

                <div class="form-group">
                    <label for="card_expiry">Date d'expiration :</label>
                    <input type="month" name="card_expiry" id="card_expiry" required><br>
                </div>

                <div class="form-group">
                    <label for="card_cvv">CVV :</label>
                    <input type="text" name="card_cvv" id="card_cvv" pattern="\d{3}" required><br>
                </div>

                <button type="submit">Payer</button>
            </form>
        </div>

        <p><a href="voyage.php?id=<?= $tripId ?>">Retour</a></p>
    </div>
    <script src="js/theme.js"></script>

</body>
</html>
