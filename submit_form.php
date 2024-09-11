<?php
// التحقق مما إذا تم إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استرداد وتنقية بيانات الإدخال
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // التحقق من صحة البريد الإلكتروني
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "تنسيق البريد الإلكتروني غير صالح";
        exit;
    }

    // إعدادات البريد الإلكتروني
    $to = "info@theglobalhub.net"; // استبدل بعنوان بريدك الإلكتروني
    $subject = "استفسار جديد عن مشروع من $name";
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "Content-Type: text/html; charset=UTF-8";

    // محتوى البريد الإلكتروني
    $emailBody = "<html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
            h2 { color: #A52C45; }
            p { font-size: 1.1em; color: #333; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>استفسار جديد عن مشروع</h2>
            <p><strong>الاسم:</strong> $name</p>
            <p><strong>البريد الإلكتروني:</strong> $email</p>
            <p><strong>رقم الهاتف:</strong> $phone</p>
            <p><strong>الرسالة:</strong><br>$message</p>
        </div>
    </body>
    </html>";

    // إرسال البريد الإلكتروني
    if (mail($to, $subject, $emailBody, $headers)) {
        echo "شكراً على رسالتك. سنعاود الاتصال بك قريباً.";
    } else {
        echo "حدثت مشكلة أثناء إرسال رسالتك. يرجى المحاولة مرة أخرى لاحقاً.";
    }
} else {
    // ليس طلب POST
    echo "طريقة الطلب غير صالحة.";
}
?>
