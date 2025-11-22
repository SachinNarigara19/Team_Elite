<?php
require_once "auth.php";
require_login();
if (!is_admin()) {
    die("Access denied (Admin only).");
}

// simple counts
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalStations = $pdo->query("SELECT COUNT(*) FROM stations")->fetchColumn();
$pendingStations = $pdo->query("SELECT COUNT(*) FROM stations WHERE status='pending'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - EV Smart Route</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; background:#f3f4f6; }
        header { background:#111827; color:#fff; padding:14px 24px; display:flex; justify-content:space-between; }
        .container { padding:24px; }
        .grid { display:flex; gap:16px; flex-wrap:wrap; }
        .card { background:white; padding:18px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05); flex:1; min-width:220px; }
        .btn-link { display:inline-block; margin-top:8px; font-size:14px; color:#2563eb; }
        .metric { font-size:24px; font-weight:bold; }
    </style>
</head>
<body>
<header>
    <div>Admin Dashboard</div>
    <div>
        <?php echo htmlspecialchars($_SESSION['name']); ?> (Admin)
        | <a href="logout.php" style="color:#9ca3af;">Logout</a>
    </div>
</header>
<div class="container">
    <h2>Welcome, Admin 🛡️</h2>
    <div class="grid">
        <div class="card">
            <h3>Total Users</h3>
            <div class="metric"><?php echo $totalUsers; ?></div>
        </div>
        <div class="card">
            <h3>Total Stations</h3>
            <div class="metric"><?php echo $totalStations; ?></div>
        </div>
        <div class="card">
            <h3>Pending Stations</h3>
            <div class="metric"><?php echo $pendingStations; ?></div>
            <a href="admin_stations.php" class="btn-link">Review Stations</a>
        </div>
    </div>
</div>
</body>
</html>
    