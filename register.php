<?php
include "db.php";

// receive data from HTML form
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$city = $_POST['city'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// insert into MySQL
$sql = "INSERT INTO users (first_name, last_name, email, contact, city, password)
        VALUES ('$firstName', '$lastName', '$email', '$contact', '$city', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "✅ Registration successful!";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}
?>
