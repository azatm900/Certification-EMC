<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبات التسليم</title>
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
        .accept {
            background-color: green;
        }
        .add {
            background-color: blue;
        }
        .reject {
            background-color: red;
        }
        .form-container {
            display: none;
            margin-bottom: 20px;
        }
        .form-container input, .form-container select {
            padding: 8px;
            margin: 5px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h2>طلبات التسليم</h2>

    <!-- زر لإظهار نموذج إضافة طلب تسليم -->
    <button class="button add" onclick="showForm()">إضافة طلب تسليم</button>

    <!-- نموذج إضافة طلب تسليم -->
    <div class="form-container" id="formContainer">
        <h3>إضافة طلب تسليم</h3>
        <form id="deliveryForm" enctype="multipart/form-data">
            <input type="text" id="studentName" placeholder="اسم الطالب" required><br>
            <input type="text" id="studentMajor" placeholder="تخصص الطالب" required><br>
            <input type="date" id="submissionDate" required><br>
            <input type="text" id="recipientName" placeholder="اسم المستلم" required><br>
            <input type="file" id="identityProof" name="identityProof" accept="image/*, .pdf" required><br>
            <button type="submit">إضافة الطلب</button>
        </form>
    </div>

    <!-- جدول طلبات التسليم -->
    <table>
        <thead>
            <tr>
                <th>اسم الطالب</th>
                <th>تخصص الطالب</th>
                <th>تاريخ التقديم لطلب التسليم</th>
                <th>اسم المستلم</th>
                <th>إثبات الشخصية للمستلم</th>
                <th>التصرف</th>
            </tr>
        </thead>
        <tbody id="requestsTable">
            <!-- سيتم إضافة البيانات هنا -->
        </tbody>
    </table>

    <script>
        // إظهار نموذج إدخال الطلب
        function showForm() {
            // إظهار النموذج
            const formContainer = document.getElementById("formContainer");
            formContainer.style.display = "block";
        }

        // إضافة الطلب إلى الجدول عند تقديم النموذج
        document.getElementById("deliveryForm").addEventListener("submit", function(event) {
            event.preventDefault();

            // جمع البيانات من النموذج
            let studentName = document.getElementById("studentName").value;
            let studentMajor = document.getElementById("studentMajor").value;
            let submissionDate = document.getElementById("submissionDate").value;
            let recipientName = document.getElementById("recipientName").value;
            let identityProof = document.getElementById("identityProof").files[0];

            let formData = new FormData();
            formData.append("studentName", studentName);
            formData.append("studentMajor", studentMajor);
            formData.append("submissionDate", submissionDate);
            formData.append("recipientName", recipientName);
            formData.append("identityProof", identityProof);

            // إرسال البيانات إلى الخادم باستخدام AJAX
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "process_delivery_request.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // إذا كانت الاستجابة ناجحة
                    let response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        // إضافة البيانات إلى الجدول
                        let table = document.getElementById("requestsTable");
                        let row = table.insertRow();
                        row.innerHTML = `
                            <td>${studentName}</td>
                            <td>${studentMajor}</td>
                            <td>${submissionDate}</td>
                            <td>${recipientName}</td>
                            <td><a href="${response.filePath}" target="_blank">عرض الإثبات</a></td>
                            <td>
                                <button class="button accept">تسليم</button>
                                <button class="button reject">رفض</button>
                            </td>
                        `;
                        // إخفاء النموذج بعد الإضافة
                        document.getElementById("formContainer").style.display = "none";
                        document.getElementById("deliveryForm").reset();  // إعادة تعيين النموذج
                    } else {
                        alert("حدث خطأ أثناء إضافة الطلب.");
                    }
                } else {
                    alert("حدث خطأ في الاتصال بالخادم.");
                }
            };
            xhr.send(formData);
        });
    </script>

</body>
</html>
