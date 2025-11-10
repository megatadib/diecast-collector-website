<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['count' => 0]); exit;
}

$user_id = (int)$_SESSION['user_id'];
$stmt = $conn->prepare("SELECT COALESCE(SUM(quantity),0) AS c FROM cart WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

echo json_encode(['count' => (int)$row['c']]);
