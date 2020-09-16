<?php

require_once 'vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com',465,'ssl'))
  ->setUsername(MAIL)
  ->setPassword(PASSWORD_MAIL)
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);



function sendPasswordResetLink($userEmail,$token){
    global $mailer;

$body='<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
</head>
<body>
    <div class="wrapper">
        <p>
        Hello there,

        Please Click on the link below to reset your password.

        </p>
        <a href="http://localhost/wejapa/wejapablog/new-pass?token='. $token . '">Reset your Password</a>
    </div>
    
    <script src="" async defer></script>
</body>
</html>';

$message = (new Swift_Message('Reset your password'))
->setFrom([MAIL])
->setTo([$userEmail])
->setBody($body,'text/html')
;

// Send the message
$result = $mailer->send($message);

}