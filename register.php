<?php
include "db.php";

// Only run when form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Check if required fields are set
  if (
    isset($_POST['first_name']) && isset($_POST['last_name']) &&
    isset($_POST['email']) && isset($_POST['contact']) &&
    isset($_POST['city']) && isset($_POST['password'])
  ) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $city = $_POST['city'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert into DB
    $sql = "INSERT INTO users (first_name, last_name, email, contact, city, password)
            VALUES ('$firstName', '$lastName', '$email', '$contact', '$city', '$password')";

    if (mysqli_query($conn, $sql)) {
      echo "✅ Registration successful!";
    } else {
      echo "❌ Database error: " . mysqli_error($conn);
    }

  } else {
    echo "⚠️ All form fields are required!";
  }

} else {
  echo "⚠️ Please submit the form correctly.";
}
?>
