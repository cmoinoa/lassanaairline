<?php
require 'config.php';
require 'functions.php';
session_start();

// Redirection si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: profil.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = sanitize($_POST['nom']);
    $prenom = sanitize($_POST['prenom']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password-confirm'];

    if ($password !== $password_confirm) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $message = "Cet email est déjà utilisé.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, 'user')");
            if ($stmt->execute([$nom, $prenom, $email, $hashed_password])) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['role'] = 'user';
                header("Location: profil.php");
                exit;
            } else {
                $message = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Lassana Airline</title>
    <link rel="stylesheet" href="css/inscription.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Inscription</h1>
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Destinations</a></li>
                <li><a href="#">À propos de nous</a></li>
                <li><a href="connexion.php">Connexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="form-container">
            <h2>Créez votre compte</h2>
            <?php if ($message): ?>
                <p style="color: red;"> <?= htmlspecialchars($message) ?> </p>
            <?php endif; ?>
            <form action="inscription.php" method="post">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
                
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>

                <label for="password-confirm">Confirmez le mot de passe</label>
                <input type="password" id="password-confirm" name="password-confirm" required>

                <button type="submit">S'inscrire</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Lassana Airline - Tous droits réservés</p>
    </footer>
</body>
</html>
