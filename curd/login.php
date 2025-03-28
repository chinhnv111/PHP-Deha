<?php
session_start();
require_once __DIR__ . '/DB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
        header("Location:http://localhost:3000/login.html");
        exit;
    }

    $u = trim($_POST['username']);
    $p = trim($_POST['password']);

    // Kết nối database
    $connection = DB::getConnection();
    if (!$connection) {
        die("Lỗi kết nối database!");
    }

    // Truy vấn lấy user theo username
    $sql = "SELECT * FROM users WHERE name = :username";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['username' => $u]);
    $user = $stmt->fetch();

    // Kiểm tra mật khẩu
    if ($user && password_verify($p, $user['password'])) {
        $_SESSION['user'] = $user['name'];
        header("Location:http://localhost:3000/index.php");

        exit;
    } else {
        $_SESSION['error'] = "Sai tên đăng nhập hoặc mật khẩu";
        header("Location:http://localhost:3000/login.html");
        exit;
    }
}
?>
