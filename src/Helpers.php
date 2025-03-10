<?php

/**
 * Class Helpers
 *
 * This class is responsible for handling the common helper functions used in the project
 */

namespace AkapCsvProcessor;

class Helpers
{
    /**
     * Cleans a given string by:
     * - Removing all characters except letters (including Ññ), spaces, and hyphens.
     * - Replacing multiple spaces with a single space.
     * - Converting the string to uppercase.
     *
     * @param string $string The input string to be cleaned.
     * @return string The sanitized and uppercase string.
     */
    public static function cleanString($string)
    {
        // Remove all characters except letters, spaces, and hyphens
        $string = preg_replace('/[^a-zA-ZÑñ\s\-]/u', '', $string);

        // Replace multiple spaces with a single space
        $string = preg_replace('/\s+/', ' ', $string);

        // Convert to uppercase and trim spaces
        return trim(strtoupper($string));
    }

    /**
     * Cleans and standardizes birthdate formats by:
     * - Removing unwanted special characters.
     * - Converting month names to numeric format.
     * - Formatting the date as mm/dd/yyyy.
     *
     * @param string $birthdate The raw birthdate string.
     * @return string The formatted birthdate (mm/dd/yyyy) or "Invalid Date Format".
     */
    public static function cleanBirthdate($birthdate)
    {
        // Define unwanted special characters (excluding slashes)
        $specialchar = ["-", "`", "'", "*", ","];
        $datespecialchar = ["-"];

        // Remove special characters
        $cleanedDate = str_replace($specialchar, "", trim($birthdate));

        // Convert multiple spaces to a single space
        $cleanedDate = preg_replace('/\s+/', ' ', $cleanedDate);

        // Convert multiple slashes to a single slash
        $cleanedDate = preg_replace('#/+#', '/', $cleanedDate);

        // Replace dashes with slashes to standardize date format
        $cleanedDate = str_replace($datespecialchar, "/", trim($birthdate));

        // Map month names and abbreviations to their numeric equivalents
        $months = [
            'JAN' => '01', 'FEB' => '02', 'MAR' => '03', 'APR' => '04', 'MAY' => '05',
            'JUN' => '06', 'JUL' => '07', 'AUG' => '08', 'SEPT' => '09', 'OCT' => '10',
            'NOV' => '11', 'DEC' => '12', 'JANUARY' => '01', 'FEBRUARY' => '02', 
            'MARCH' => '03', 'APRIL' => '04', 'JUNE' => '06', 'JULY' => '07',
            'AUGUST' => '08', 'SEPTEMBER' => '09', 'OCTOBER' => '10', 'NOVEMBER' => '11',
            'DECEMBER' => '12'
        ];

        // Replace month names with numeric values if found
        foreach ($months as $key => $value) {
            if (stripos($cleanedDate, $key) !== false) {
                $cleanedDate = str_ireplace($key, $value, $cleanedDate);
                break; // Stop after the first match
            }
        }

        // Convert the cleaned date into a valid timestamp
        $timestamp = strtotime($cleanedDate);

        // Debugging function (disabled)
        // self::dumpAndDie($birthdate.' - '.$cleanedDate.' - '.$timestamp);

        // Validate and return the formatted date or an error message
        if ($timestamp !== false) {
            return date('m/d/Y', $timestamp);
        }

        return "Invalid";
    }

    /**
     * Debugging function to print formatted values and halt execution.
     *
     * @param mixed $format The data to be dumped.
     */
    public static function dumpAndDie($format)
    {
        echo '<pre>birthdate - cleaneddate - timestamp</pre>';
        echo '<pre>';
        var_dump($format);
        echo '</pre>';
        die(); // Stop script execution
    }

    /**
     * Splits a date string into an array of month, day, and year.
     *
     * @param string $date The date in mm/dd/yyyy format.
     * @return array The exploded date elements [month, day, year].
     */
    public static function explodeDate($date)
    {
        return explode("/", $date);
    }

    /**
     * Combines an array of date elements into a single date string.
     *
     * @param array $elements The array containing [month, day, year].
     * @return string The concatenated date in mm/dd/yyyy format.
     */
    public static function concatDate($elements)
    {
        return implode("/", $elements);
    }
}
