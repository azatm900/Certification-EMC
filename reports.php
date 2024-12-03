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
