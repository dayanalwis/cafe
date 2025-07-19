<?php
session_start();
include "db.php";



$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);

  $password = $_POST['password'];

  // Prepare statement to prevent SQL injection
  if ($stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($row = $result->fetch_assoc()) {
      if (password_verify($password, $row['password'])) {



        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($row['role'] == 'admin') {
          header("Location: admin-dashboard.php");
        } elseif ($row['role'] == 'staff') {
          header("Location: staff-dashboard.php");
        } else {
          header("Location: customer-dashboard.php");
        }
        exit;
      } else {
        $error = "❌ Incorrect password!";
      }
    } else {
      $error = "❌ No user found with this email.";
    }
    $stmt->close();
  } else {
    $error = "❌ Database query error.";
  }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
  <h2>Login</h2>
  <form action="login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
  </form>
  <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
</body>
</html>
