<?php
session_start();
include "db.php";

// require 'db_connection.php'; // your database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $id = $_POST['id'];

    if ($id) {
        // Edit existing meal
        $stmt = $conn->prepare("UPDATE meals SET name=?, price=?, category=? WHERE id=?");
        $stmt->bind_param("sdsi", $name, $price, $category, $id);
    } else {
        // Create new meal
        $stmt = $conn->prepare("INSERT INTO meals (name, price, category) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $price, $category);
    }

    $stmt->execute();
    header("Location: food_menu.php"); // redirect to avoid resubmission
    exit;
}

// If editing, fetch meal data
$editMode = false;
$editMeal = null;
if (isset($_GET['edit'])) {
    $editMode = true;
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM meals WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editMeal = $stmt->get_result()->fetch_assoc();
}

// Fetch all meals
$meals = $conn->query("SELECT * FROM meals");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Food Menu Management</title>
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

<h2><?= $editMode ? 'Edit Meal' : 'Add New Meal' ?></h2>

<form method="POST" action="food_menu.php">
  <input type="hidden" name="id" value="<?= $editMeal['id'] ?? '' ?>" />
  <label>Meal Name:</label>
  <input type="text" name="name" required value="<?= htmlspecialchars($editMeal['name'] ?? '') ?>" />

  <label>Price:</label>
  <input type="number" step="0.01" name="price" required value="<?= htmlspecialchars($editMeal['price'] ?? '') ?>" />

  <label>Category:</label>
  <input type="text" name="category" required value="<?= htmlspecialchars($editMeal['category'] ?? '') ?>" />

  <button type="submit"><?= $editMode ? 'Update Meal' : 'Add Meal' ?></button>
</form>

<h2>Current Food Menu</h2>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Meal Name</th>
      <th>Price</th>
      <th>Category</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($meal = $meals->fetch_assoc()): ?>
      <tr>
        <td><?= $meal['id'] ?></td>
        <td><?= htmlspecialchars($meal['name']) ?></td>
        <td><?= $meal['price'] ?></td>
        <td><?= htmlspecialchars($meal['category']) ?></td>
        <td class="actions">
          <a href="food_menu.php?edit=<?= $meal['id'] ?>">Edit</a>
          <a href="delete_meal.php?id=<?= $meal['id'] ?>" onclick="return confirm('Are you sure you want to delete this meal?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<p><a href="admin-dashboard.php">← Back to Dashboard</a></p>

</body>
</html>
