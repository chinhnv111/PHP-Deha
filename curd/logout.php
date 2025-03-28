<?php
session_start();

// Hủy tất cả dữ liệu trong session
session_unset();
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: http://localhost:3000/login.html");
exit;
?>