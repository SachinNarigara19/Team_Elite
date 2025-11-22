<?php
require_once "auth.php";
require_login();
if (!is_owner()) {
    die("Access denied (Owner only).");
}

$stmt = $pdo->prepare("SELECT * FROM stations WHERE owner_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$stations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Stations - Owner</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f3f4f6; margin:0; }
        header { background:#111827; color:#fff; padding:14px 24px; display:flex; justify-content:space-between; }
        .container { padding:24px; }
        table { width:100%; border-collapse:collapse; background:white; margin-top:16px; border-radius:12px; overflow:hidden; }
        th, td { padding:10px 12px; border-bottom:1px solid #e5e7eb; font-size:14px; }
        th { background:#f9fafb; text-align:left; }
        .badge { padding:3px 8px; border-radius:999px; font-size:11px; }
        .pending { background:#fef3c7; color:#92400e; }
        .approved { background:#d1fae5; color:#065f46; }
        .rejected { background:#fee2e2; color:#991b1b; }
    </style>
</head>
<body>
<header>
    <div>My Stations</div>
    <div>
        <a href="dashboard_owner.php" style="color:#9ca3af;margin-right:10px;">Back</a>
        <a href="logout.php" style="color:#9ca3af;">Logout</a>
    </div>
</header>
<div class="container">
    <h2>Your Registered Stations</h2>
    <?php if (count($stations) === 0): ?>
        <p>You have not added any stations yet.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Status</th>
                <th>Active</th>
            </tr>
            <?php foreach ($stations as $s): ?>
                <tr>
                    <td><?php echo htmlspecialchars($s['name']); ?></td>
                    <td><?php echo htmlspecialchars($s['address']); ?></td>
                    <td>
                        <?php
                        $class = $s['status'] === 'approved' ? 'approved' : ($s['status'] === 'rejected' ? 'rejected' : 'pending');
                        ?>
                        <span class="badge <?php echo $class; ?>">
                            <?php echo ucfirst($s['status']); ?>
                        </span>
                    </td>
                    <td><?php echo $s['is_active'] ? 'Yes' : 'No'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
