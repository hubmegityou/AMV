<?php

$email=$_POST['email'];
$contact=$_POST['contact'];
$name=$_POST['name'];


$to      = $email;
$subject = 'the subject';
$message = 'hahahahahhahahahah hehehehehehehhe';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);