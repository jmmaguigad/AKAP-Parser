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

    //TODO: Need to add checking for 2 digit year before checking month and day that were switched
    // public static function cleanBirthdate($birthdate)
    // {
    //     $date = \DateTime::createFromFormat('m/d/Y', $birthdate);
    //     $returndate = '';

    //     if (!$date) {
    //         // $specialchar = ["-", "`", "'", "*"]; // Remove spaces from this array

    //         // // Step 1: Replace unwanted characters with an empty string
    //         // $datedd = str_replace($specialchar, "", trim($birthdate));

    //         // // Step 2: Ensure a space after the comma (correct "OCTOBER 03,1973" → "OCTOBER 03, 1973")
    //         // $datedd = preg_replace('/,\s*/', ', ', $datedd);

    //         // $datedd = preg_replace('#/+#', '/', $datedd);

    //         // // Step 3: Replace multiple spaces with a single space
    //         // $datedd = preg_replace('/\s+/', ' ', $datedd);

    //         $specialchar = [" ", "-", "`", "'", "*", ","];
    //         $datedd = preg_replace('#/+#', '/', str_replace($specialchar, "/", trim($birthdate)));
    //         $datedd = preg_replace('/,\s*/', ', ', trim($datedd));
    //         // $datedd = preg_replace('/[*,.]/', '', trim($datedd));
    //         $datedd = preg_replace('/\s+/', ' ', trim($datedd));

    //         $year = '';
    //         $month = '';
    //         $day  = '';
    //         // $year = '';

    //         // Define month mappings
    //         $months = [
    //             'JAN' => '01',
    //             'FEB' => '02',
    //             'MAR' => '03',
    //             'APR' => '04',
    //             'MAY' => '05',
    //             'JUN' => '06',
    //             'JUL' => '07',
    //             'AUG' => '08',
    //             'SEPT' => '09',
    //             'OCT' => '10',
    //             'NOV' => '11',
    //             'DEC' => '12',
    //             'JANUARY' => '01',
    //             'FEBRUARY' => '02',
    //             'MARCH' => '03',
    //             'APRIL' => '04',
    //             'JUNE' => '06',
    //             'JULY' => '07',
    //             'AUGUST' => '08',
    //             'SEPTEMBER' => '09',
    //             'OCTOBER' => '10',
    //             'NOVEMBER' => '11',
    //             'DECEMBER' => '12'
    //         ];

    //         // Split date into parts
    //         $parts = array_values(array_filter(explode('/', $datedd)));

    //         // echo "<pre>";
    //         // var_dump($parts);
    //         // echo "</pre>";
    //         // exit();

    //         if (count($parts) === 3) {
    //             // Convert all parts to uppercase for consistency
    //             $parts = array_map('strtoupper', $parts);

    //             // Identify which part is the month
    //             if (isset($months[$parts[1]])) { // Format: DD/MM/YYYY
    //                 $day = $parts[0];
    //                 $month = $months[$parts[1]];
    //                 $year = $parts[2];
    //             } elseif (isset($months[$parts[0]])) { // Format: MM/DD/YYYY
    //                 $day = $parts[1];
    //                 $month = $months[$parts[0]];
    //                 $year = $parts[2];
    //             } else {
    //                 $returndate = "Invalid Date Format";
    //             }

    //             // Ensure year is 4-digit
    //             $year = strlen($year) == 2 ? '19' . $year : $year;

    //             // Ensure two-digit formatting for month and day using str_pad()
    //             $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    //             $day = str_pad($day, 2, '0', STR_PAD_LEFT);

    //             // Concatenate the formatted date
    //             $returndate = $month . '/' . $day . '/' . $year;
    //         }
    //     } else {
    //         $dated = trim($birthdate);

    //         $arrMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    //         $flag = 0;
    //         foreach ($arrMonths as $month) {
    //             if (stristr($dated, $month) !== false) {
    //                 $flag = 1;
    //                 break;
    //             }
    //         }
    //         if ($flag == 1) {
    //             $date = date("m/d/Y", strtotime($dated));
    //         }
    //         $specialchar = [" ", "-", "`", "'", "*"];
    //         $date = preg_replace('#/+#', '/', str_replace($specialchar, "/", trim($dated)));
    //         $sanitizeddate = explode("/", $date);

    //         if (strlen($sanitizeddate[2]) == 2) {
    //             $year = '20' . $sanitizeddate[2];
    //             if ($sanitizeddate[0] > 12) {
    //                 $month = $sanitizeddate[1];
    //                 $day = $sanitizeddate[0];
    //             } else {
    //                 $month = $sanitizeddate[0];
    //                 $day = $sanitizeddate[1];
    //             }
    //             if ($year > date('Y')) {
    //                 $year = $year - 100;
    //             }
    //             $returndate = $month . "/" . $day . "/" . $year;
    //         } else if (strlen($sanitizeddate[2]) == 4) {
    //             if ($sanitizeddate[0] > 12) {
    //                 $returndate = $sanitizeddate[1] . "/" . $sanitizeddate[0] . "/" . $sanitizeddate[2];
    //             } else {
    //                 $returndate = $date;
    //             }
    //         } else {
    //             $returndate = "";
    //         }
    //     }

    //     return $returndate;
    // }

    public static function cleanBirthdate($birthdate)
    {
        // Try to create a DateTime object with format m/d/Y
        // $date = \DateTime::createFromFormat('m/d/Y', trim($birthdate));

        // if ($date) {
        //     return $date->format('m/d/Y'); // Return in correct format
        // }

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

        // echo '<pre>birthdate - cleaneddate - timestamp</pre>';
        // echo '<pre>';
        // var_dump($birthdate.' - '.$cleanedDate.' - '.$timestamp);
        // echo '</pre>';

        if ($timestamp !== false) {
            return date('m/d/Y', $timestamp);
        }

        return "Invalid Date Format";
    }
}
