<?php
header("Content-Type: application/json");
require("../config.php");

$stmt = $pdo->prepare("SELECT * FROM stations WHERE status = 'approved'");
$stmt->execute();
$stations = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["success" => true, "data" => $stations]);
