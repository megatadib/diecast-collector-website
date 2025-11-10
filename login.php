<?php
session_start();
include 'backend/db.php'; // provides $conn

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // 1) Get form data
  $email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');


  // 2) Query user by email
  $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // 3) Verify password
    if (password_verify($password, $user['password'])) {
      // 4) Set session
      $_SESSION['user_id']  = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role']     = $user['role'];

      // 5) Redirect by role
      if ($user['role'] === 'admin') {
        echo "<script>alert('Welcome, Admin!'); window.location.href='test.php';</script>";
      } else {
        echo "<script>alert('Login successful!'); window.location.href='index.html';</script>";
      }
      exit;
    } else {
      echo "<script>alert('Invalid password.'); window.location.href='login.html';</script>";
      exit;
    }
  } else {
    echo "<script>alert('No user found with that email.'); window.location.href='login.html';</script>";
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login — DiecastHub</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header><h1>Login to DiecastHub</h1></header>

  <main>
    <form action="login.php" method="POST" style="max-width:400px;margin:auto;background:#fff;padding:20px;border-radius:10px;">
      <label>Email:</label>
      <input type="email" name="email" required><br><br>

      <label>Password:</label>
      <input type="password" name="password" required><br><br>

      <button type="submit">Login</button>
      <p>Don’t have an account? <a href="register.html">Register</a></p>
    </form>
  </main>
</body>
</html>



