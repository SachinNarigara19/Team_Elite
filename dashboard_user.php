<?php
require_once "auth.php";
require_login();
if (!is_user()) {
    die("Access denied (User only).");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard - EV Smart Route</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; background:#f3f4f6; }
        header { background:#111827; color:#fff; padding:14px 24px; display:flex; justify-content:space-between; }
        a { text-decoration:none; color:inherit; }
        .container { padding:24px; }
        .grid { display:flex; flex-wrap:wrap; gap:16px; }
        .card { background:white; padding:18px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05); flex:1; min-width:220px; }
        .btn-link { display:inline-block; margin-top:8px; font-size:14px; color:#2563eb; }
    </style>
</head>
<body>
<header>
    <div>User Dashboard</div>
    <div>
        <?php echo htmlspecialchars($_SESSION['name']); ?> (User)
        | <a href="logout.php" style="color:#9ca3af;">Logout</a>
    </div>
</header>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> 👋</h2>
    <p>Plan EV routes, browse nearby verified stations, and avoid range anxiety.</p>

    <div class="grid">
        <div class="card">
            <h3>Plan Smart Route</h3>
            <p>Enter your start, destination, and battery level to get suggested stations on your route.</p>
            <a href="user_plan_route_dummy.php" class="btn-link">Open Route Planner (demo)</a>
        </div>
        <div class="card">
            <h3>Browse Verified Stations</h3>
            <p>See all approved owner-verified charging stations in the directory.</p>
            <a href="user_stations.php" class="btn-link">View Stations</a>
        </div>
        <div class="card">
            <h3>Profile & Vehicles</h3>
            <p>Manage your account and EV details for better range predictions.</p>
            <span style="font-size:12px;color:#6b7280;">(You can add this page later: user_profile.php)</span>
        </div>
    </div>
</div>
</body>
</html>
