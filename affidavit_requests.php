<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض طلبيات الإفادة</title>
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
        <h2 class="text-center mb-4">عرض طلبيات الإفادة</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>الاسم الرباعي</th>
                    <th>رقم العملية</th>
                    <th>إثبات الشخصية</th>
                    <th>تاريخ التقديم</th>
                    <th>الحالة الأكاديمية</th>
                    <th>الحالة المالية</th>
                    <th>حالة الطباعة</th>
                    <th>حالة الطلب</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // الاتصال بقاعدة البيانات
                $conn = new mysqli("localhost", "root", "", "emc"); // تأكد من اسم قاعدة البيانات وبيانات الاتصال

                // التحقق من الاتصال
                if ($conn->connect_error) {
                    die("فشل الاتصال: " . $conn->connect_error);
                }

                // استعلام لاستخراج جميع الطلبيات
                $sql = "SELECT * FROM affidavit_requests";
                $result = $conn->query($sql);

                // التحقق إذا كانت هناك نتائج
                if ($result->num_rows > 0) {
                    // عرض كل طلب في صف منفصل
                    while($row = $result->fetch_assoc()) {
                        // تحديد حالة الطلب بناءً على الحالة الأكاديمية، المالية، وحالة الطباعة
                        if ($row['academic_status'] == 'مرفوض' || $row['financial_status'] == 'مرفوض') {
                            $request_status = 'مرفوض';
                        } elseif ($row['academic_status'] == 'قيد المراجعة' || $row['financial_status'] == 'قيد المراجعة') {
                            $request_status = 'قيد الإجراء';
                        } else {
                            $request_status = 'مقبول';
                        }

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['operation_number']) . "</td>";
                        echo "<td><a href='" . htmlspecialchars($row['id_proof']) . "' target='_blank'>عرض</a></td>";  // رابط لإثبات الشخصية
                        echo "<td>" . htmlspecialchars($row['submission_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['academic_status']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['financial_status']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['print_status']) . "</td>";
                        echo "<td>" . $request_status . "</td>";  // حالة الطلب
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>لا توجد طلبيات للإفادة</td></tr>";
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
