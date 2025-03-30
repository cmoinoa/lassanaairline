<?php
session_start();

if (!isset($_SESSION["user"])) {
    die("Erreur : Vous devez être connecté pour effectuer un paiement.");
}

$usersFile = "../data/users.json";
$paymentsFile = "../data/payments.json";
$tripsFile = "../data/trips.json";

$users = json_decode(file_get_contents($usersFile), true) ?? [];
$trips = json_decode(file_get_contents($tripsFile), true) ?? [];
$payments = json_decode(file_get_contents($paymentsFile), true) ?? [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST["trip_id"], $_POST["card_name"], $_POST["card_number"], $_POST["card_expiry"], $_POST["card_cvv"])) {
        die("Erreur : Informations de paiement incomplètes.");
    }

    $tripId = (int) $_POST["trip_id"];
    $cardName = trim($_POST["card_name"]);
    $cardNumber = $_POST["card_number"];
    $cardExpiry = $_POST["card_expiry"];
    $cardCVV = $_POST["card_cvv"];

    if (!isset($trips[$tripId])) {
        die("Erreur : Voyage introuvable.");
    }

    $trip = $trips[$tripId];

    if (!preg_match("/^\d{16}$/", $cardNumber) || !preg_match("/^\d{3}$/", $cardCVV)) {
        die("Erreur : Numéro de carte ou CVV invalide.");
    }

    $paymentData = [
        "user" => $_SESSION["user"]["email"],
        "trip" => $trip["title"],
        "amount" => $trip["total_price"],
        "date" => date("Y-m-d H:i:s"),
    ];
    $payments[] = $paymentData;
    file_put_contents($paymentsFile, json_encode($payments, JSON_PRETTY_PRINT));

    foreach ($users as &$user) {
        if ($user["email"] === $_SESSION["user"]["email"]) {
            if (!isset($user["trips"])) {
                $user["trips"] = [];
            }
            $user["trips"][] = $trip["title"];
            break;
        }
    }
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

    header("Location: profile.php");
    exit;
}

die("Erreur : Requête invalide.");
?>
