<?php
header("Content-Type: application/json");
require("../config.php");

$station_id = $_POST['station_id'];
$status = $_POST['status']; // approved / rejected

$stmt = $pdo->prepare("UPDATE stations SET status = ? WHERE id = ?");
$stmt->execute([$status, $station_id]);

echo json_encode(["success" => true, "message" => "Station status updated"]);
