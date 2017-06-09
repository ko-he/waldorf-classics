<?php
// If you are using Composer
require 'vendor/autoload.php';

// If you are not using Composer (recommended)
// require("path/to/sendgrid-php/sendgrid-php.php");

$from = new SendGrid\Email(null, "localhost.ko@gmail.com");
$subject = "Hello World from the SendGrid PHP Library!";
$to = new SendGrid\Email(null, "joujisaru@yahoo.co.jp");
$content = new SendGrid\Content("text/plain", "Hello, Email!");
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = getenv(SENDGRID_API_KEY);
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($mail);
