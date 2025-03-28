<?php
session_start();
require_once __DIR__ . '/DB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['confirm_password'])) {
        $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
        header("Location: http://localhost:3000/register.html");
        exit;
    }

    $u = trim($_POST['username']);
    $p = trim($_POST['password']);
    $cp = trim($_POST['confirm_password']);

    if ($p !== $cp) {
        $_SESSION['error'] = "Mật khẩu xác nhận không khớp!";
        header("Location: http://localhost:3000/register.html");
        exit;
    }

    $connection = DB::getConnection();
    if (!$connection) {
        die("Lỗi kết nối database!");
    }

    // Kiểm tra xem username đã tồn tại chưa
    $sql = "SELECT * FROM users WHERE name = :username";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['username' => $u]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = "Tên đăng nhập đã tồn tại!";
        header("Location: http://localhost:3000/register.html");
        exit;
    }

    // Mã hóa mật khẩu và thêm user vào database
    $hashed_password = password_hash($p, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (name, password) VALUES (:username, :password)";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['username' => $u, 'password' => $hashed_password]);

    $_SESSION['success'] = "Đăng ký thành công!";
    header("Location: http://localhost:3000/login.html");
    exit;
}
?>
