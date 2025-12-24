<?php
define('TELEGRAM_BOT_TOKEN', '8513372986:AAFxXwqpZsoKTCBhtuWqklZAmH8_pfTlOU0');
define('TELEGRAM_CHAT_ID', 8436767434);

function sendTelegramMessage($message) {
    $url = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage";
    $data = ['chat_id' => TELEGRAM_CHAT_ID, 'text' => $message];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
            'ignore_errors' => true
        ]
    ];
    
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    
    // Get HTTP response code
    $httpCode = 200;
    if (isset($http_response_header)) {
        foreach ($http_response_header as $header) {
            if (preg_match('/HTTP\/\d\.\d\s+(\d+)/', $header, $matches)) {
                $httpCode = intval($matches[1]);
                break;
            }
        }
    }
    
    // Log for debugging
    error_log("Telegram API Response: " . ($result ?: 'No response'));
    error_log("Telegram HTTP Code: " . $httpCode);
    if ($result === false) {
        error_log("Telegram Error: Failed to send message");
    }
    
    return $httpCode === 200 && $result !== false;
}
?>