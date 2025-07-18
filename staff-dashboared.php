<?php
session_start();
if ($_SESSION['role'] !== 'staff') {
  header("Location: login.php");
  exit;
}
?>
<h1>Welcome, Staff</h1>
<a href="logout.php">Logout</a>
