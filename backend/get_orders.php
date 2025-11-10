<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode([]);
  exit;
}
$user_id = $_SESSION['user_id'];

$q = $conn->prepare("SELECT id, total, created_at FROM orders WHERE user_id=? ORDER BY id DESC");
$q->bind_param("i",$user_id);
$q->execute();
$r = $q->get_result();

$out = [];
while ($row = $r->fetch_assoc()) { $out[] = $row; }
echo json_encode($out);

