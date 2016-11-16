<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('number_format_clean')) {
    function number_format_clean($number, $precision = 0, $dec_point = '.', $thousands_sep = ',')
    {
        $element = number_format($number, $precision, $dec_point, $thousands_sep);
        $elements = explode($dec_point, $element);
        $decimals = str_split($elements[1]);
        foreach ($decimals as $digit) {
            if ($digit != 0) {
                return $element;
            }
        }
        return $elements[0];
    }
}

if (!function_exists('in_array_field')) {
    function in_array_field($needle, $needle_field, $haystack, $strict = false)
    {
        if ($strict) {
            foreach ($haystack as $key => $item) {
                if (isset($item->$needle_field) && $item->$needle_field === $needle) {
                    return $key;
                }
            }
        } else {
            foreach ($haystack as $key => $item) {
                if (isset($item->$needle_field) && $item->$needle_field == $needle) {
                    return $key;
                }
            }
        }
        return false;
    }
}
?>