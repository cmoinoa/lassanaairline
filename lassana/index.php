<?php
session_start();
$trips = json_decode(file_get_contents("data/trips.json"), true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="pages/style.css"> 
    <style>
        .header-right {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 20px;
            color: #888;
        }
        
        .welcome-message {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2rem;
            color: white;
        }
        
        .slogan {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #0073e6;
            margin-top: 10px;
        }

        .user-info {
            color: violet;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="card" style="position: relative;">
            <h1>Lassana Airlines</h1>
            <p class="slogan">"Voyagez avec style, arrivez en beauté."</p>
            
            <div class="welcome-message">
                <p>Bienvenue à bord de Lassana Airlines ! Explorez de nouveaux horizons avec nos voyages exceptionnels.</p>
            </div>
            
            <?php if (isset($_SESSION["user"])): ?>
                <p class="user-info">Connecté en tant que <?= htmlspecialchars($_SESSION["user"]["name"]) ?></p>
            <?php endif; ?>
            
            <div class="header-right">
                <?php if (isset($_SESSION["user"])): ?>
                    <p><a href="auth/logout.php">Se déconnecter</a></p>
                    <p><a href="pages/profile.php">Mon Profil</a></p>
                    <?php if ($_SESSION["user"]["permission_level"] == 1): ?>
                        <p><a href="pages/admin.php">Accéder au panneau d'administration</a></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p><a href="auth/login.php">Se connecter</a> | <a href="auth/signup.php">S'inscrire</a></p>
                <?php endif; ?>
                
                <p><a href="pages/a_propos_de_nous.php">À propos de nous</a></p>
            </div>
        </header>

        <section class="card">
            <h2>Voyages disponibles</h2>
            <div class="trips-grid">
                <?php foreach ($trips as $index => $trip): ?>
                    <div class="trip-card">
                        <a href="pages/voyage.php?id=<?= $index ?>" class="trip-link">
                            <div class="trip-banner">
                                <img src="<?= htmlspecialchars($trip['banner']) ?>" alt="Bannière du voyage" class="banner-img">
                            </div>
                            <h3><?= htmlspecialchars($trip['title']) ?></h3>
                            <p><?= htmlspecialchars($trip['description']) ?></p>
                            <span class="trip-price"><?= htmlspecialchars($trip['total_price']) ?> €</span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <div class="footer">
        <p>Lassana Airlines - Tous droits réservés</p>
    </div>
</body>
</html>
