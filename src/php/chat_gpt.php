<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <title>Formularz z ChatGPT</title>-->
<!--</head>-->
<!--<body>-->
<!--<form method="POST">-->
<!--    <label for="message">Wprowadź swoją wiadomość:</label>-->
<!--    <input type="text" id="message" name="message"><br><br>-->
<!--    <button type="submit" name="submit">Wyślij</button>-->
<!--</form>-->
<!---->
<?php
//if(isset($_POST['submit'])) {
//    $message = $_POST['message'];
//
//    // wysłanie zapytania do ChatGPT
//    $url = 'https://api.openai.com/v1/engines/davinci-codex/completions';
//    $headers = [
//        'Content-Type: application/json',
//        'Authorization: Bearer YOUR_API_KEY_HERE'
//    ];
//    $data = [
//        'prompt' => $message,
//        'temperature' => 0.7,
//        'max_tokens' => 50
//    ];
//    $options = [
//        'http' => [
//            'header'  => implode("\r\n", $headers),
//            'method'  => 'POST',
//            'content' => json_encode($data)
//        ]
//    ];
//    $context  = stream_context_create($options);
//    $response = file_get_contents($url, false, $context);
//    $decoded_response = json_decode($response, true);
//    $chat_response = $decoded_response['choices'][0]['text'];
//
//    // wyświetlenie odpowiedzi z ChatGPT
//    echo '<p>Odpowiedź od ChatGPT:</p>';
//    echo '<p>' . $chat_response . '</p>';
//}
//?>
<!---->
<!--</body>-->
<!--</html>-->