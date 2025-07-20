<?php
session_start();
include "db.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

// Validate
$required = ['name', 'phone', 'table_type', 'guest_count'];
foreach ($required as $field) {
  if (empty($data[$field])) {
    http_response_code(400);
    echo json_encode(['error' => "$field is required."]);
    exit;
  }
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO reservations (name, phone, table_type, guest_count) VALUES (?, ?, ?, ?)");
$stmt->bind_param(
  "sssi", // ✅ 4 types: string, string, string, integer
  $data['name'],
  $data['phone'],
  $data['table_type'],
  $data['guest_count']
);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  http_response_code(500);
  echo json_encode(['error' => 'Failed to save reservation.']);
}
