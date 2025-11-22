<?php
session_start();
require_once "config.php";

function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

function require_role($role) {
    require_login();
    if ($_SESSION['role'] !== $role) {
        die("Access denied for this role.");
    }
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
function is_owner() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'owner';
}
function is_user() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
}
?>
