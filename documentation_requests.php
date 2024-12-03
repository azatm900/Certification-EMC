<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض طلبات توثيق الشهادات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center mb-4">عرض طلبات توثيق الشهادات</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>الاسم الكامل</th>
                    <th>تاريخ التقديم</th>
                    <th>عدد الشهادات</th>
                    <th>نوع الشهادات</th>
                    <th>لغة الشهادات</th>
                    <th>إشعار أبيض</th>
                    <th>رقم العملية</th>
                    <th>الحالة المالية</th>
                    <th>حالة التوثيق</th>
                    <th>العمليات</th>
                    <th>سبب الرفض</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // الاتصال بقاعدة البيانات
                $conn = new mysqli("localhost", "root", "", "emc"); // تأكد من اسم قاعدة البيانات وبيانات الاتصال

                if ($conn->connect_error) {
                    die("فشل الاتصال: " . $conn->connect_error);
                }

                // استعلام لاستخراج جميع الطلبيات
                $sql = "SELECT * FROM documentation_requests";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // تحديد حالة الطلب بناءً على الحقول
                        $rejection_reason = $row['rejection_reason'] ? $row['rejection_reason'] : '-';
                        
                        echo "<tr>
                                <td>" . $row['full_name'] . "</td>
                                <td>" . $row['submission_date'] . "</td>
                                <td>" . $row['certificates_count'] . "</td>
                                <td>" . $row['certificates_type'] . "</td>
                                <td>" . $row['certificates_language'] . "</td>
                                <td><a href='" . $row['white_notice'] . "' target='_blank'>عرض الإشعار</a></td>
                                <td>" . $row['operation_number'] . "</td>
                                <td>" . $row['financial_status'] . "</td>
                                <td>" . $row['documentation_status'] . "</td>
                                <td>";

                        // عرض الأزرار بناءً على الحالة المالية وحالة التوثيق
                        if ($row['financial_status'] == 'قيد الإجراء') {
                            echo "<button class='btn btn-success'>تأكيد الحالة المالية</button> ";
                            echo "<button class='btn btn-danger'>رفض الحالة المالية</button>";
                        }

                        if ($row['documentation_status'] == 'قيد الإجراء') {
                            echo "<button class='btn btn-success'>تأكيد التوثيق</button> ";
                            echo "<button class='btn btn-danger'>رفض التوثيق</button>";
                        }

                        echo "</td>
                                <td>" . $rejection_reason . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='11' class='text-center'>لا توجد بيانات</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
