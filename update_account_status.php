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

// استلام البيانات من الطلب
$id = $_POST['id'];
$status = $_POST['status'];

// تحديث حالة الحساب
$sql = "UPDATE students SET account_status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);
$stmt->execute();

$stmt->close();
$conn->close();
?>
