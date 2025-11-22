<?php
session_start();
require_once "config.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === "" || $password === "") {
        $error = "Please enter both email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // using SHA2 for demo (same as db insert)
        if ($user && hash('sha256', $password) === $user['password_hash']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: dashboard_admin.php");
            } elseif ($user['role'] === 'owner') {
                header("Location: dashboard_owner.php");
            } else {
                header("Location: dashboard_user.php");
            }
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - EV Smart Route</title>
    <style>
        body { font-family: Arial, sans-serif; background:#e5e7eb; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; }
        .card { background:white; padding:24px 28px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.08); width:340px; }
        h2 { margin-top:0; text-align:center; }
        label { display:block; margin-top:12px; font-size:14px; }
        input { width:100%; padding:8px; margin-top:4px; border-radius:6px; border:1px solid #d1d5db; }
        button { margin-top:16px; width:100%; padding:10px; border:none; border-radius:8px; background:#2563eb; color:white; font-weight:600; cursor:pointer; }
        .error { color:#b91c1c; font-size:14px; margin-top:10px; text-align:center; }
        .hint { font-size:12px; color:#6b7280; margin-top:12px; }
    </style>
</head>
<body>
<div class="card">
    <h2>Login</h2>
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>

        <div class="hint">
            Demo logins:<br>
            admin@ev.com / 123456 (Admin)<br>
            owner@ev.com / 123456 (Owner)<br>
            user@ev.com / 123456 (User)
        </div>
    </form>
</div>
</body>
</html>
