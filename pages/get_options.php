<?php
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

$voyage_id = isset($_GET['voyage_id']) ? intval($_GET['voyage_id']) : 0;

if ($voyage_id <= 0) {
    echo json_encode(['error' => 'ID de voyage invalide.']);
    exit;
}

$stmt = $pdo->prepare("SELECT id, nom FROM options WHERE voyage_id = ?");
$stmt->execute([$voyage_id]);
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($options);
?>
