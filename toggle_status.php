<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli('localhost', 'root', '', 'emc');

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق من البيانات القادمة
if (isset($_POST['userId']) && isset($_POST['status'])) {
    $userId = $_POST['userId'];
    $newStatus = $_POST['status'];

    // استعلام لتحديث الحالة
    $sql = "UPDATE users SET status = '$newStatus' WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        echo "تم تحديث الحالة بنجاح!";
    } else {
        echo "خطأ في تحديث الحالة: " . $conn->error;
    }
} else {
    echo "البيانات غير صحيحة!";
}

$conn->close();
?>
