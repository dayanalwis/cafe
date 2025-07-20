<?php
session_start();
include "db.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

// Validate
$required = ['name', 'phone', 'category', 'dish', 'quantity', 'arrival_time'];
foreach ($required as $field) {
  if (empty($data[$field])) {
    http_response_code(400);
    echo json_encode(['error' => "$field is required."]);
    exit;
  }
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO preorders (name, phone, category, dish, quantity, arrival_time) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
  "ssssis",
  $data['name'],
  $data['phone'],
  $data['category'],
  $data['dish'],
  $data['quantity'],
  $data['arrival_time']
);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  http_response_code(500);
  echo json_encode(['error' => 'Failed to save preorder.']);
}
