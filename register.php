<?php
header("Content-Type: application/json");
require("../config.php");

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'user';

$check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$check->execute([$email]);

if ($check->rowCount() > 0) {
    echo json_encode(["success" => false, "message" => "Email already registered"]);
    exit;
}

$password_hash = hash("sha256", $password);

$stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
$stmt->execute([$name, $email, $password_hash, $role]);

echo json_encode(["success" => true, "message" => "Account created successfully"]);
