<?php

class mySMSMessage {

    protected $smsusername = "hallhmik";  // Имя пользователя для SMS API
    protected $smspassword = "pablosov";  // Пароль для SMS API
    protected $url = "https://smsgate.h2a.co.uk/sms/sendsms.php";  // URL для отправки SMS
    protected $maxlength = 459;  // Максимальная длина сообщения

    public function send($tonumbers, $message) {
        // Обрезка сообщения, если оно превышает максимальную длину
        if (strlen($message) > $this->maxlength) {
            $message = substr($message, 0, $this->maxlength - 3) . "...";
        }

        // Формирование параметров для запроса
        $params = "usr=" . $this->smsusername . "&pwd=" . $this->smspassword . "&to=" . $tonumbers . "&message=" . urlencode($message);
        
        // Инициализация cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        
        // Выполнение запроса и получение ответа
        $returned = curl_exec($ch);
        curl_close($ch);

        // Возврат результата
        return $returned;
    }
}

// Пример использования:

// Создаем объект класса mySMSMessage
$sms = new mySMSMessage();

// Вводим номера телефонов и сообщение
$numbers = "+380977776771";  // Замените на нужные номера через запятую
$message = "Привет! Это тестовое сообщение.";  // Ваше сообщение

// Отправляем SMS и выводим результат
$result = $sms->send($numbers, $message);
echo "Результат отправки: " . $result;

?>
