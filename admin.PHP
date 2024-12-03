<?php
// بدء الجلسة
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم مالك النظام</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- رابط ملف الـ CSS -->
</head>
<body>
    <!-- Sidebar -->
    <div class="d-flex" id="wrapper">
        <div class="bg-dark border-right" id="sidebar-wrapper">
            <div class="sidebar-heading text-white">لوحة التحكم</div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">طلبات التحقق</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">طلبات الشهادات</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">طلبات السجلات الأكاديمية</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">طلبات شهادات القيد</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">طلبات التوثيق</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">طلبات التسليم</a>
                <a href="manage_users.php" class="list-group-item list-group-item-action bg-dark text-white">المستخدمين</a>
                <a href="registered_students.php" class="list-group-item list-group-item-action bg-dark text-white">الطلاب المسجلين</a>
                <a href="reports.php" class="list-group-item list-group-item-action bg-dark text-white">التقارير</a>
                <a href="logout.php" class="list-group-item list-group-item-action bg-dark text-white">خروج</a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-primary" id="menu-toggle">إخفاء/إظهار القائمة</button>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <img src="logo.png" alt="شعار الكلية" class="college-logo">
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                <img src="user_icon.png" alt="المستخدم" class="user-icon">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">تغيير اللغة</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">خروج</a>
                            </div>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="بحث" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">بحث</button>
                    </form>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">
                <h1 class="mt-4">أهلاً بك في لوحة تحكم مالك النظام</h1>
                <p>هنا يمكنك التحكم في جميع جوانب النظام.</p>
            </div>

            <!-- Footer -->
            <footer class="footer bg-dark text-white text-center py-3 mt-4">
                كل الحقوق محفوظة لدى كلية الإمارات للعلوم والتكنولوجيا - عزام كمال يحي آدم
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
</html>
