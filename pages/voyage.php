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
      <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voyage</title>
  <script src="js/calcul-prix.js"></script>
</head>
<body class="dark">
    <script src="tri_voyage.js"></script>
    <button id="toggle-theme">Changer de thème</button>
<link rel="stylesheet" href="css/style.css">
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

                <form action="panier.php" method="POST">
                    <input type="hidden" name="trip_id" value="<?= $tripId ?>">
                    <button type="submit">Ajouter au panier</button>
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
    <script src="js/theme.js"></script>

</body>
</html>
