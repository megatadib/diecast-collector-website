<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard — DiecastHub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body{font-family:Arial, sans-serif; margin:0; background:#f6f7f9; color:#222}
    header{background:#1f1f1f; color:#fff; padding:16px}
    .wrap{max-width:900px; margin:24px auto; padding:0 16px}
    .card{background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:18px; margin-bottom:16px}
    .btn{display:inline-block; background:#0a66c2; color:#fff; padding:10px 14px; border-radius:8px; text-decoration:none; margin:6px 8px 0 0}
    .btn.red{background:#ff5757}
  </style>
</head>
<body>
  <header><h1>Welcome Admin!</h1></header>

  <div class="wrap">
    <div class="card">
      <p>You have successfully logged in as admin.</p>
      <a class="btn" href="admin_products.html">Manage Products</a>
      <a class="btn" href="admin_events.html">Manage Events</a>
      <a class="btn" href="marketplace.html">View Marketplace</a>
      <a class="btn" href="orders.html">My Orders (test)</a>
      <a class="btn red" href="backend/logout.php">Logout</a>
      <a class="btn" href="admin_events.html">Manage Events</a>

    </div>
  </div>
<!-- 
  Protect this page: only admins allowed -->
  <script>
    (async () => {
      try {
        const r = await fetch('backend/whoami.php', { cache: 'no-store' });
        const me = await r.json();
        if (!me.logged_in || me.role !== 'admin') {
          alert('Admins only'); location.href = 'login.html';
        }
      } catch {
        alert('Session check failed'); location.href = 'login.html';
      }
    })();
  </script>
</body>
</html>

