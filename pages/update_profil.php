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

$users = json_decode(file_get_contents("data/utilisateurs.json"), true);

if (!isset($users[$login])) {
    echo json_encode(["success" => false, "message" => "Utilisateur introuvable."]);
    exit;
}

$users[$login]['prenom'] = $prenom;
$users[$login]['email'] = $email;

file_put_contents("data/utilisateurs.json", json_encode($users, JSON_PRETTY_PRINT));

echo json_encode(["success" => true]);
