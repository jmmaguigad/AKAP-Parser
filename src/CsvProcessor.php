<?php

// Note: some of the codes here where commented since i still need to solved issues pertaining to its database functionality

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

        // Define the desired output header
        // $outputHeader = ['no','firstname', 'middlename', 'lastname', 'extensionname', 'birth_date', 'birth_year', 'birth_month', 'birth_day', 'sex', 'province'];
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
                $sanitizeddate = explode("/", $cleanedRow['birth_date']);

                $birthYear = $sanitizeddate[2];
                $birthMonth = $sanitizeddate[0];
                $birthDay = $sanitizeddate[1];
                // $birthYear = $cleanedRow['birth_date'] ? $cleanedRow['birth_date']->format('Y') : null;$sanitizeddate[2]
                // $birthMonth = $cleanedRow['birth_date'] ? $cleanedRow['birth_date']->format('m') : null;
                // $birthDay = $cleanedRow['birth_date'] ? $cleanedRow['birth_date']->format('d') : null;
                $cleanedRow['birth_year'] = $birthYear;
                $cleanedRow['birth_month'] = $birthMonth;
                $cleanedRow['birth_day'] = $birthDay;
                $cleanedRow['birth_date'] = $birthMonth.'/'.$birthDay.'/'.$birthYear;
                // $cleanedRow['birth_date'] = $cleanedRow['birth_date'] ? $cleanedRow['birth_date']->format('Y-m-d') : null;
                // $cleanedRow['birth_date'] = strtotime($cleanedRow['birth_date']);
                // $timestamp = strtotime($cleanedRow['birth_date']); // Convert to timestamp

                // if ($timestamp !== false) {
                //     $date = new \DateTime("@$timestamp"); // Convert timestamp to DateTime

                //     $cleanedRow['birth_date'] = $date->format('Y-m-d'); // Output: 2025-03-05
                // }

                // Create a new array with only the desired fields
                // $outputRow = ['no' => $outputRowNumber]; // Add row number
                $outputRow = []; // Add row number
                foreach ($outputHeader as $field) {
                    $outputRow[$field] = $cleanedRow[$field] ?? null; // Use null if field is missing
                    // echo $outputRow[$field].'-';
                }

                fputcsv($outputFile, $outputRow);
                $chunk[] = $cleanedRow;

                if (count($chunk) >= $this->chunkSize) {
                    // $this->processChunk($chunk, $originalId - count($chunk) + 1);
                    $chunk = [];
                }

                $outputRowNumber++; // Increment row number
            }
        }

        // if (!empty($chunk)) {
        //     $this->processChunk($chunk, $originalId - count($chunk) + 1);
        // }

        fclose($inputFile);
        fclose($outputFile);
    }

    // private function processChunk(array $chunk, $startingOriginalId)
    // {
    //     foreach ($chunk as $index => $row) {
    //         $this->database->insertData($row, $startingOriginalId + $index);
    //     }
    // }
}
