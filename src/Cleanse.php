<?php

/**
 * Class Cleanse
 *
 * This class is responsible for cleansing and sanitizing individual rows of CSV data
 * before processing. It ensures that all necessary fields are formatted correctly and
 * unnecessary data is removed.
 */

namespace AkapCsvProcessor;

class Cleanse
{
    /**
     * Cleanses a single row of CSV data.
     *
     * This method performs the following cleansing operations:
     * - Removes blank rows.
     * - Checks if the first name field is valid before proceeding.
     * - Sanitizes all fields to remove unwanted characters.
     * - Ensures proper birthdate formatting.
     * - Standardizes the 'sex' field to a single character (M/F).
     *
     * @param array $row The raw row data from the CSV file.
     * @return array|null The cleansed row or null if the row is invalid.
     */
    public static function cleanRow(array $row)
    {
        // Remove any blank rows (rows with no data)
        if (count(array_filter($row)) === 0) {
            return null;
        }

        // Validate the first name field before processing.
        // If it's not a proper name (e.g., a header row), return null to skip processing.
        $row['firstname'] = Helpers::cleanString($row['first name']);

        if ($row['firstname'] == 'FIRST NAME') {
            return null;
        }

        // Sanitize all the required fields before further processing
        $row['middlename'] = Helpers::cleanString($row['middle name']);
        $row['lastname'] = Helpers::cleanString($row['last name']);
        $row['extensionname'] = Helpers::cleanString($row['extension name (jr,sr)']);
        $row['province'] = Helpers::cleanString($row['province']);

        // Clean and standardize the 'birthdate' field
        $row['birth_date'] = Helpers::cleanBirthdate($row['birthdate (mm/dd/yyyy)']);
        
        // Clean and standardize the 'sex' field.
        // Ensures only the first character is used (e.g., 'Male' → 'M', 'Female' → 'F').
        $row['sex'] = Helpers::cleanString($row['sex']);
        $row['sex'] = strlen($row['sex']) > 1 ? $row['sex'][0] : $row['sex'];

        // Return the cleaned row for further processing
        return $row;
    }
}
