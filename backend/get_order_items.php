<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode([]);
  exit;
}

$order_id = (int)($_GET['order_id'] ?? 0);
if ($order_id <= 0) { echo json_encode([]); exit; }

/* Optional: ensure the order belongs to this user */
$chk = $conn->prepare("SELECT 1 FROM orders WHERE id=? AND user_id=?");
$chk->bind_param("ii", $order_id, $_SESSION['user_id']);
$chk->execute();
if ($chk->get_result()->num_rows === 0) { echo json_encode([]); exit; }

$r = $conn->prepare("SELECT product_name, price, quantity FROM order_items WHERE order_id=?");
$r->bind_param("i",$order_id);
$r->execute();
$res = $r->get_result();

$items = [];
while ($row = $res->fetch_assoc()) { $items[] = $row; }
echo json_encode($items);


