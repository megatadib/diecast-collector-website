<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(["error" => "Not logged in"]);
  exit;
}

$user_id = (int)$_SESSION['user_id'];

$stmt = $conn->prepare(
  "SELECT id, product_name, price, quantity 
   FROM cart 
   WHERE user_id=? 
   ORDER BY id DESC"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$out = [];
while ($row = $res->fetch_assoc()) $out[] = $row;

echo json_encode($out);
