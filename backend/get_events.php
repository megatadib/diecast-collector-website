<?php
header('Content-Type: application/json');
include 'db.php';

$res = $conn->query("SELECT id, title, description, location, date, time, poster FROM events ORDER BY date ASC, time ASC");
$out = [];
while ($row = $res->fetch_assoc()) $out[] = $row;
echo json_encode($out);
