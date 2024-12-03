<?php
$host = 'localhost';
$db = 'emc';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// تحقق من الاتصال بقاعدة البيانات
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // استعلام للتحقق من البريد الإلكتروني في جدول الطلاب
    $sql_student = "SELECT * FROM students WHERE email = ?";
    $stmt_student = $conn->prepare($sql_student);
    $stmt_student->bind_param("s", $email);
    $stmt_student->execute();
    $result_student = $stmt_student->get_result();

    // استعلام للتحقق من البريد الإلكتروني في جدول المستخدمين
    $sql_user = "SELECT * FROM users WHERE email = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $email);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    // التحقق إذا كان الطالب موجودًا
    if ($result_student->num_rows > 0) {
        $student = $result_student->fetch_assoc();

        // التحقق من كلمة المرور
        if (password_verify($password, $student['password'])) {
            session_start();
            $_SESSION['user_id'] = $student['id'];
            $_SESSION['user_name'] = $student['full_name'];
            $_SESSION['role'] = 'student';

            header("Location: student/student_dashboard.php");
            exit();
        } else {
            $error_message = "كلمة المرور غير صحيحة.";
        }
    } 
    // التحقق إذا كان المستخدم موجودًا
    else if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();

        // التحقق من كلمة المرور
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['role'] = $user['user_role'];

            // التوجيه حسب الدور
            switch ($user['user_role']) {
                case 'results_unit':
                    header("Location: results_unit/dashboard.php");
                    break;
                case 'finance_manager':
                    header("Location: finance/dashboard.php");
                    break;
                case 'registrar':
                    header("Location: registrar/dashboard.php");
                    break;
                case 'admin_panel':
                    header("Location: admin/admin_panel.php");
                    break;
                default:
                    $error_message = "دور غير معروف.";
                    break;
            }
            exit();
        } else {
            $error_message = "كلمة المرور غير صحيحة.";
        }
    } else {
        $error_message = "البريد الإلكتروني غير موجود.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كلية الإمارات للعلوم والتكنولوجيا</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .error {
            color: red;
            margin-top: 10px;
        }
        .forgot-password {
            display: block;
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="img/logo.png" alt="كلية الإمارات للعلوم والتكنولوجيا">
            <h2>تسجيل الدخول</h2>
        </div>
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="البريد الإلكتروني" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="كلمة المرور" required>
                </div>
                <button type="submit" class="btn">تسجيل الدخول</button>

                <!-- عرض رسالة الخطأ إن وجدت -->
                <?php if (!empty($error_message)): ?>
                    <div class="error"><?php echo $error_message; ?></div>
                <?php endif; ?>
            </form>
            <a href="student/register.php" class="signup-link">تسجيل حساب جديد</a>
            <a href="forgot_password.php" class="forgot-password">هل نسيت كلمة المرور؟</a> <!-- رابط هل نسيت كلمة المرور -->
        </div>
    </div>
</body>
</html>
