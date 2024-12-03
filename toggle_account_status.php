<?php
// إعدادات قاعدة البيانات
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "emc"; 

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// التحقق من أن البيانات تم إرسالها
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = $_POST['id'];
    $newStatus = $_POST['status'];

    // تحديث حالة الحساب
    $sql = "UPDATE students SET account_status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newStatus, $studentId);

    if ($stmt->execute()) {
        echo "تم تحديث حالة الحساب بنجاح";
    } else {
        echo "خطأ: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
