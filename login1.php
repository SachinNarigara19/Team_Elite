<?php
header("Content-Type: application/json");
require("../config.php");

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}

if (hash("sha256", $password) !== $user["password_hash"]) {
    echo json_encode(["success" => false, "message" => "Wrong password"]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "data" => [
        "id" => $user["id"],
        "name" => $user["name"],
        "email" => $user["email"],
        "role" => $user["role"]
    ]
]);
<?php
$apiUrl = "https://api.example.com/data?apikey=6f41f985f2d94dff8bf6e084713a6a0e";

$response = file_get_contents($apiUrl);
echo $response;
?>
