<?php
session_start();
if ($_SESSION['role'] !== 'customer') {
  header("Location: login.php");
  exit;
}
?>
<h1>Welcome, Customer</h1>
<a href="logout.php">Logout</a>
