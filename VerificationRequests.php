<?php
// استبدل الاتصال بقاعدة البيانات بتفاصيل الاتصال الخاصة بك
$host = "localhost"; // أو عنوان السيرفر الخاص بك
$username = "root";
$password = "";
$database = "emc";

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($host, $username, $password, $database);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// استعلام لجلب بيانات الطلبات من جدول verification_requests
$sql = "SELECT students.full_name, students.specialization, verification_requests.submission_date, verification_requests.academic_status AS status 
        FROM verification_requests 
        JOIN students ON verification_requests.student_id = students.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جدول الطلبات الأكاديمية</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body dir="rtl">

<div class="container mt-5">
    <h2 class="text-center">طلبات التحقق الأكاديمية</h2>
    <table class="table table-bordered text-center">
        <thead class="thead-light">
            <tr>
                <th>الرقم</th> <!-- إضافة عمود الرقم -->
                <th>اسم الطالب</th>
                <th>التخصص</th>
                <th>تاريخ تقديم الطلب</th>
                <th>الحالة الأكاديمية</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // التحقق إذا كانت هناك نتائج
            if ($result->num_rows > 0) {
                $index = 1; // بدء العداد من 1
                // عرض البيانات لكل صف
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($index++) . "</td>"; // عرض الرقم التسلسلي وزيادته
                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['specialization']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['submission_date']) . "</td>";
                    // تحديد الحالة الأكاديمية
                    if ($row['status'] == 'قيد الإجراء') {
                        echo "<td class='text-warning'>" . htmlspecialchars($row['status']) . "</td>";
                    } elseif ($row['status'] == 'تم التأكيد') {
                        echo "<td class='text-success'>" . htmlspecialchars($row['status']) . "</td>";
                    } elseif ($row['status'] == 'رفض') {
                        echo "<td class='text-danger'>" . htmlspecialchars($row['status']) . "</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>لا توجد بيانات للعرض</td></tr>"; // ملاحظة: تحديث العدد الكلي للأعمدة هنا
            }

            // إغلاق الاتصال بقاعدة البيانات
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
