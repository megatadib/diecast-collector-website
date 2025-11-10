<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  http_response_code(403); echo json_encode(['status'=>'error','message'=>'Admin only']); exit;
}

$id = (int)($_GET['id'] ?? 0);
if ($id<=0){ echo json_encode(['status'=>'error','message'=>'Bad id']); exit; }

$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

echo json_encode(['status'=>'success']);
