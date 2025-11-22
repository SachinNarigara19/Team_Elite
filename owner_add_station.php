<?php
require_once "auth.php";
require_login();
if (!is_owner()) {
    die("Access denied (Owner only).");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $connector_type = trim($_POST['connector_type'] ?? '');
    $power_kw = (int)($_POST['power_kw'] ?? 0);
    $price_per_unit = (float)($_POST['price_per_unit'] ?? 0);
    $opening_time = $_POST['opening_time'] ?? null;
    $closing_time = $_POST['closing_time'] ?? null;

    if ($name === "" || $address === "") {
        $message = "Name and address are required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO stations 
            (owner_id, name, address, connector_type, power_kw, price_per_unit, opening_time, closing_time, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([
            $_SESSION['user_id'],
            $name,
            $address,
            $connector_type,
            $power_kw,
            $price_per_unit,
            $opening_time,
            $closing_time
        ]);
        $message = "Station submitted for admin approval.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Station - Owner</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f3f4f6; margin:0; }
        header { background:#111827; color:#fff; padding:14px 24px; display:flex; justify-content:space-between; }
        .container { padding:24px; max-width:600px; margin:0 auto; }
        label { display:block; margin-top:10px; font-size:14px; }
        input, textarea { width:100%; padding:8px; border-radius:6px; border:1px solid #d1d5db; margin-top:4px; }
        button { margin-top:16px; padding:10px 16px; border:none; border-radius:8px; background:#2563eb; color:white; cursor:pointer; }
        .msg { margin-top:10px; font-size:14px; }
    </style>
</head>
<body>
<header>
    <div>Add Station</div>
    <div>
        <a href="dashboard_owner.php" style="color:#9ca3af;margin-right:10px;">Back</a>
        <a href="logout.php" style="color:#9ca3af;">Logout</a>
    </div>
</header>
<div class="container">
    <h2>Add New Charging Station</h2>
    <?php if ($message): ?>
        <div class="msg"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Station Name *</label>
        <input type="text" name="name" required>

        <label>Address *</label>
        <textarea name="address" rows="3" required></textarea>

        <label>Connector Type</label>
        <input type="text" name="connector_type" placeholder="CCS2, Type2, CHAdeMO etc.">

        <label>Power (kW)</label>
        <input type="number" name="power_kw" min="0">

        <label>Price per unit (₹/kWh or session)</label>
        <input type="number" step="0.01" name="price_per_unit">

        <label>Opening Time</label>
        <input type="time" name="opening_time">

        <label>Closing Time</label>
        <input type="time" name="closing_time">

        <button type="submit">Submit for Approval</button>
    </form>
</div>
</body>
</html>

