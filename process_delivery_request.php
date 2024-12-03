<?php
// اتصال قاعدة البيانات
$conn = new mysqli('localhost', 'username', 'password', 'database');

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق من وجود البيانات
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // الحصول على البيانات من النموذج
    $student_name = $_POST['studentName'];
    $student_major = $_POST['studentMajor'];
    $submission_date = $_POST['submissionDate'];
    $recipient_name = $_POST['recipientName'];

    // التعامل مع ملف إثبات الهوية
    if (isset($_FILES['identityProof']) && $_FILES['identityProof']['error'] === UPLOAD_ERR_OK) {
        $identity_proof = $_FILES['identityProof']['name'];

        // مسار المجلد الذي سيتم تخزين الملفات فيه
        $upload_directory = 'uploads/';
        $upload_path = $upload_directory . basename($identity_proof);
        // نقل الملف إلى المجلد المحدد
        if (move_uploaded_file($_FILES['identityProof']['tmp_name'], $upload_path)) {
            // إدخال البيانات إلى قاعدة البيانات
            $stmt = $conn->prepare("INSERT INTO delivery_requests (student_name, student_major, submission_date, recipient_name, identity_proof) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $student_name, $student_major, $submission_date, $recipient_name, $identity_proof);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'filePath' => $upload_path]);
            } else {
                echo json_encode(['success' => false]);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }

    $conn->close();
}
?>
