<?php
session_start();
include "db.php";

$query = "SELECT * FROM meals WHERE category = 'SriLankan'";
$result = mysqli_query($conn, $query);

$meals = [];
while ($row = mysqli_fetch_assoc($result)) {
    $meals[] = $row;
}

echo json_encode($meals);
