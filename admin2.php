<?php
session_start();
// تأكد من تسجيل الدخول قبل الوصول إلى هذه الصفحة
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // اسم المستخدم من الجلسة
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>لوحة التحكم - مالك النظام</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40; /* اللون الأسود */
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #ffffff; /* لون النص */
        }
        .sidebar .nav-link:hover {
            background-color: #495057; /* لون الخلفية عند التحويم */
        }
        .center-section {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            text-align: center;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="path/to/logo.png" alt="شعار كلية الإمارات" style="height: 40px;">
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="path/to/user-icon.png" alt="أيقونة المستخدم" style="height: 30px;"> 
                        <?php echo $username; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="logout.php">تسجيل الخروج</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="#">إدارة المستخدمين</a></li>
        <li class="nav-item"><a class="nav-link" href="#">إدارة الطلبات</a></li>
        <li class="nav-item"><a class="nav-link" href="#">إدارة الحسابات المالية</a></li>
        <li class="nav-item"><a class="nav-link" href="#">إدارة وحدة النتائج</a></li>
    </ul>
</div>

<!-- Center Section -->
<div class="center-section">
    <h2>مرحبا بك في لوحة التحكم</h2>
    <p>يمكنك هنا إدارة النظام بالكامل، بما في ذلك إضافة وحذف وتعديل المستخدمين.</p>
    <!-- هنا يمكنك إضافة مزيد من المحتوى والخيارات -->
</div>

<!-- Footer -->
<footer>
    جميع الحقوق محفوظة لكلية الإمارات للعلوم والتكنولوجيا - عزام كمال يحي آدم
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
