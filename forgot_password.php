<?php
$host = 'localhost';
$db = 'emc';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // التحقق مما إذا كان البريد الإلكتروني موجودًا في قاعدة البيانات
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // إذا كان البريد الإلكتروني موجودًا، قم بإرسال رسالة لاستعادة كلمة المرور
        // استخدم PHPMailer أو البريد المدمج في PHP (mail)
        
        // إنشاء رمز استعادة فريد
        $reset_token = bin2hex(random_bytes(16));
        
        // تحديث الرمز في قاعدة البيانات
        $sql_update = "UPDATE users SET reset_token = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $reset_token, $email);
        $stmt_update->execute();

        // رابط استعادة كلمة المرور
        $reset_link = "http://yourwebsite.com/reset_password.php?token=" . $reset_token;

        // إرسال البريد الإلكتروني (مثال باستخدام دالة mail)
        $subject = "استعادة كلمة المرور";
        $body = "مرحبا،\n\nلإعادة تعيين كلمة المرور الخاصة بك، الرجاء الضغط على الرابط التالي:\n$reset_link";
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($email, $subject, $body, $headers)) {
            $message = "تم إرسال رابط استعادة كلمة المرور إلى بريدك الإلكتروني.";
        } else {
            $message = "حدث خطأ أثناء إرسال البريد الإلكتروني. الرجاء المحاولة لاحقاً.";
        }
    } else {
        $message = "البريد الإلكتروني غير مسجل في النظام.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استعادة كلمة المرور</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .message {
            color: green;
            margin-top: 10px;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>استعادة كلمة المرور</h2>
        </div>
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="أدخل بريدك الإلكتروني" required>
                </div>
                <button type="submit" class="btn">إرسال رابط الاستعادة</button>

                <!-- عرض رسالة تأكيد أو خطأ -->
                <?php if (!empty($message)): ?>
                    <div class="message"><?php echo $message; ?></div>
                <?php endif; ?>
            </form>
            <a href="login.php" class="back-link">العودة إلى تسجيل الدخول</a>
        </div>
    </div>
</body>
</html>
