<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(["status"=>"error","message"=>"Not logged in"]);
  exit;
}
$user_id = (int)$_SESSION['user_id'];

$payload = json_decode(file_get_contents('php://input'), true);
$product_id = isset($payload['product_id']) ? (int)$payload['product_id'] : 0;
$qty = max(1, (int)($payload['qty'] ?? 1));

if ($product_id <= 0) {
  http_response_code(400);
  echo json_encode(["status"=>"error","message"=>"Bad product id"]);
  exit;
}

$stmt = $conn->prepare("SELECT name, price FROM products WHERE id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
  http_response_code(404);
  echo json_encode(["status"=>"error","message"=>"Product not found"]);
  exit;
}
$p = $res->fetch_assoc();

$ins = $conn->prepare("INSERT INTO cart (user_id, product_name, price, quantity) VALUES (?,?,?,?)");
$ins->bind_param("isdi", $user_id, $p['name'], $p['price'], $qty);

if (!$ins->execute()) {
  http_response_code(500);
  echo json_encode(["status"=>"error","message"=>"Insert failed: ".$conn->error]);
  exit;
}

echo json_encode(["status"=>"success","insert_id"=>$ins->insert_id]);

