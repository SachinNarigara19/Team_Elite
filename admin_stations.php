<?php
require_once "auth.php";
require_login();
if (!is_admin()) {
    die("Access denied (Admin only).");
}

// Handle approve / reject
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($id && in_array($action, ['approve', 'reject'])) {
        $status = $action === 'approve' ? 'approved' : 'rejected';
        $stmt = $pdo->prepare("UPDATE stations SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
}

$stmt = $pdo->prepare("SELECT s.*, u.name AS owner_name, u.email AS owner_email
                       FROM stations s
                       JOIN users u ON s.owner_id = u.id
                       ORDER BY s.created_at DESC");
$stmt->execute();
$stations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Stations - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f3f4f6; margin:0; }
        header { background:#111827; color:#fff; padding:14px 24px; display:flex; justify-content:space-between; }
        .container { padding:24px; }
        table { width:100%; border-collapse:collapse; background:white; margin-top:16px; border-radius:12px; overflow:hidden; }
        th, td { padding:10px 12px; border-bottom:1px solid #e5e7eb; font-size:14px; vertical-align:top; }
        th { background:#f9fafb; text-align:left; }
        form { display:inline; }
        button { padding:6px 10px; border:none; border-radius:6px; cursor:pointer; font-size:12px; }
        .btn-approve { background:#22c55e; color:white; }
        .btn-reject { background:#ef4444; color:white; }
        .badge { padding:3px 8px; border-radius:999px; font-size:11px; }
        .pending { background:#fef3c7; color:#92400e; }
        .approved { background:#d1fae5; color:#065f46; }
        .rejected { background:#fee2e2; color:#991b1b; }
    </style>
</head>
<body>
<header>
    <div>Manage Stations</div>
    <div>
        <a href="dashboard_admin.php" style="color:#9ca3af;margin-right:10px;">Back</a>
        <a href="logout.php" style="color:#9ca3af;">Logout</a>
    </div>
</header>
<div class="container">
    <h2>All Stations</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Owner</th>
            <th>Address</th>
            <th>Details</th>
            <th>Status / Action</th>
        </tr>
        <?php foreach ($stations as $s): ?>
            <tr>
                <td><?php echo htmlspecialchars($s['name']); ?></td>
                <td>
                    <?php echo htmlspecialchars($s['owner_name']); ?><br>
                    <small><?php echo htmlspecialchars($s['owner_email']); ?></small>
                </td>
                <td><?php echo nl2br(htmlspecialchars($s['address'])); ?></td>
                <td>
                    Connector: <?php echo htmlspecialchars($s['connector_type']); ?><br>
                    Power: <?php echo htmlspecialchars($s['power_kw']); ?> kW<br>
                    Price: <?php echo htmlspecialchars($s['price_per_unit']); ?><br>
                    Time: <?php echo htmlspecialchars($s['opening_time']." - ".$s['closing_time']); ?>
                </td>
                <td>
                    <?php
                    $class = $s['status'] === 'approved' ? 'approved' : ($s['status'] === 'rejected' ? 'rejected' : 'pending');
                    ?>
                    <span class="badge <?php echo $class; ?>">
                        <?php echo ucfirst($s['status']); ?>
                    </span><br><br>
                    <?php if ($s['status'] === 'pending'): ?>
                        <form method="post" style="margin-bottom:4px;">
                            <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                            <input type="hidden" name="action" value="approve">
                            <button class="btn-approve" type="submit">Approve</button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                            <input type="hidden" name="action" value="reject">
                            <button class="btn-reject" type="submit">Reject</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
