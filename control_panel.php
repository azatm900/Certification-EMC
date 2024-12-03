<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* تعيين الاتجاه من اليمين لليسار */
        body {
            direction: rtl;
            background-color: #f7f7f7;
        }

        /* تصميم الهيدر */
        .header {
            background-color: #656768;
            padding: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .user-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
        }

        .header img {
            height: 40px;
        }

        .sidebar {
            background-color: #333;
            color: white;
            min-height: 100vh;
            padding: 15px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            margin-left: 10px;
        }

        /* تصميم الفعالية عند التمرير */
        .sidebar ul li a:hover {
            background-color: #007bff;
            padding: 5px;
            border-radius: 5px;
        }

        .content {
            padding: 20px;
        }

        /* التصميم الخاص بالبطاقات */
        .card {
            margin-bottom: 20px;
        }

        /* تصميم المربع الأبيض */
        .white-box {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* تصميم الفوتر */
        .footer {
            background-color: #808283;
            color: white;
            padding: 10px;
            text-align: center;
            position: relative;
        }

        /* لجعل التصميم متجاوب */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                width: 100%;
                height: auto;
                z-index: 999;
                display: none;
            }

            .sidebar.active {
                display: block;
            }

            .header .toggle-sidebar {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .toggle-sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- الهيدر -->
    <div class="header">
        <img src="../img/logo.png" alt="شعار الموقع">
        <h3>لوحة التحكم</h3>
        <button class="btn btn-primary toggle-sidebar" onclick="toggleSidebar()">إظهار القائمة</button>
        <div class="user-icon">
            <img src="../img/logouser.png" alt="أيقونة المستخدم">
        </div>
    </div>

    <div class="d-flex">
        <!-- القائمة الجانبية -->
        <div class="sidebar">
            <ul>
                <li><a href="#"><i class="fas fa-home"></i> الرئيسية</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> الطلبة المسجلين</a></li>
                <li><a href="verification_requests.php"><i class="fas fa-check-circle"></i> طلبات التحقق</a></li>
                <li><a href="certificate_requests.php"><i class="fas fa-certificate"></i> طلبات الشهادات</a></li>
                <li><a href="affidavit_requests.php"><i class="fas fa-file-alt"></i> طلبات الإفادات</a></li>
                <li><a href="academic_record_requests.php"><i class="fas fa-file-invoice"></i> طلبات السجلات الأكاديمية</a></li>
                <li><a href="registration_certificate_requests.php"><i class="fas fa-scroll"></i> طلبات شهادات القيد</a></li>
                <li><a href="documentation_requests.php"><i class="fas fa-paper-plane"></i> طلبات التوثيق</a></li>
                <li><a href="delivery_requests.php"><i class="fas fa-box"></i> طلبات التسليم</a></li>
                <li><a href="users.php"><i class="fas fa-users"></i> المستخدمين</a></li>
                <li><a href="admins.php"><i class="fas fa-user-tie"></i> المسؤولين</a></li>
                <li><a href="#"><i class="fas fa-user"></i> المستخدمين</a></li>
                <li><a href="#"><i class="fas fa-cogs"></i> الإعدادات</a></li>
                <li><a href="#"><i class="fas fa-file"></i> التقارير</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a></li>
            </ul>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">عدد الطلاب</h5>
                                <p class="card-text">250</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">التقارير الجديدة</h5>
                                <p class="card-text">45</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h5 class="card-title">عدد السجلات</h5>
                                <p class="card-text">10</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- المربع الأبيض المضاف -->
                <div class="row">
                    <div class="col-12">
                        <div class="white-box">
                            <h5>معلومات إضافية</h5>
                            <p>هذا هو مربع باللون الأبيض لعرض معلومات إضافية أو أي محتوى آخر.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- الفوتر -->
    <div class="footer">
        <p>© 2024 جميع الحقوق محفوظة</p>
    </div>

    <script>
        // دالة إظهار/إخفاء القائمة الجانبية
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
