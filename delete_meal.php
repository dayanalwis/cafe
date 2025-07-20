<?php
session_start();
include "db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM meals WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: food_menu.php");
exit;
