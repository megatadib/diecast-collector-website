<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  http_response_code(403); echo json_encode(['status'=>'error','message'=>'Admin only']); exit;
}

$id    = $_POST['id']    ?? '';
$brand = $_POST['brand'] ?? '';
$name  = $_POST['name']  ?? '';
$price = (float)($_POST['price'] ?? 0);

$image_name = null;
if (!empty($_FILES['image']['name'])) {
  $safe = preg_replace('/[^a-zA-Z0-9._-]/','_', basename($_FILES['image']['name']));
  $image_name = time().'_'.$safe;
  move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image_name);
}

if ($id) { // update
  if ($image_name) {
    $stmt = $conn->prepare("UPDATE products SET brand=?, name=?, price=?, image=? WHERE id=?");
    $stmt->bind_param("ssdsi", $brand, $name, $price, $image_name, $id);
  } else {
    $stmt = $conn->prepare("UPDATE products SET brand=?, name=?, price=? WHERE id=?");
    $stmt->bind_param("ssdi", $brand, $name, $price, $id);
  }
  $stmt->execute();
  echo json_encode(['status'=>'success','message'=>'Product updated']);
} else { // insert
  $stmt = $conn->prepare("INSERT INTO products (brand, name, price, image) VALUES (?,?,?,?)");
  $stmt->bind_param("ssds", $brand, $name, $price, $image_name);
  $stmt->execute();
  echo json_encode(['status'=>'success','message'=>'Product added']);
}
