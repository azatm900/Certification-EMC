<?php
include('../PHPMailer/PHPMailerAutoload.php');

$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.example.com'; // تعديل الإعدادات الخاصة بك
$mail->SMTPAuth = true;
$mail->Username = 'your_email@example.com'; // تعديل البريد الإلكتروني
$mail->Password = 'your_password'; // تعديل كلمة المرور
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('your_email@example.com', 'Emirates College');
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->Body = $message;

if ($mail->send()) {
    echo 'تم إرسال البريد الإلكتروني بنجاح';
} else {
    echo 'فشل في إرسال البريد الإلكتروني';
}
