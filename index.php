<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شاشة المسجل</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- إضافة jQuery لدعم AJAX -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- إضافة Bootstrap Icons -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .logo img {
            max-height: 50px;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            position: fixed;
            right: 0; /* القائمة الجانبية في اليمين */
            width: 200px;
        }
        .sidebar a {
            color: white;
            padding: 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-right: 200px; /* ترك مساحة للقائمة الجانبية */
            padding: 20px;
        }
        footer {
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
            background-color: #f8f9fa;
            padding: 10px;
        }
        .navbar .ms-auto {
            margin-right: auto; /* تحريك الشعار إلى اليسار */
        }
        .navbar .me-auto {
            margin-left: auto; /* تحريك الأيقونة إلى اليمين */
        }
        .user-icon {
            width: 40px;
            height: 40px;
            cursor: pointer;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 10px;
        }
        .dropdown-content p, .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
        }
        .show {
            display: block;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header class="d-flex justify-content-between align-items-center p-3 bg-light">
        <div class="logo">
            <img src="logo.png" alt="شعار كلية الإمارات للعلوم والتكنولوجيا">
        </div>
        <div class="user-menu">
            <img src="../student/logouser.png" alt="User Icon" class="user-icon" onclick="toggleDropdown()">
            <div id="userDropdown" class="dropdown-content">
                <p><?php echo isset($student['full_name']) ? htmlspecialchars($student['full_name']) : 'اسم المستخدم'; ?></p>
                <a href="../logout.php">تسجيل الخروج</a>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="d-flex">
        <div class="sidebar">
            <a href="#" onclick="loadContent('cert-requests.php')">
                <i class="bi bi-file-earmark-text"></i> طلبيات الشهادة
            </a>
            <a href="#" onclick="loadContent('enroll-requests.php')">
                <i class="bi bi-file-earmark-richtext"></i> طلبيات شهادات القيد
            </a>
            <a href="#" onclick="loadContent('academic-records.php')">
                <i class="bi bi-file-earmark-spreadsheet"></i> طلبيات السجلات الأكاديمية
            </a>
            <a href="#" onclick="loadContent('delivery-requests.php')">
                <i class="bi bi-truck"></i> طلبيات التسليم
            </a>
            <a href="#" onclick="loadContent('doc-requests.php')">
                <i class="bi bi-file-earmark-lock"></i> طلبيات التوثيق
            </a>
            <a href="#">
                <i class="bi bi-box-arrow-right"></i> خروج
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <h3>مرحباً بك في شاشة المسجل</h3>
            <p>يرجى اختيار نوع الطلب لعرض التفاصيل.</p>

            <!-- كود PHP لعرض الطلبات من قاعدة البيانات -->
            <?php
                // بدء جلسة العمل إذا لم يكن قد بدأ بالفعل
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                // التأكد من تسجيل الدخول
                if (!isset($_SESSION['student_id'])) {
                    header("Location: ../login.php");
                    exit();
                }

                // جلب بيانات الطالب (مثال)
                // يجب عليك تعديل هذا الجزء ليتناسب مع نظامك
                $student_id = $_SESSION['student_id'];
                // الاتصال بقاعدة البيانات
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "emc";

                // إنشاء الاتصال
                $conn = new mysqli($servername, $username, $password, $dbname);

                // التحقق من الاتصال
                if ($conn->connect_error) {
                    die("فشل الاتصال: " . $conn->connect_error);
                }

                // استعلام لجلب اسم الطالب (تأكد من وجود جدول وعمود مناسب)
                $student_sql = "SELECT full_name FROM students WHERE id = ?";
                $stmt = $conn->prepare($student_sql);
                $stmt->bind_param("i", $student_id);
                $stmt->execute();
                $stmt->bind_result($full_name);
                $stmt->fetch();
                $stmt->close();

                // استعلام SQL لعرض الطلبات (تأكد من أسماء الأعمدة الصحيحة)
                $sql = "SELECT request_id, student_full_name, type_of_request, request_date FROM requests WHERE student_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $student_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table class='table table-striped'>";
                    echo "<thead><tr><th>رقم الطلب</th><th>اسم الطالب</th><th>نوع الطلب</th><th>تاريخ الطلب</th></tr></thead>";
                    echo "<tbody>";
                    // عرض البيانات
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["request_id"]) . "</td>
                                <td>" . htmlspecialchars($row["student_full_name"]) . "</td>
                                <td>" . htmlspecialchars($row["type_of_request"]) . "</td>
                                <td>" . htmlspecialchars($row["request_date"]) . "</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p>لا توجد طلبات</p>";
                }

                // إغلاق الاتصال
                $stmt->close();
                $conn->close();
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>جميع الحقوق محفوظة لكلية الإمارات للعلوم والتكنولوجيا - عزام كمال يحيى آدم</p>
    </footer>

    <script>
        // Function to toggle dropdown
        function toggleDropdown() {
            var dropdown = document.getElementById("userDropdown");
            dropdown.classList.toggle("show");
        }

        // Function to load content using AJAX
        function loadContent(page) {
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('#main-content').html(data); // Load content into the main-content div
                },
                error: function() {
                    $('#main-content').html('<p>حدث خطأ أثناء تحميل الصفحة.</p>');
                }
            });
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.user-icon')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>
