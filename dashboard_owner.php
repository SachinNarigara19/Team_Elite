<?php
require_once "auth.php";
require_login();
if (!is_owner()) {
    die("Access denied (Owner only).");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Station Owner Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; background:#f3f4f6; }
        header { background:#111827; color:#fff; padding:14px 24px; display:flex; justify-content:space-between; }
        a { text-decoration:none; color:inherit; }
        .container { padding:24px; }
        .grid { display:flex; gap:16px; flex-wrap:wrap; }
        .card { background:white; padding:18px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05); flex:1; min-width:220px; }
        .btn-link { display:inline-block; margin-top:8px; font-size:14px; color:#2563eb; }
    </style>
</head>
<body>
<header>
    <div>Station Owner Dashboard</div>
    <div>
        <?php echo htmlspecialchars($_SESSION['name']); ?> (Owner)
        | <a href="logout.php" style="color:#9ca3af;">Logout</a>
    </div>
</header>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> ⚡</h2>
    <p>Register and manage your charging stations. Keep data accurate for EV users.</p>

    <div class="grid">
        <div class="card">
            <h3>Add New Station</h3>
            <p>Register a new charging station. It will go for admin verification.</p>
            <a href="owner_add_station.php" class="btn-link">Add Station</a>
        </div>
        <div class="card">
            <h3>My Stations</h3>
            <p>View and edit your existing stations, update live status, and see approval state.</p>
            <a href="owner_my_stations.php" class="btn-link">View My Stations</a>
        </div>
        <div class="card">
            <h3>Feedback & Issues</h3>
            <p>Later you can add a page for user reports and reviews for your station.</p>
        </div>
    </div>
</div>
</body>
</html>
