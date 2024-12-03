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

// استرجاع بيانات الطلاب
$sql = "SELECT id, full_name, registration_date, specialization, account_status FROM students";
$result = $conn->query($sql);

echo '<h3>الطلبة المسجلين</h3>';
echo '<table class="table table-bordered">';
echo '<thead><tr><th>رقم</th><th>اسم الطالب</th><th>تاريخ التسجيل</th><th>التخصص</th><th>إجراءات</th></tr></thead>';
echo '<tbody>';

if ($result->num_rows > 0) {
    $counter = 1; 
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $counter++ . '</td>'; 
        echo '<td>' . htmlspecialchars($row['full_name']) . '</td>'; 
        echo '<td>' . htmlspecialchars($row['registration_date']) . '</td>';
        echo '<td>' . htmlspecialchars($row['specialization']) . '</td>';
        
        if ($row['account_status'] == 'active') {
            echo '<td><button class="btn btn-danger" onclick="toggleAccountStatus(' . $row['id'] . ', \'inactive\')">إيقاف الحساب</button></td>';
        } else {
            echo '<td><button class="btn btn-success" onclick="toggleAccountStatus(' . $row['id'] . ', \'active\')">تنشيط الحساب</button></td>';
        }

        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">لا توجد بيانات</td></tr>';
}

echo '</tbody></table>';

$conn->close();
?>
