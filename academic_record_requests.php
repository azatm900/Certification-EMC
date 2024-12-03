<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض طلبات السجلات الأكاديمية</title>
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
        <h2 class="text-center mb-4">عرض طلبات السجلات الأكاديمية</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>الاسم الكامل</th>
                    <th>رقم العملية</th>
                    <th>إشعار أبيض</th>
                    <th>تاريخ التقديم</th>
                    <th>الحالة الأكاديمية</th>
                    <th>الحالة المالية</th>
                    <th>حالة الطباعة</th>
                    <th>سبب الرفض</th>
                    <th>حالة الطلب</th>
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
                $sql = "SELECT * FROM academic_record_requests";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // تحديد حالة الطلب بناءً على الحقول
                        $request_status = 'قيد الإجراء'; // الافتراضي
                        if ($row['academic_status'] == 'مرفوض' || $row['financial_status'] == 'مرفوض' || $row['print_status'] == 'مرفوض') {
                            $request_status = 'مرفوض';
                        } elseif ($row['academic_status'] == 'قيد المراجعة' || $row['financial_status'] == 'قيد المراجعة' || $row['print_status'] == 'قيد الإجراء') {
                            $request_status = 'قيد الإجراء';
                        } else {
                            $request_status = 'مقبول';
                        }

                        echo "<tr>
                                <td>" . $row['full_name'] . "</td>
                                <td>" . $row['operation_number'] . "</td>
                                <td><a href='" . $row['white_notice'] . "' target='_blank'>عرض الإشعار</a></td>
                                <td>" . $row['submission_date'] . "</td>
                                <td>" . $row['academic_status'] . "</td>
                                <td>" . $row['financial_status'] . "</td>
                                <td>" . $row['print_status'] . "</td>
                                <td>" . ($row['rejection_reason'] ? $row['rejection_reason'] : '-') . "</td>
                                <td>" . $request_status . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>لا توجد بيانات</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
