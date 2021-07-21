<?php

use Illuminate\Support\Facades\Route;
/**
 *
 * Set active css class if the specific URI is current URI
 *
 * @param string $path       A specific URI
 * @param string $class_name Css class name, optional
 * @return string            Css class name if it's current URI,
 *                           otherwise - empty string
 */

    function setActive(string $path) : string
    {
        // return request()->path() === $path ? $class_name : "";
        //    return (strpos(Route::currentRouteName(), $path) == 0) ? 'active' : '';
        if ($path == Route::currentRouteName()) {
            return 'active';
        }
    }
    // Currency Conversion Helper
    function currency($amount) : string
    {
        return '₦'.number_format($amount,2);
    }
    // Long Random String Generator Helper
    function generate_string($input, $strength = 16) : string
    {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
    // Long Secure Random String Generator
    function secure_random_string($length) : string
    {
        $random_string = '';
        for($i = 0; $i < $length; $i++) {
            $number = random_int(0, 36);
            $character = base_convert($number, 10, 36);
            $random_string .= $character;
        }

        return $random_string;
    }



