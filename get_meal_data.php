<?php
session_start();
include "db.php";

// If fetching all categories
if (!isset($_GET['category'])) {
    $query = "SELECT DISTINCT category FROM meals";
    $result = mysqli_query($conn, $query);
    $categories = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }

    echo json_encode(['categories' => $categories]);
    exit;
}

// If fetching meals for a category
$category = $_GET['category'];
$stmt = $conn->prepare("SELECT name FROM meals WHERE category = ?");
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

$meals = [];
while ($row = $result->fetch_assoc()) {
    $meals[] = $row['name'];
}

echo json_encode(['meals' => $meals]);
