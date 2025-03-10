<?php

/**
 * Class Cleanse
 *
 * This class is responsible for processing the excel files that are 
 * UTF-8 CSV data.
 */

namespace AkapCsvProcessor;

class CsvProcessor
{
    /**
     * @var string $inputFilePath Path to the input CSV file.
     * @var string $outputFilePath Path to the output CSV file.
     */
    private $inputFilePath;
    private $outputFilePath;

    /**
     * Constructor method to initialize file paths.
     *
     * @param string $inputFilePath  Path of the input CSV file.
     * @param string $outputFilePath Path of the output CSV file.
     */
    public function __construct($inputFilePath, $outputFilePath)
    {
        $this->inputFilePath = $inputFilePath;
        $this->outputFilePath = $outputFilePath;
    }

    /**
     * Normalizes CSV headers by converting all column names to lowercase.
     *
     * @param array $header The original header row from the CSV file.
     * @return array The normalized header row with all lowercase column names.
     */
    private function normalizeHeader(array $header): array
    {
        return array_map('strtolower', $header);
    }

    /**
     * Processes the input CSV file by:
     * - Reading the input file.
     * - Cleaning and formatting data.
     * - Writing the processed data to the output file.
     *
     * @return void
     */
    public function process()
    {
        // Open input and output CSV files for reading and writing
        $inputFile = fopen($this->inputFilePath, 'r');
        $outputFile = fopen($this->outputFilePath, 'w');

        if (!$inputFile || !$outputFile) {
            die("Failed to open files.");
        }

        $header = fgetcsv($inputFile);
        $header = $this->normalizeHeader($header);

        // Define the output file headers
        $outputHeader = ['firstname', 'middlename', 'lastname', 'extensionname', 'birth_date', 'birth_year', 'birth_month', 'birth_day', 'sex', 'province'];

        // Remember: Add UTF-8 BOM to the output file to ensure correct character rendering
        // (This helps prevent encoding issues when opening the file in Excel)
        fwrite($outputFile, "\xEF\xBB\xBF");

        fputcsv($outputFile, $outputHeader);

        while (($row = fgetcsv($inputFile)) !== false) {
            $row = array_combine(array_slice($header, 0, count($row)), $row);

            $cleanedRow = Cleanse::cleanRow($row);

            if ($cleanedRow) {
                // Extract birth date components (year, month, day)
                $extractedbdatecomponents = Helpers::explodeDate($cleanedRow['birth_date']);

                $birthYear = $extractedbdatecomponents[2] ?? 'Invalid';
                $birthMonth = $extractedbdatecomponents[0] ?? 'Invalid';
                $birthDay = $extractedbdatecomponents[1] ?? 'Invalid';

                // Validate and assign birth date components
                $cleanedRow['birth_year'] = $birthYear;
                $cleanedRow['birth_month'] = $birthMonth;
                $cleanedRow['birth_day'] = $birthDay;

                // Reconstruct the birth date in a standardized format
                $cleanedRow['birth_date'] = Helpers::concatDate([$birthMonth, $birthDay, $birthYear]);


                // Create a new array with only the desired fields
                $outputRow = [];
                foreach ($outputHeader as $field) {
                    $outputRow[$field] = $cleanedRow[$field] ?? null; // Use null if field is missing
                }

                fputcsv($outputFile, $outputRow);
            }
        }

        // Close the files
        fclose($inputFile);
        fclose($outputFile);
    }
}
