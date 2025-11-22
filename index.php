<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EV Smart Route & Charging Assistant</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f3f4f6; }
        header { background:#111827; color:#fff; padding:16px 32px; display:flex; justify-content:space-between; align-items:center; }
        a { text-decoration:none; }
        .logo { font-size:20px; font-weight:bold; }
        .btn { padding:10px 18px; border-radius:8px; border:none; cursor:pointer; font-weight:600; }
        .btn-primary { background:#2563eb; color:white; }
        .btn-outline { background:transparent; color:white; border:1px solid #9ca3af; }
        .hero { padding:60px 32px; text-align:center; }
        .hero h1 { font-size:32px; margin-bottom:16px; }
        .hero p { color:#4b5563; max-width:600px; margin:0 auto 24px; }
        .cards { display:flex; justify-content:center; gap:16px; flex-wrap:wrap; margin-top:32px; }
        .card { background:white; padding:20px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); width:260px; text-align:left; }
        .card h3 { margin-top:0; }
    </style>
</head>
<body>
<header>
    <div class="logo">EV Smart Route</div>
    <div>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php"><button class="btn btn-outline">Login</button></a>
        <?php else: ?>
            <span style="margin-right:10px;color:#e5e7eb;">Hi, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="logout.php"><button class="btn btn-outline">Logout</button></a>
        <?php endif; ?>
    </div>
</header>

<section class="hero">
    <h1>Plan EV Routes with Verified Charging Stations</h1>
    <p>Reduce range anxiety with smart route planning and an owner-verified charging station directory that you can trust.</p>
    <div>
        <a href="login.php"><button class="btn btn-primary">Get Started</button></a>
    </div>

    <div class="cards">
        <div class="card">
            <h3>EV Users</h3>
            <p>Find nearby verified stations, plan safe routes based on your battery, and avoid fake or closed locations.</p>
        </div>
        <div class="card">
            <h3>Station Owners</h3>
            <p>Register your station, manage live status, and reach real EV users through a trusted platform.</p>
        </div>
        <div class="card">
            <h3>Admin</h3>
            <p>Verify station owners, approve stations, and keep the directory clean and reliable.</p>
        </div>
    </div>
</section>
</body>
</html>
