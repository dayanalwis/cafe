<?php
session_start();
include "db.php";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id = $_POST['id'];

    if ($id) {
        // Edit existing meal
        $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, role=?, password=? WHERE id=?");
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $role, $password, $id);
    } else {
        // Create new meal
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, role, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $role, $password);
    }

    $stmt->execute();
    header("Location: users_page.php"); // redirect to avoid resubmission
    exit;
}

// If editing, fetch meal data
$editMode = false;
$editMeal = null;
if (isset($_GET['edit'])) {
    $editMode = true;
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editMeal = $stmt->get_result()->fetch_assoc();
}

// Fetch all users
$users = $conn->query("SELECT * FROM preorders");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f3f3;
      padding: 20px;
    }
    h2 {
      color: #6B0F1A;
    }
    form, table {
      background: white;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    input, select {
      padding: 8px;
      width: 100%;
      margin: 8px 0;
    }
    button {
      background-color: #6B0F1A;
      color: white;
      padding: 10px 20px;
      border: none;
      margin-top: 10px;
      cursor: pointer;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #6B0F1A;
      color: white;
    }
    .actions a {
      margin: 0 5px;
      text-decoration: none;
      color: #6B0F1A;
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- <h2><?= $editMode ? 'Edit User' : 'Add New User' ?></h2> -->

<!-- <form method="POST" action="users_page.php">
  <input type="hidden" name="id" value="<?= $editMeal['id'] ?? '' ?>" />
  <label>First Name:</label>
  <input type="text" name="first_name" required value="<?= htmlspecialchars($editMeal['first_name'] ?? '') ?>" />

  <label>Last Name:</label>
  <input type="text" name="last_name" required value="<?= htmlspecialchars($editMeal['last_name'] ?? '') ?>" />

  <label>Email:</label>
  <input type="text" name="email" required value="<?= htmlspecialchars($editMeal['email'] ?? '') ?>" />

  <label>Role:</label>
  <input type="text" name="role" required value="<?= htmlspecialchars($editMeal['role'] ?? '') ?>" />

  <label>Password:</label>
  <input type="text" name="password" required value="<?= htmlspecialchars($editMeal['password'] ?? '') ?>" />

  <button type="submit"><?= $editMode ? 'Update User' : 'Add User' ?></button>
</form> -->

<h2>Pre-Orders</h2>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Customer Name</th>
      <th>PhoneNumber</th>
      <th>Meal Category</th>
      <th>Dish</th>
      <th>Quantity</th>
      <th>Arriaval Time</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($user = $users->fetch_assoc()): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['phone']) ?></td>
        <td><?= htmlspecialchars($user['category']) ?></td>
        <td><?= htmlspecialchars($user['dish']) ?></td>
        <td><?= htmlspecialchars($user['quantity']) ?></td>
        <td><?= htmlspecialchars($user['arrival_time']) ?></td>
        <td class="actions">
          <a href="users_page.php?edit=<?= $user['id'] ?>">Edit</a>
          <a href="delete_meal.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this meal?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<p><a href="admin-dashboard.php">← Back to Dashboard</a></p>

</body>
</html>
