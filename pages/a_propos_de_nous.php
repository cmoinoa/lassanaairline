<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos de nous</title>
    <link rel="stylesheet" href="style.css">
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
<body class="dark">
    <button id="toggle-theme">Changer de thème</button>
<link rel="stylesheet" href="css/style.css">
    <div class="container">
        <header class="card" style="position: relative;">
            <h1>Lassana Airlines</h1>
            <p class="slogan">"Voyagez avec style, arrivez en beauté."</p>
            
            <?php if (isset($_SESSION["user"])): ?>
                <p class="user-info">Connecté en tant que <?= htmlspecialchars($_SESSION["user"]["name"]) ?></p>
            <?php endif; ?>
            
            <div class="header-right">
                <p><a href="../index.php">Retour à l'accueil</a></p>
                <?php if (isset($_SESSION["user"])): ?>
                    <p><a href="../auth/logout.php">Se déconnecter</a></p>
                    <p><a href="profile.php">Mon Profil</a></p>
                    <?php if ($_SESSION["user"]["permission_level"] == 1): ?>
                        <p><a href="admin.php">Accéder au panneau d'administration</a></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p><a href="../auth/login.php">Se connecter</a> | <a href="../auth/signup.php">S'inscrire</a></p>
                <?php endif; ?>
            </div>
        </header>

        <section class="about-section card">
            <h2>À propos de Lassana Airlines</h2>
            <p>
                Lassana Airlines est une compagnie aérienne dédiée à offrir des expériences de voyage exceptionnelles. Nous nous efforçons de rendre chaque vol une aventure inoubliable, en mettant l'accent sur la qualité de notre service, la sécurité de nos passagers et le confort de nos avions. Que vous voyagiez pour affaires ou pour le plaisir, nous vous garantissons un service à la hauteur de vos attentes.
            </p>
            <p>
                Fondée avec la vision de transformer l'industrie aérienne, Lassana Airlines s'engage à connecter les voyageurs du monde entier tout en respectant les standards les plus élevés de sécurité et de confort. Nous croyons en l'innovation, en l'excellence et en la satisfaction totale de nos clients.
            </p>
            <p>
                Nous vous invitons à explorer nos différentes destinations et à profiter de nos services adaptés à vos besoins. Chez Lassana Airlines, chaque voyage est une promesse d'aventure et de bien-être.
            </p>
        </section>

        <section class="team card">
            <h2>Notre Équipe</h2>
            <div class="team-member">
            <h3>PDG</h3>
                <p>Noa Feliot-Bertrand</p>
            </div>
            <div class="team-member">
            <h3>Directrice des opérations</h3>
                <p>Mathieu Jacques</p>
            </div>
            <div class="team-member">
            <h3>Responsable marketing</h3>
                <p>Maxence Pouliquen</p>
            </div>
        </section>
    </div>

    <div class="footer">
        <p>Lassana Airlines - Tous droits réservés</p>
    </div>
    <script src="js/theme.js"></script>

</body>
</html>
