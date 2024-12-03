<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "emc";

// الاتصال بقاعدة البيانات
$conn = new mysqli($hostname, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// استعلام لجلب البيانات من قاعدة البيانات
$sql = "SELECT id, student_name, specialization, academic_status, financial_status, submission_date FROM verification_requests";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>طلبات التحقق</title>
    <style>
        .rejection-reason {
            display: none; /* إخفاء حقل السبب بشكل افتراضي */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>طلبات التحقق</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم رباعي</th>
                <th>تاريخ التقديم</th>
                <th>التخصص</th>
                <th>حالة وحدة النتائج</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // عرض البيانات
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['submission_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['specialization']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['academic_status']) . "</td>";
                    echo "<td>
                        <form class='verification-form' method='POST'>
                            <input type='hidden' name='request_id' value='" . $row['id'] . "'>
                            <button type='button' class='btn btn-success confirm-btn'>تأكيد</button>
                            <button type='button' class='btn btn-danger reject-btn'>رفض</button>
                            <input type='text' name='academic_status' class='form-control rejection-reason' placeholder='أدخل سبب الرفض'>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>لا توجد طلبات للتحقق.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    // عند النقر على زر الرفض
    $(".reject-btn").click(function() {
        // إظهار حقل سبب الرفض
        $(this).siblings(".rejection-reason").toggle();
    });

    // عند النقر على زر التأكيد
    $(".confirm-btn").click(function() {
        var form = $(this).closest("form");
        var requestId = form.find("input[name='request_id']").val();
        // إرسال طلب التأكيد عبر AJAX
        $.ajax({
            url: 'process_verification.php', // ملف معالجة الطلب
            type: 'POST',
            data: {
                action: 'confirm',
                request_id: requestId
            },
            success: function(response) {
                alert('تم تأكيد الطلب بنجاح!');
                location.reload(); // إعادة تحميل الصفحة لتحديث البيانات
            }
        });
    });

    // عند النقر على زر رفض
    $(".reject-btn").click(function() {
        var form = $(this).closest("form");
        var requestId = form.find("input[name='request_id']").val();
        var rejectionReason = form.find("input[name='rejection_reason']").val();

        if (rejectionReason.trim() === "") {
            alert("يرجى إدخال سبب الرفض");
            return;
        }

        // إرسال طلب الرفض عبر AJAX
        $.ajax({
            url: 'process_verification.php', // ملف معالجة الطلب
            type: 'POST',
            data: {
                action: 'reject',
                request_id: requestId,
                rejection_reason: rejectionReason
            },
            success: function(response) {
                alert('تم رفض الطلب بنجاح!');
                location.reload(); // إعادة تحميل الصفحة لتحديث البيانات
            }
        });
    });
});
</script>
</body>
</html>

<?php
// إغلاق الاتصال
$conn->close();
?>
