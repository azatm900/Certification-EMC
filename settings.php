<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعدادات الحساب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            margin: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-container h3 {
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h3>إعدادات الحساب</h3>

        <form action="update_settings.php" method="POST">
            <label for="username">اسم المستخدم</label>
            <input type="text" id="username" name="username" value="اسم المستخدم الحالي" required>

            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" value="البريد الإلكتروني الحالي" required>

            <label for="password">كلمة المرور الجديدة</label>
            <input type="password" id="password" name="password" placeholder="أدخل كلمة مرور جديدة" required>

            <label for="confirm_password">تأكيد كلمة المرور الجديدة</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="أعد إدخال كلمة المرور" required>

            <label for="language">اللغة</label>
            <select id="language" name="language" required>
                <option value="ar">العربية</option>
                <option value="en">الإنجليزية</option>
            </select>

            <button type="submit" class="button">حفظ التغييرات</button>
        </form>
    </div>

</body>
</html>
