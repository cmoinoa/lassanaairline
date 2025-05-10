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

    if (
        !isset($_POST["trip_ids"]) ||
        !isset($_POST["card_name"], $_POST["card_number"], $_POST["card_expiry"], $_POST["card_cvv"])
    ) {
        die("Erreur : Informations de paiement incomplètes.");
    }

    $tripIds = array_map('intval', $_POST["trip_ids"]);
    $cardName = trim($_POST["card_name"]);
    $cardNumber = $_POST["card_number"];
    $cardExpiry = $_POST["card_expiry"];
    $cardCVV = $_POST["card_cvv"];

    if (!preg_match("/^\d{16}$/", $cardNumber) || !preg_match("/^\d{3}$/", $cardCVV)) {
        die("Erreur : Numéro de carte ou CVV invalide.");
    }

    $userEmail = $_SESSION["user"]["email"];
    $paidTrips = [];
    $totalAmount = 0;

    foreach ($tripIds as $tripId) {
        if (!isset($trips[$tripId])) continue;

        $trip = $trips[$tripId];
        $paidTrips[] = $trip["title"];
        $totalAmount += $trip["total_price"];

        // Ajouter à l'historique utilisateur
        foreach ($users as &$user) {
            if ($user["email"] === $userEmail) {
                if (!isset($user["trips"])) {
                    $user["trips"] = [];
                }
                if (!in_array($trip["title"], $user["trips"])) {
                    $user["trips"][] = $trip["title"];
                }
                break;
            }
        }
    }

    // Sauvegarder un seul paiement groupé
    $payments[] = [
        "user" => $userEmail,
        "trips" => $paidTrips,
        "amount" => $totalAmount,
        "date" => date("Y-m-d H:i:s")
    ];

    file_put_contents($paymentsFile, json_encode($payments, JSON_PRETTY_PRINT));
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

    // Vider le panier après paiement
    unset($_SESSION['cart']);

    header("Location: profile.php");
    exit;
}

die("Erreur : Requête invalide.");
