<?php

$to = "joel.lustgarten@yahoo.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: webmaster@example.com" . "\r\n" .
"CC: somebodyelse@example.com";

if(mail($to,$subject,$txt,$headers)){
    $message = "ok";
    echo "<script>alert('$message');</script>";
} else {
     $message = "Not ok";
    echo "<script>alert('$message');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <a href="../materials/datosesi.txt">link</a>
</head>
<body>
    <p>test</p>
</body>
</html>