<?php

// Include the autoloader to load classes automatically
require_once __DIR__ . '/src/Autoloader.php';

use AkapCsvProcessor\CsvProcessor;

// Define file paths for input and output CSV files
$inputFilePath = __DIR__ . '/data/input.csv';
$outputFilePath = __DIR__ . '/output/output.csv';

// Check if the form was submitted and a file was uploaded
if (isset($_POST['submit']) && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']; // Get uploaded file details

    // Check if the file was uploaded without errors
    if ($file['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $file['tmp_name']; // Temporary file path

        // Define file paths for processing
        $inputFilePath = __DIR__ . '/data/input.csv';
        $outputFilePath = __DIR__ . '/output/output.csv';

        // Move the uploaded file to the input directory
        if (move_uploaded_file($tempFilePath, $inputFilePath)) {

            // Remove time limit again (important for long-running processes)
            set_time_limit(0);

            // Instantiate the CSV processor with input and output file paths
            $processor = new CsvProcessor($inputFilePath, $outputFilePath);
            $processor->process(); // Process the CSV file

            // Prepare file for download
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="output.csv"');
            header('Content-Length: ' . filesize($outputFilePath));

            // Output the processed CSV file to the browser for download
            readfile($outputFilePath);

            // Remove temporary files after download
            unlink($inputFilePath); // Delete input file
            unlink($outputFilePath); // Delete output file

            exit; // Stop script execution after file download
        } else {
            echo "Failed to move uploaded file."; // Error if file move fails
        }
    } else {
        echo "Upload error: " . $file['error']; // Show error message for upload issues
    }
} else {
    echo "No file uploaded."; // Display message if no file was uploaded
}

?>
