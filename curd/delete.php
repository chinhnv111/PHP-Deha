<?php
include_once __DIR__.'/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
    User::destroy($id);
    User::resetAutoIncrement(); // Cập nhật lại ID

    $_SESSION['message'] = "Xóa thành công!";
    header("Location: index.php");
    exit();
} else {
    $_SESSION['message'] = "Lỗi: Không có ID hợp lệ!";
    header("Location: index.php");
    exit();
}
?>
