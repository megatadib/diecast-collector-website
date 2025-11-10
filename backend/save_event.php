<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  http_response_code(403);
  echo json_encode(['status'=>'error','message'=>'Admin only']);
  exit;
}

$id          = $_POST['id']          ?? '';
$title       = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$location    = trim($_POST['location'] ?? '');
$date        = $_POST['date'] ?? '';
$time        = $_POST['time'] ?? '';

if ($title === '' || $description === '' || $location === '' || $date === '' || $time === '') {
  http_response_code(400);
  echo json_encode(['status'=>'error','message'=>'All fields are required.']);
  exit;
}

// ---- handle poster (optional) ----
$poster_name = null;
if (!empty($_FILES['poster']['name'])) {
  // simple validation
  $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
  if (!in_array($_FILES['poster']['type'], $allowed)) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'Poster must be JPG/PNG/WEBP/GIF']);
    exit;
  }
  if ($_FILES['poster']['size'] > 3 * 1024 * 1024) { // 3MB
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'Poster too large (max 3MB)']);
    exit;
  }

  $safe = preg_replace('/[^a-zA-Z0-9._-]/','_', basename($_FILES['poster']['name']));
  $poster_name = time().'_'.$safe;
  $dest = "../uploads/events/".$poster_name;
  if (!move_uploaded_file($_FILES['poster']['tmp_name'], $dest)) {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'Failed to save poster']);
    exit;
  }
}

if ($id) {
  if ($poster_name) {
    $stmt = $conn->prepare("UPDATE events SET title=?, description=?, location=?, date=?, time=?, poster=? WHERE id=?");
    $stmt->bind_param("ssssssi", $title, $description, $location, $date, $time, $poster_name, $id);
  } else {
    $stmt = $conn->prepare("UPDATE events SET title=?, description=?, location=?, date=?, time=? WHERE id=?");
    $stmt->bind_param("sssssi", $title, $description, $location, $date, $time, $id);
  }
  $stmt->execute();
  echo json_encode(['status'=>'success','message'=>'Event updated']);
} else {
  $stmt = $conn->prepare("INSERT INTO events (title, description, location, date, time, poster) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $title, $description, $location, $date, $time, $poster_name);
  $stmt->execute();
  echo json_encode(['status'=>'success','message'=>'Event added']);
}

