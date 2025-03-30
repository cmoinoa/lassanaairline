<?php
session_start();
$trips = json_decode(file_get_contents("../data/trips.json"), true);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $tripId = $_GET['id'];
    
    if ($tripId >= 0 && $tripId < count($trips)) {
        $trip = $trips[$tripId];
    } else {
        die("Voyage introuvable.");
    }
} else {
    die("ID du voyage manquant.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($trip['title']) ?></title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <div class="card">
            <h1><?= htmlspecialchars($trip['title']) ?></h1>
            <img src="<?= htmlspecialchars($trip['banner']) ?>" alt="Bannière du voyage" style="width:100%; height:auto;">

            <h2>Détails du voyage</h2>
            <p><strong>Dates :</strong> Du <?= htmlspecialchars($trip['dates']['start']) ?> au <?= htmlspecialchars($trip['dates']['end']) ?> (Durée : <?= htmlspecialchars($trip['dates']['duration']) ?> jours)</p>

            <h3>Étapes du voyage :</h3>
            <ul>
                <?php foreach ($trip['steps'] as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                <?php endforeach; ?>
            </ul>

            <h3>Spécificités :</h3>
            <ul>
                <?php foreach ($trip['specifics'] as $specific): ?>
                    <li><?= htmlspecialchars($specific) ?></li>
                <?php endforeach; ?>
            </ul>

            <h3>Options :</h3>
            <ul>
                <?php foreach ($trip['options'] as $option): ?>
                    <li><?= htmlspecialchars($option) ?></li>
                <?php endforeach; ?>
            </ul>

            <p><strong>Prix total : <?= htmlspecialchars($trip['total_price']) ?> €</strong></p>

            <?php if (isset($_SESSION["user"])): ?>
                <p>Connecté en tant que <?= htmlspecialchars($_SESSION["user"]["name"]) ?></p>

                <form action="payment.php" method="GET">
                    <input type="hidden" name="id" value="<?= $tripId ?>">
                    <button type="submit">Payer ce voyage</button>
                </form>
            <?php endif; ?>

            <br><a href="../index.php">Retour à l'acceuil</a><br>

            <?php if (!isset($_SESSION["user"])): ?>
                <p><a href="../auth/login.php">Se connecter</a> | <a href="../auth/signup.php">S'inscrire</a></p>
            <?php else: ?>
                <p><a href="../auth/logout.php">Se déconnecter</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
