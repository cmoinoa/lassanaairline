<?php
session_start();

$usersFile = "../data/users.json";
$users = json_decode(file_get_contents($usersFile), true) ?? [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $birthdate = $_POST["birthdate"];
    $created_at = date("Y-m-d H:i:s");
    $autoLogin = isset($_POST["auto_login"]);

    foreach ($users as $user) {
        if ($user["email"] === $email) {
            echo "Cet email est déjà utilisé.";
            exit;
        }
    }

    $newUser = [
        "name" => $name,
        "email" => $email,
        "password" => $password,
        "birthdate" => $birthdate,
        "created_at" => $created_at,
        "permission_level" => 0,
        "class" => "normal",
        "trips" => []
    ];

    $users[] = $newUser;
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

    if ($autoLogin) {
        $_SESSION["user"] = $newUser;
        header("Location: ../index.php");
        exit;
    }

    header("Location: ../pages/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../pages/style.css">
</head>
<body>
    <button id="toggle-theme">Changer de thème</button>
<link id="theme-link" rel="stylesheet" href="css/clair.css">

    <div class="container">
        <header class="card">
            <h1>Inscription</h1>
        </header>

        <section class="card">
            <form method="POST">
                <label>Nom :</label>
                <input type="text" name="name" required><br>

                <label>Email :</label>
                <input type="email" name="email" required><br>

                <label>Mot de passe :</label>
                <input type="password" name="password" required><br>

                <label>Date de naissance :</label>
                <input type="date" name="birthdate" required><br>

                <label>
                    <input type="checkbox" name="auto_login"> Me connecter directement après l'inscription
                </label><br>

                <button type="submit">S'inscrire</button>
            </form>
        </section>

        <p>Déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    </div>
    <script src="js/theme.js"></script>

</body>
</html>
