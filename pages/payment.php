<?php
session_start();
$trips = json_decode(file_get_contents("../data/trips.json"), true);
$tripIds = isset($_GET['ids']) ? array_map('intval', $_GET['ids']) : [];

if (empty($tripIds)) {
    die("Erreur : Aucun voyage sélectionné.");
}

$selectedTrips = [];
foreach ($tripIds as $id) {
    if (isset($trips[$id])) {
        $selectedTrips[] = $trips[$id];
    }
}

if (empty($selectedTrips)) {
    die("Erreur : Voyages invalides.");
}

$tripTitle = count($selectedTrips) === 1 ? $selectedTrips[0]['title'] : 'Plusieurs voyages';
$totalPrice = array_sum(array_column($selectedTrips, 'total_price'));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - <?= htmlspecialchars($tripTitle) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dark">
    <button id="toggle-theme">Changer de thème</button>
    <link rel="stylesheet" href="css/style.css">

    <div class="container">
        <div class="card">
            <h1>Paiement pour <?= htmlspecialchars($tripTitle) ?></h1>
            <p>Prix total : <?= htmlspecialchars($totalPrice) ?> €</p>

            <form action="process_payment.php" method="POST">
                <?php foreach ($tripIds as $id): ?>
                    <input type="hidden" name="trip_ids[]" value="<?= $id ?>">
                <?php endforeach; ?>

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

        <p><a href="panier.php">Retour au panier</a></p>
    </div>
    <script src="js/theme.js"></script>
</body>
</html>
