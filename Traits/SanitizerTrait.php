<?php

namespace Traits;

trait SanitizerTrait {

    public static function sanitizeInput($input) {
        if(is_array($input)) {
            return array_map([self::class, 'sanitizeValue'], $input);
        }else {
            return self::sanitizeValue($input);
        }
    }

    public static function sanitizeValue($value) {

        $sanitizedValue = trim($value);
        $sanitizedValue = filter_var($sanitizedValue, FILTER_SANITIZE_STRING);
        $sanitizedValue = htmlspecialchars($sanitizedValue, ENT_QUOTES, 'UTF-8');

        return $sanitizedValue;

    }

}