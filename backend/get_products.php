<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include 'db.php';

$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
$q     = isset($_GET['q'])     ? trim($_GET['q'])     : '';
$sort  = isset($_GET['sort'])  ? trim($_GET['sort'])  : '';

$orderBy = "ORDER BY id DESC";
if ($sort === 'price_asc')  $orderBy = "ORDER BY price ASC";
if ($sort === 'price_desc') $orderBy = "ORDER BY price DESC";
if ($sort === 'name_asc')   $orderBy = "ORDER BY name ASC";
if ($sort === 'name_desc')  $orderBy = "ORDER BY name DESC";

$where = [];
$params = [];
$types  = "";

if ($brand !== "") { $where[] = "brand = ?";        $params[] = $brand; $types .= "s"; }
if ($q     !== "") { $where[] = "(name LIKE ? OR brand LIKE ?)"; $params[] = "%$q%"; $params[] = "%$q%"; $types .= "ss"; }

$sql = "SELECT id, name, brand, price, image FROM products";
if ($where) { $sql .= " WHERE " . implode(" AND ", $where); }
$sql .= " $orderBy";

$stmt = $conn->prepare($sql);
if ($params) { $stmt->bind_param($types, ...$params); }
$stmt->execute();
$res = $stmt->get_result();

$out = [];
while ($row = $res->fetch_assoc()) $out[] = $row;
echo json_encode($out);

