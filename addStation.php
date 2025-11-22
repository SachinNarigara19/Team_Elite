<?php
header("Content-Type: application/json");
require("../config.php");

$name = $_POST['name'];
$address = $_POST['address'];
$connector = $_POST['connector_type'];
$power = $_POST['power_kw'];
$price = $_POST['price_per_unit'];
$owner_id = $_POST['owner_id']; // from session or frontend

$stmt = $pdo->prepare("INSERT INTO stations (owner_id, name, address, connector_type, power_kw, price_per_unit, status) 
VALUES (?, ?, ?, ?, ?, ?, 'pending')");

$stmt->execute([$owner_id, $name, $address, $connector, $power, $price]);

echo json_encode(["success" => true, "message" => "Station submitted for approval"]);
