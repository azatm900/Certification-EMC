<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emc"; // تأكد من أن اسم قاعدة البيانات مطابق

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// استعلام لجلب بيانات التقارير
$sql = "SELECT  academic_status, financial_status, certificate_status, rejected_image, delivery_status, academic_record_status, registration_certificate_status FROM reports";
$result = $conn->query($sql);

echo "<table class='table table-bordered'>";
echo "<thead><tr><th>رقم التقرير</th><th>الحالة الأكاديمية</th><th>الحالة المالية</th><th>حالة الشهادة</th><th>الصورة المرفوضة</th><th>حالة التسليم</th><th>حالة السجل الأكاديمي</th><th>حالة شهادة القيد</th></tr></thead>";
echo "<tbody>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["report_id"] . "</td>";
        echo "<td>" . $row["academic_status"] . "</td>";
        echo "<td>" . $row["financial_status"] . "</td>";
        echo "<td>" . $row["certificate_status"] . "</td>";
        // عرض الصورة المرفوضة إذا كانت موجودة
        if ($row["rejected_image"] != "") {
            echo "<td><img src='" . $row["rejected_image"] . "' alt='الصورة المرفوضة' style='width:50px;height:50px;'></td>";
        } else {
            echo "<td>لا توجد صورة</td>";
        }

        echo "<td>" . $row["delivery_status"] . "</td>";
        echo "<td>" . $row["academic_record_status"] . "</td>";
        echo "<td>" . $row["registration_certificate_status"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>لا توجد بيانات في جدول التقارير</td></tr>";
}

echo "</tbody></table>";

$conn->close();
?>





<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقارير الحالات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">تقارير الحالات</h2>

    <table class="table table-bordered table-hover mt-4">
        <thead class="table-dark text-center">
            <tr>
                <th>النوع</th>
                <th>الحالة الأكاديمية</th>
                <th>الحالة المالية</th>
                <th>حالة الشهادة</th>
                <th>حالة السجلات الأكاديمية</th>
                <th>حالة شهادات القيد</th>
                <th>حالة التسليم</th>
                <th>ملاحظات إضافية</th>
            </tr>
        </thead>
        <tbody>
            <!-- مثال لصف بيانات -->
            <tr>
                <td>الطالب 1</td>
                <td class="text-center">
                    <span class="badge bg-success">مؤكد</span>
                </td>
                <td class="text-center">
                    <span class="badge bg-danger">مرفوض</span>
                    <br>
                    <a href="rejected_image.jpg" target="_blank">عرض الصورة المرفوضة</a>
                </td>
                <td class="text-center">
                    <span class="badge bg-success">مؤكد</span>
                </td>
                <td class="text-center">
                    <span class="badge bg-danger">مرفوض</span>
                </td>
                <td class="text-center">
                    <span class="badge bg-success">مؤكد</span>
                </td>
                <td class="text-center">
                    <span class="badge bg-success">تم التسليم</span>
                </td>
                <td>ملاحظات حول الرفض المالي أو الأكاديمي</td>
            </tr>
            <!-- يمكنك إضافة المزيد من الصفوف حسب الحاجة -->
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
