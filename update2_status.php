<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli('localhost', 'root', '', 'emc');

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// هنا يجب أن تستقبل معرف الطالب (student_id) وحالة الطلب (status) من النموذج أو الطلب
$studentId = $_POST['student_id']; // معرف الطالب الذي سيتم تحديث حالته
$newStatus = $_POST['status']; // الحالة الجديدة التي سيتم تحديثها (مثلاً: "تم التوثيق" أو "رفض الحالة المالية")

// استرجاع البريد الإلكتروني للطالب بناءً على student_id
$sql = "SELECT email FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId); // ربط المعامل بالاستعلام
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // استرجاع البريد الإلكتروني
    $row = $result->fetch_assoc();
    $studentEmail = $row['email'];

    // هنا يمكنك تحديث حالة الطلب في جدول `documentation_requests`
    $updateSql = "UPDATE documentation_requests SET status = ? WHERE student_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("si", $newStatus, $studentId);
    $updateStmt->execute();

    // إذا تم تحديث الحالة بنجاح، إرسال البريد الإلكتروني
    if ($updateStmt->affected_rows > 0) {
        // رسالة البريد الإلكتروني
        $subject = "تحديث حالة طلب التوثيق";
        $message = "تم تحديث حالة طلبك في رسوم التوثيق إلى: " . $newStatus . ".\n\nإذا كان لديك أي استفسارات، يرجى التواصل معنا.";
        $headers = "From: emiratescollegeofscienceandtec@gmail.com\r\n" .
                   "Reply-To: emiratescollegeofscienceandtec@gmail.com\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // إرسال البريد الإلكتروني إلى الطالب
        if (mail($studentEmail, $subject, $message, $headers)) {
            echo "تم إرسال البريد الإلكتروني بنجاح!";
        } else {
            echo "حدث خطأ أثناء إرسال البريد الإلكتروني.";
        }
    } else {
        echo "لم يتم تحديث الحالة بنجاح.";
    }

    $updateStmt->close();
} else {
    echo "لم يتم العثور على الطالب.";
}

$stmt->close();
$conn->close();
?>
