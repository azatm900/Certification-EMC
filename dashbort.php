<?php
$host = 'localhost';
$db = 'emc';
$user = 'root'; 
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT type, COUNT(*) AS count FROM requests GROUP BY type";
$result = $conn->query($sql);

$data = array('verificationCount' => 0, 'certificateCount' => 0, 'academicRecordCount' => 0, 'otherRequestsCount' => 0);

while ($row = $result->fetch_assoc()) {
    switch ($row['type']) {
        case 'التحقق':
            $data['verificationCount'] = $row['count'];
            break;
        case 'الشهادات':
            $data['certificateCount'] = $row['count'];
            break;
        case 'السجلات الأكاديمية':
            $data['academicRecordCount'] = $row['count'];
            break;
        default:
            $data['otherRequestsCount'] += $row['count'];
            break;
    }
}

echo json_encode($data);
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>لوحة التحكم</title>
    <style>
        body {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #000;
            padding-top: 20px;
            color: #fff;
            position: fixed;
            height: 100%;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #444;
        }
        .center-section {
            flex-grow: 1;
            padding: 20px;
            margin-left: 250px;
        }
        .navbar {
            background-color: #007bff; /* اللون الأزرق */
        }
        .card {
            border: none; /* إخفاء الحدود */
        }
    </style>
</head>
<body id="app">

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="path/to/logo.png" alt="شعار كلية الإمارات" style="height: 40px;">
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="path/to/user-icon.png" alt="أيقونة المستخدم" style="height: 30px;"> 
                        اسم المستخدم
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">إعدادات الحساب</a></li>
                        <li><a class="dropdown-item" href="#">تسجيل الخروج</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">تغيير اللغة</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-check-circle"></i> طلبات التحقق</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-certificate"></i> طلبات الشهادات</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-book"></i> طلبات السجلات الأكاديمية</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-paper-plane"></i> طلبات الإفادات</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-truck"></i> طلبات التسليم</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-file-alt"></i> طلبات التوثيق</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users"></i> المستخدمين</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> خروج</a></li>
    </ul>
</div>

<!-- Center Section -->
<div class="center-section">
    <div class="row">
        <div class="col-md-3" v-for="(count, type) in requestCounts" :key="type">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">{{ type }}</div>
                <div class="card-body">
                    <h5 class="card-title">{{ count }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
new Vue({
    el: '#app',
    data: {
        requestCounts: {
            'طلبات التحقق': 0,
            'طلبات الشهادات': 0,
            'طلبات السجلات الأكاديمية': 0,
            'طلبات أخرى': 0
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            $.ajax({
                url: 'path/to/your/api/endpoint.php',
                method: 'GET',
                dataType: 'json',
                success: (data) => {
                    this.requestCounts['طلبات التحقق'] = data.verificationCount;
                    this.requestCounts['طلبات الشهادات'] = data.certificateCount;
                    this.requestCounts['طلبات السجلات الأكاديمية'] = data.academicRecordCount;
                    this.requestCounts['طلبات أخرى'] = data.otherRequestsCount;
                },
                error: (error) => {
                    console.error("Error fetching data:", error);
                }
            });
        }
    }
});
</script>

<!-- إضافة Font Awesome للأيقونات -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</body>
</html>
