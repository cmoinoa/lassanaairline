<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../auth/login.php");
    exit;
}

$users = json_decode(file_get_contents("../data/users.json"), true) ?? [];
$currentUser = null;

foreach ($users as $user) {
    if ($user["email"] === $_SESSION["user"]["email"]) {
        $currentUser = $user;
        break;
    }
}

if (!$currentUser) {
    die("Erreur : utilisateur introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= htmlspecialchars($currentUser["name"]) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dark">
    <button id="toggle-theme">Changer de thème</button>
<link rel="stylesheet" href="css/style.css">
    <div class="container">
        <div class="card">
            <h1>Profil de <?= htmlspecialchars($currentUser["name"]) ?></h1>
            <p><strong>Email :</strong> <?= htmlspecialchars($currentUser["email"]) ?></p>
            <p><strong>Date de naissance :</strong> <?= htmlspecialchars($currentUser["birthdate"]) ?></p>
            <p><strong>Date de création du compte :</strong> <?= htmlspecialchars($currentUser["created_at"]) ?></p>
            <p><strong>Classe :</strong> <?= htmlspecialchars($currentUser["class"]) ?></p>

            <h2>Mes voyages achetés</h2>
            <?php
            $trips = json_decode(file_get_contents("../data/trips.json"), true) ?? [];

            if (!empty($currentUser["trips"])): ?>
                <ul>
                    <?php foreach ($currentUser["trips"] as $tripTitle): ?>
                        <?php

                        $tripId = null;
                        foreach ($trips as $index => $trip) {
                            if ($trip["title"] === $tripTitle) {
                                $tripId = $index;
                                break;
                            }
                        }
                        ?>
                        <?php if ($tripId !== null): ?>
                            <li>
                                <a href="voyage.php?id=<?= $tripId ?>">
                                    <?= htmlspecialchars($tripTitle) ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li><?= htmlspecialchars($tripTitle) ?> (Voyage introuvable)</li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun voyage acheté.</p>
            <?php endif; ?>

            <p><a href="../index.php">Retour à l'accueil</a></p>
        </div>
    </div>
    <script src="js/theme.js"></script>

</body>
</html>
