<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usersFile = "../data/users.json";
    $users = json_decode(file_get_contents($usersFile), true) ?? [];

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    foreach ($users as $user) {
        if ($user["email"] === $email && password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user;
            header("Location: ../index.php");
            exit;
        }
    }

    $error = "Email ou mot de passe incorrect.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../pages/style.css">
</head>
<body>
    <button id="toggle-theme">Changer de thème</button>
<link id="theme-link" rel="stylesheet" href="css/clair.css">

    <script src="js/login.js"></script>
    <div class="container">
        <header class="card">
            <h1>Connexion</h1>
        </header>

        <section class="card">
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

            <form method="post" action="">
                <label>Email :</label>
                <input type="email" name="email" required><br><br>

                <label>Mot de passe :</label>
                <input type="password" name="password" required><br><br>

                <button type="submit">Se connecter</button>
            </form>
        </section>

        <p>Pas encore de compte ? <a href="signup.php">S'inscrire</a></p>
    </div>
</body>
</html>
