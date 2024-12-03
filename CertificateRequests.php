<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبات الشهادات</title>
    <!-- إضافة رابط Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- إضافة تنسيق CSS خاص بالصفحة -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table th, .table td {
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- محتوى الصفحة داخل container -->
    <div class="container">
        <h2 class="text-center mb-4">قائمة طلبات الشهادات</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>الاسم الأول</th>
                    <th>الاسم الثاني</th>
                    <th>الاسم الثالث</th>
                    <th>الاسم الرابع</th>
                    <th>تاريخ التقديم</th>
                    <th>نوع الشهادة</th>
                    <th>عدد الشهادات</th>
                    <th>المبلغ المدفوع</th>
                    <th>الصورة الفوتوغرافية</th>
                    <th>صورة الاشعار الأبيض</th>
                    <th>صورة إثبات الشخصية</th>
                    <th>الحالة الأكاديمية</th>
                    <th>الحالة المالية</th>
                    <th>حالة المسجل</th>
                </tr>
            </thead>
            <tbody>
                <!-- باستخدام PHP لسحب البيانات من قاعدة البيانات وعرضها في الجدول -->
                <?php
                // اتصال بقاعدة البيانات (تأكد من تغيير بيانات الاتصال حسب قاعدة البيانات الخاصة بك)
                $conn = new mysqli("localhost", "root", "", "emc");


                if ($conn->connect_error) {
                    die("فشل الاتصال: " . $conn->connect_error);
                }

                // استعلام لاستخراج جميع الطلبات
                $sql = "SELECT * FROM graduation_certificate_requests";
                $result = $conn->query($sql);

                // تحقق من وجود نتائج وعرضها في الجدول
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['second_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['third_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['fourth_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['submission_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['certificate_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['certificate_count']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['amount_paid']) . "</td>";
                        echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['photo']) . "' alt='photo' class='img-fluid' style='width: 100px;'></td>";
                        echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['receipt_image']) . "' alt='receipt_image' class='img-fluid' style='width: 100px;'></td>";
                        echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['id_proof_image']) . "' alt='id_proof_image' class='img-fluid' style='width: 100px;'></td>";
                        echo "<td>" . htmlspecialchars($row['academic_status']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['financial_status']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['registration_status']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='14' class='text-center'>لا توجد بيانات للعرض</td></tr>";
                }

                // إغلاق الاتصال
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- إضافة رابط Bootstrap JS (اختياري للوظائف التفاعلية) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
