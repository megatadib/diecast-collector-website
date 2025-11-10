<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) { echo json_encode(["status"=>"error"]); exit; }

$user_id = $_SESSION['user_id'];
$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();

echo json_encode(["status"=>"removed"]);
