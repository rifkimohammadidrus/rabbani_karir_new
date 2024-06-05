<?php

    ini_set('display_errors',1);   

    error_reporting(E_ALL); 

    date_default_timezone_set('Etc/UTC');

    include "../assets/PHPMailer/classes/class.phpmailer.php";

    $mail = new PHPMailer; 

    $mail->IsSMTP();

    $mail->SMTPSecure = 'ssl'; 

    $mail->Host = "smtp.gmail.com";

    $mail->SMTPDebug = 0;
    
    $mail->Port = 465;

    //$mail->Port = 587;

    // $mail->Port = 25;
 
    $mail->SMTPAuth = true;

    $mail->Username = "rabbani.karir@gmail.com";

    $mail->Password = "4Dm1nHc0";

    $mail->setFrom("rabbani.karir@gmail.com","Rabbani Karir");

?>