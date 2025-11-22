<?php
require_once "auth.php";
require_login();
if (!is_user()) {
    die("Access denied (User only).");
}

$stmt = $pdo->prepare("SELECT s.*, u.name AS owner_name 
                       FROM stations s 
                       JOIN users u ON s.owner_id = u.id
                       WHERE s.status = 'approved' AND s.is_active = 1
                       ORDER BY s.created_at DESC");
$stmt->execute();
$stations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verified Stations - User</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f3f4f6; margin:0; }
        header { background:#111827; color:#fff; padding:14px 24px; display:flex; justify-content:space-between; }
        a { text-decoration:none; color:inherit; }
        .container { padding:24px; }
        table { width:100%; border-collapse:collapse; margin-top:16px; background:white; border-radius:12px; overflow:hidden; }
        th, td { padding:10px 12px; border-bottom:1px solid #e5e7eb; font-size:14px; }
        th { background:#f9fafb; text-align:left; }
        tr:hover { background:#f3f4f6; }
        .badge { padding:3px 8px; border-radius:999px; font-size:11px; background:#d1fae5; color:#065f46; }
    </style>
</head>
<body>
<header>
    <div>Verified Stations</div>
    <div>
        <a href="dashboard_user.php" style="color:#9ca3af;margin-right:10px;">Back to Dashboard</a>
        <a href="logout.php" style="color:#9ca3af;">Logout</a>
    </div>
</header>
<div class="container">
    <h2>Owner-Verified Charging Stations ✅</h2>
    <?php if (count($stations) === 0): ?>
        <p>No approved stations yet.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Owner</th>
                <th>Address</th>
                <th>Connector</th>
                <th>Power (kW)</th>
                <th>Price</th>
                <th>Timing</th>
            </tr>
            <?php foreach ($stations as $s): ?>
                <tr>
                    <td><?php echo htmlspecialchars($s['name']); ?> <span class="badge">Verified</span></td>
                    <td><?php echo htmlspecialchars($s['owner_name']); ?></td>
                    <td><?php echo htmlspecialchars($s['address']); ?></td>
                    <td><?php echo htmlspecialchars($s['connector_type']); ?></td>
                    <td><?php echo htmlspecialchars($s['power_kw']); ?></td>
                    <td><?php echo htmlspecialchars($s['price_per_unit']); ?></td>
                    <td><?php echo htmlspecialchars($s['opening_time'] . " - " . $s['closing_time']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
