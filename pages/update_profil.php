<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['login'])) {
    echo json_encode(["success" => false, "message" => "Non connecté."]);
    exit;
}

$login = $_SESSION['login'];
$prenom = $_POST['prenom'] ?? '';
$email = $_POST['email'] ?? '';

if (empty($prenom) || empty($email)) {
    echo json_encode(["success" => false, "message" => "Champs requis."]);
    exit;
}

$path = "data/utilisateurs.json";

if (!file_exists($path)) {
    echo json_encode(["success" => false, "message" => "Fichier utilisateur manquant."]);
    exit;
}

$users = json_decode(file_get_contents($path), true);

if (!isset($users[$login])) {
    echo json_encode(["success" => false, "message" => "Utilisateur introuvable."]);
    exit;
}

$users[$login]['prenom'] = $prenom;
$users[$login]['email'] = $email;

file_put_contents($path, json_encode($users, JSON_PRETTY_PRINT));

echo json_encode(["success" => true]);
?>
