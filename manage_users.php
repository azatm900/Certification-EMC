<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli('localhost', 'root', '', 'emc');

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// استعلام لعرض المستخدمين
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// إغلاق الاتصال بعد الاستعلام
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين</title>
    <!-- إضافة رابط Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            text-align: center;
        }
        th, td {
            padding: 10px;
        }
        th {
            background-color: #f4f4f4;
        }
        .button {
            padding: 5px 15px;
            margin: 5px;
            cursor: pointer;
            border: none;
            color: #fff;
            border-radius: 5px;
        }
        .activate {
            background-color: green;
        }
        .deactivate {
            background-color: red;
        }
        .add-user-container {
            display: none;
            margin-bottom: 20px;
        }
        .add-user-container input, .add-user-container select {
            padding: 8px;
            margin: 5px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .add-user-container button {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        .add-button {
            background-color: #007bff;
        }
        .add-button i {
            margin-left: 8px; /* إضافة مسافة بعد الأيقونة */
        }
    </style>
</head>
<body>

    <h2>إدارة المستخدمين</h2>

    <!-- زر لإظهار نموذج إضافة مستخدم جديد مع أيقونة -->
    <button class="button add-button" onclick="showAddUserForm()">
        إضافة مستخدم <i class="fas fa-user-plus"></i>
    </button>

    <!-- نموذج إضافة مستخدم جديد -->
    <div class="add-user-container" id="addUserForm">
        <h3>إضافة مستخدم جديد</h3>
        <form id="addUserFormDetails" method="POST">
            <input type="text" name="username" placeholder="اسم المستخدم" required><br>
            <input type="email" name="email" placeholder="البريد الإلكتروني" required><br>
            <input type="password" name="password" placeholder="كلمة المرور" required><br>
            <input type="password" name="confirm_password" placeholder="تأكيد كلمة المرور" required><br>
            <select name="user_role" required>
                <option value="">اختر الوحدة</option>
                <option value="المالية">الوحدة المالية</option>
                <option value="النتائج">الوحدة النتائج</option>
                <option value="المسجل">المسجل</option>
            </select><br>
            <button type="submit">إضافة</button>
        </form>
    </div>

    <!-- جدول عرض المستخدمين -->
    <table>
        <thead>
            <tr>
                <th>الاسم الكامل</th>
                <th>اسم المستخدم</th>
                <th>البريد الإلكتروني</th>
                <th>الوحدة</th>
                <th>تاريخ الإنشاء</th>
                <th>الحالة</th>
               
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // عرض بيانات المستخدمين
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['full_name'] . "</td>";
                  
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['user_role'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";

                    // إذا كانت الحالة "مفعل" فإننا نعرض زر إيقاف
                    if ($row['status'] == 'مفعل') {
                        echo "<td><button class='button deactivate' onclick='toggleStatus(" . $row['id'] . ", \"موقوف\")'>إيقاف الحساب</button></td>";
                    } else {
                        echo "<td><button class='button activate' onclick='toggleStatus(" . $row['id'] . ", \"مفعل\")'>تفعيل الحساب</button></td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>لا يوجد مستخدمين</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        // دالة لعرض نموذج إضافة مستخدم
        function showAddUserForm() {
            document.getElementById("addUserForm").style.display = "block";
        }

        // دالة لتغيير حالة الحساب
        function toggleStatus(userId, newStatus) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "toggle_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert("تم تغيير الحالة بنجاح!");
                    location.reload();  // إعادة تحميل الصفحة لتحديث الجدول
                } else {
                    alert("حدث خطأ، يرجى المحاولة لاحقاً.");
                }
            };
            xhr.send("userId=" + userId + "&status=" + newStatus);
        }
    </script>

</body>
</html>

<?php
// إضافة مستخدم جديد
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_role = $_POST['user_role'];

    // التحقق من تطابق كلمة المرور
    if ($password !== $confirm_password) {
        echo "كلمة المرور غير متطابقة!";
    } else {
        // تشفير كلمة المرور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // استعلام لإضافة المستخدم
        $sql = "INSERT INTO users (username, email, password, user_role, status) 
                VALUES ('$username', '$email', '$hashed_password', '$user_role', 'مفعل')";

        if ($conn->query($sql) === TRUE) {
            echo "تم إضافة المستخدم بنجاح!";
            header("Location: manage_users.php"); // إعادة تحميل الصفحة
        } else {
            echo "خطأ في إضافة المستخدم: " . $conn->error;
        }
    }
}

$conn->close();
?>
