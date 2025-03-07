<?php

namespace AkapCsvProcessor;

class Helpers
{
    public static function cleanString($string)
    {
        // Remove all characters except letters (including Ññ), spaces, and hyphens
        $string = preg_replace('/[^a-zA-ZÑñ\s\-]/u', '', $string);

        // Replace multiple spaces with a single space (optional)
        $string = preg_replace('/\s+/', ' ', $string);
        return trim(strtoupper($string));
    }

    public static function cleanBirthdate($birthdate)
    {
        // Remove unwanted special characters (except slashes)
        $specialchar = ["-", "`", "'", "*", ","];
        $datespecialchar = ["-"];
        $cleanedDate = str_replace($specialchar, "", trim($birthdate));

        // Convert multiple spaces to a single space
        $cleanedDate = preg_replace('/\s+/', ' ', $cleanedDate);

        // Convert multiple slashes to a single slash
        $cleanedDate = preg_replace('#/+#', '/', $cleanedDate);

        // Additional catch for extra dashes just in case it has
        $cleanedDate = str_replace($datespecialchar, "/", trim($birthdate));

        // Convert month names to numeric format
        $months = [
            'JAN' => '01',
            'FEB' => '02',
            'MAR' => '03',
            'APR' => '04',
            'MAY' => '05',
            'JUN' => '06',
            'JUL' => '07',
            'AUG' => '08',
            'SEPT' => '09',
            'OCT' => '10',
            'NOV' => '11',
            'DEC' => '12',
            'JANUARY' => '01',
            'FEBRUARY' => '02',
            'MARCH' => '03',
            'APRIL' => '04',
            'JUNE' => '06',
            'JULY' => '07',
            'AUGUST' => '08',
            'SEPTEMBER' => '09',
            'OCTOBER' => '10',
            'NOVEMBER' => '11',
            'DECEMBER' => '12'
        ];

        // Convert month abbreviations if present
        foreach ($months as $key => $value) {
            if (stripos($cleanedDate, $key) !== false) {
                $cleanedDate = str_ireplace($key, $value, $cleanedDate);
                break;
            }
        }

        $timestamp = strtotime($cleanedDate);

        // self::dumpAndDie($birthdate.' - '.$cleanedDate.' - '.$timestamp);

        if ($timestamp !== false) {
            return date('m/d/Y', $timestamp);
        }

        return "Invalid Date Format";
    }

    public static function dumpAndDie($format)
    {
        echo '<pre>birthdate - cleaneddate - timestamp</pre>';
        echo '<pre>';
        var_dump($format);
        echo '</pre>';
    }

    public static function explodeDate($date)
    {
        return explode("/", $date);
    }

    public static function concatDate($elements)
    {
        return implode("/",$elements);
    }

    public static function yearChecker($year)
    {
        if (strlen($year) > 4 || ($year < 1000)) {
            return "Invalid Year";
        }

        return trim($year); 
    }
}
