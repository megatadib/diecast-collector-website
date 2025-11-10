<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure hash

  // Check if email already exists
  $check = $conn->prepare("SELECT * FROM users WHERE email=?");
  $check->bind_param("s", $email);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    echo "<script>alert('Email already registered!'); window.location.href='../register.html';</script>";
  } else {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'customer')");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
      echo "<script>alert('Registration successful! Please login.'); window.location.href='../login.html';</script>";
    } else {
      echo "<script>alert('Error: Could not register.'); window.location.href='../register.html';</script>";
    }
  }
}
$conn->close();
?>
