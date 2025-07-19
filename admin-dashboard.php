<?php
session_start();

// Redirect if not logged in or not admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f3f3;
      padding: 20px;
    }
    .dashboard {
      max-width: 700px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
      color: #6B0F1A;
      text-align: center;
    }
    .menu {
      margin-top: 30px;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .menu a {
      text-decoration: none;
      padding: 12px;
      background: #6B0F1A;
      color: white;
      border-radius: 8px;
      text-align: center;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    .menu a:hover {
      background: #8e1a2a;
    }
    .logout {
      margin-top: 30px;
      text-align: center;
    }
    .logout a {
      color: #6B0F1A;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="dashboard">
    <h1>Welcome, Admin</h1>

    <div class="menu">
      <a href="#">👥 Manage Users</a>
      <a href="#">🍽️ Add / Edit Food Menu</a>
      <a href="#">📦 View Pre-Orders</a>
      <a href="#">📅 View Reservations</a>
      <a href="#">⚙️ Website Settings</a>
    </div>

    <div class="logout">
      <p><a href="logout.php">Logout</a></p>
    </div>
  </div>

</body>
</html>
