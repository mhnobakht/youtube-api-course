<?php

namespace Controllers;

class MailController {

    private static $to;
    private static $subject;
    private static $message;
    private static $headers;
    private static $senderEmailAddress = 'academy01projectmail@gmail.com';

    public static function send($to, $subject, $message) {

        self::$to = $to;
        self::$subject = $subject;
        self::$message = $message;

        self::$headers = "MIME-VERSION: 1.0" . "\r\n";
        self::$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        self::$headers .= "From: " . self::$senderEmailAddress . "\r\n";

        if(mail(self::$to, self::$subject, self::$message, self::$headers)) {
            return true;
        }else{
            return false;
        }

    }

}