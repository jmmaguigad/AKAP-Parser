<?php

// Note: some of the codes here where commented since i still need to solved issues pertaining to its database functionality
// To be Removed: chunking code


namespace AkapCsvProcessor;

class CsvProcessor
{
    private $inputFilePath;
    private $outputFilePath;
    private $database;
    private $chunkSize;

    public function __construct($inputFilePath, $outputFilePath, Database $database, $chunkSize = 1000)
    {
        $this->inputFilePath = $inputFilePath;
        $this->outputFilePath = $outputFilePath;
        // $this->database = $database;
        $this->chunkSize = $chunkSize;
    }

    private function normalizeHeader(array $header): array
    {
        return array_map('strtolower', $header);
    }

    public function process()
    {
        $inputFile = fopen($this->inputFilePath, 'r');
        $outputFile = fopen($this->outputFilePath, 'w');

        if (!$inputFile || !$outputFile) {
            die("Failed to open files.");
        }

        $header = fgetcsv($inputFile);
        $header = $this->normalizeHeader($header);

        $outputHeader = ['firstname', 'middlename', 'lastname', 'extensionname', 'birth_date', 'birth_year', 'birth_month', 'birth_day', 'sex', 'province'];

        // Remember this: Add UTF-8 BOM for correct character rendering
        fwrite($outputFile, "\xEF\xBB\xBF");

        fputcsv($outputFile, $outputHeader);

        $originalId = 0;
        $outputRowNumber = 1; //Initialize output row number
        $chunk = [];

        while (($row = fgetcsv($inputFile)) !== false) {
            $originalId++;
            $row = array_combine(array_slice($header, 0, count($row)), $row);

            $cleanedRow = Cleanse::cleanRow($row);

            if ($cleanedRow) {
                $sanitizeddate = Helpers::explodeDate($cleanedRow['birth_date']);

                $birthYear = $sanitizeddate[2];
                $birthMonth = $sanitizeddate[0];
                $birthDay = $sanitizeddate[1];

                $cleanedRow['birth_year'] = Helpers::yearChecker($birthYear);
                $cleanedRow['birth_month'] = $birthMonth;
                $cleanedRow['birth_day'] = $birthDay;
                $cleanedRow['birth_date'] = Helpers::concatDate([$birthMonth,$birthDay,$birthYear]);


                // Create a new array with only the desired fields
                $outputRow = []; // Add row number
                foreach ($outputHeader as $field) {
                    $outputRow[$field] = $cleanedRow[$field] ?? null; // Use null if field is missing
                }

                fputcsv($outputFile, $outputRow);

                $outputRowNumber++; // Increment row number
            }
        }

        fclose($inputFile);
        fclose($outputFile);
    }
}
