<?php
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]["permission_level"] != 1) {
    header("Location: ../index.php");
    exit;
}

$usersFile = "../data/users.json";
$users = json_decode(file_get_contents($usersFile), true) ?? [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_email"]) && isset($_POST["new_class"])) {
    foreach ($users as &$user) {
        if ($user["email"] == $_POST["user_email"]) {
            $user["class"] = $_POST["new_class"];
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
            header("Location: admin.php?page=" . ($_GET["page"] ?? 1));
            exit();
        }
    }
}

$usersPerPage = 10;
$totalUsers = count($users);
$totalPages = ceil($totalUsers / $usersPerPage);

$currentPage = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $totalPages) $currentPage = $totalPages;

$startIndex = ($currentPage - 1) * $usersPerPage;
$endIndex = min($startIndex + $usersPerPage, $totalUsers);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .admin {
            color: green;
            font-weight: bold;
        }
        .user {
            color: red;
            font-weight: bold;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            padding: 8px 12px;
            text-decoration: none;
            border: 1px solid black;
            margin: 0 5px;
            color: black;
            background-color: #f2f2f2;
        }
        .pagination a.active {
            font-weight: bold;
            background-color: gray;
            color: white;
        }
        .vip {
            color: blue;
            font-weight: bold;
        }
        .suspect {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>
<body>
<button id="toggle-theme">Changer de thème</button>
<link id="theme-link" rel="stylesheet" href="css/clair.css">

    <h1>Dashboard Administrateur</h1>

    <p><a href="../index.php">Retour à l'accueil</a> | <a href="../auth/logout.php">Déconnexion</a></p>

    <h2>Liste des utilisateurs (Page <?= $currentPage ?> / <?= $totalPages ?>)</h2>

    <table>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Date de naissance</th>
            <th>Date de création</th>
            <th>Permission</th>
            <th>Classe</th>
            <th>Voyages achetés</th>
        </tr>
        <?php for ($i = $startIndex; $i < $endIndex; $i++): ?>
            <tr>
                <td><?= htmlspecialchars($users[$i]["name"]) ?></td>
                <td><?= htmlspecialchars($users[$i]["email"]) ?></td>
                <td><?= htmlspecialchars($users[$i]["birthdate"]) ?></td>
                <td><?= htmlspecialchars($users[$i]["created_at"]) ?></td>
                <td class="<?= $users[$i]["permission_level"] == 1 ? "admin" : "user" ?>">
                    <?= $users[$i]["permission_level"] == 1 ? "Administrateur" : "Utilisateur" ?>
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="user_email" value="<?= $users[$i]["email"] ?>">
                        <select name="new_class">
                            <option value="normal" <?= $users[$i]["class"] == "normal" ? "selected" : "" ?>>Normal</option>
                            <option value="VIP" <?= $users[$i]["class"] == "VIP" ? "selected" : "" ?>>VIP</option>
                            <option value="suspect" <?= $users[$i]["class"] == "suspect" ? "selected" : "" ?>>Suspect</option>
                        </select>
                        <button type="submit">Modifier</button>
                    </form>
                </td>
                <td>
                    <?php if (!empty($users[$i]["trips"])): ?>
                        <ul>
                            <?php foreach ($users[$i]["trips"] as $trip): ?>
                                <li><?= htmlspecialchars($trip) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        Aucun voyage acheté
                    <?php endif; ?>
                </td>
            </tr>
        <?php endfor; ?>
    </table>

    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>">Précédent</a>
        <?php endif; ?>

        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
            <a href="?page=<?= $page ?>" class="<?= $page == $currentPage ? "active" : "" ?>"><?= $page ?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>">Suivant</a>
        <?php endif; ?>
    </div>
<script src="js/theme.js"></script>

</body>
</html>
