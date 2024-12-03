<?php
// الاتصال بقاعدة البيانات
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $reason = $_POST['reason'];

    // تحديث حالة الطلب إلى "مرفوض" مع تسجيل سبب الرفض
    $sql = "UPDATE certificate_requests SET status = 'rejected', rejection_reason = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $reason, $request_id);

    if ($stmt->execute()) {
        header("Location: certificate_requests.php");
        exit();
    } else {
        echo "حدث خطأ أثناء رفض الطلب.";
    }
}
?>
