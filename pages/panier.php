<?php
session_start();
$trips = json_decode(file_get_contents("../data/trips.json"), true);

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trip_id'])) {
    $tripId = (int)$_POST['trip_id'];
    if (isset($trips[$tripId]) && !in_array($tripId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $tripId;
    }
}

// Suppression
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $removeId = (int)$_GET['remove'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($id) => $id !== $removeId);
}

// Contenu du panier
$cartTrips = array_filter($trips, fn($trip, $id) => in_array($id, $_SESSION['cart']), ARRAY_FILTER_USE_BOTH);
$totalPrice = array_reduce($_SESSION['cart'], fn($sum, $id) => $sum + $trips[$id]['total_price'], 0);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dark">
    <button id="toggle-theme">Changer de thème</button>
    <link rel="stylesheet" href="css/style.css">

    <div class="container">
        <div class="card">
            <h1>Votre panier</h1>

            <?php if (empty($cartTrips)): ?>
                <p>Votre panier est vide.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($cartTrips as $id => $trip): ?>
                        <li>
                            <strong><?= htmlspecialchars($trip['title']) ?></strong> – <?= htmlspecialchars($trip['total_price']) ?> €
                            <a href="panier.php?remove=<?= $id ?>">Supprimer</a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <p><strong>Total :</strong> <?= $totalPrice ?> €</p>

                <form action="payment.php" method="GET">
                    <?php foreach ($_SESSION['cart'] as $tripId): ?>
                        <input type="hidden" name="ids[]" value="<?= $tripId ?>">
                    <?php endforeach; ?>
                    <button type="submit">Payer tous les voyages</button>
                </form>
            <?php endif; ?>

            <p><a href="../index.php">Retour à l'accueil</a></p>
        </div>
    </div>

    <script src="js/theme.js"></script>
</body>
</html>
