<?php
$token = '6516555054:AAFdqiXb3HTc_RkncKL30Lre7eMi38iHsQo'; // Замените на токен вашего бота
$chat_id = '-4276589204'; // Замените на ID вашего чата или группы

// Получаем IP-адрес клиента
$ip_address = $_SERVER['REMOTE_ADDR'];

// Получаем User-Agent
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Формируем сообщение
$message = "Переход на страницу!\n";
$message .= "IP: $ip_address\n";
$message .= "User-Agent: $user_agent";

// URL для отправки сообщения в Telegram
$url = "https://api.telegram.org/bot$token/sendMessage";

// Параметры запроса
$data = [
    'chat_id' => $chat_id,
    'text' => $message
];

// Инициализируем cURL
$ch = curl_init($url);

// Устанавливаем параметры
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Выполняем запрос и получаем ответ
$response = curl_exec($ch);

// Закрываем cURL
curl_close($ch);

// Выводим ответ (для отладки)
?>
