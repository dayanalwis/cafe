<?php
session_start();

// Redirect if not logged in or not staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Staff Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
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
      color: #0F4C75;
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
      background: #0F4C75;
      color: white;
      border-radius: 8px;
      text-align: center;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    .menu a:hover {
      background: #145374;
    }
    .logout {
      margin-top: 30px;
      text-align: center;
    }
    .logout a {
      color: #0F4C75;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="dashboard">
    <h1>Welcome, Staff</h1>

    <div class="menu">
      <a href="#">📋 View & Confirm Reservations</a>
      <a href="#">📝 Process Pre-Orders</a>
      <a href="#">🔄 Modify / Cancel Orders</a>
    </div>

    <div class="logout">
      <p><a href="logout.php">Logout</a></p>
    </div>
  </div>

</body>
</html>
