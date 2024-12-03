<?php
// إعدادات قاعدة البيانات
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "emc"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// قبول التحقق
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $studentId = intval($_POST['id']);
    $sql = "UPDATE students SET verification_status = 'approved' WHERE id = $studentId";

    if ($conn->query($sql) === TRUE) {
        echo "تم قبول التحقق بنجاح.";
    } else {
        echo "حدث خطأ أثناء قبول التحقق: " . $conn->error;
    }
}

$conn->close();
?>
