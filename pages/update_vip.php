<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["success" => false, "message" => "Accès refusé."]);
    exit;
}

$user = $_POST['user'] ?? '';
$vip = isset($_POST['vip']) && $_POST['vip'] == 1;

$path = "data/utilisateurs.json";

if (!file_exists($path)) {
    echo json_encode(["success" => false, "message" => "Fichier utilisateur manquant."]);
    exit;
}

$users = json_decode(file_get_contents($path), true);

if (!isset($users[$user])) {
    echo json_encode(["success" => false, "message" => "Utilisateur introuvable."]);
    exit;
}

$users[$user]['vip'] = $vip;

sleep(1); // Pour afficher l'icône ⏳ pendant 1 seconde

file_put_contents($path, json_encode($users, JSON_PRETTY_PRINT));

echo json_encode(["success" => true]);
?>