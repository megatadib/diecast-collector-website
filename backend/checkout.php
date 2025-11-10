<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
  exit;
}

$user_id = $_SESSION['user_id'];

/* 1) Get cart items */
$stmt = $conn->prepare("SELECT id, product_name, price, quantity FROM cart WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$items = [];
$total = 0;
while ($row = $res->fetch_assoc()) {
  $items[] = $row;
  $total += (float)$row['price'] * (int)$row['quantity'];
}

if (empty($items)) {
  echo json_encode(['status'=>'error','message'=>'Cart is empty']);
  exit;
}

/* 2) Create order */
$stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt->bind_param("id", $user_id, $total);
$stmt->execute();
$order_id = $stmt->insert_id;

/* 3) Insert order items */
$oi = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
foreach ($items as $it) {
  $name = $it['product_name'];
  $price = (float)$it['price'];
  $qty = (int)$it['quantity'];
  $oi->bind_param("isdi", $order_id, $name, $price, $qty);
  $oi->execute();
}

/* 4) Clear cart */
$del = $conn->prepare("DELETE FROM cart WHERE user_id=?");
$del->bind_param("i", $user_id);
$del->execute();

echo json_encode(['status'=>'success','order_id'=>$order_id,'total'=>number_format($total,2)]);

