<?php
error_reporting(0);
// TODO: Need to remove any database function, the application needs to work as standalone only
require_once __DIR__ . '/src/Autoloader.php';

use AkapCsvProcessor\CsvProcessor;
use AkapCsvProcessor\Database;

set_time_limit(0);

$inputFilePath = __DIR__ . '/data/input.csv';
$outputFilePath = __DIR__ . '/output/output.csv';

if (isset($_POST['submit']) && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $file['tmp_name'];
        $inputFilePath = __DIR__ . '/data/input.csv';
        $outputFilePath = __DIR__ . '/output/output.csv';

        // Move the uploaded file to input.csv
        if (move_uploaded_file($tempFilePath, $inputFilePath)) {

            set_time_limit(0);

            $database = new Database();
            $processor = new CsvProcessor($inputFilePath, $outputFilePath, $database, 1000); // 1000 is the chunk size.
            $processor->process();

            // Download the output.csv
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="output.csv"');
            header('Content-Length: ' . filesize($outputFilePath));

            readfile($outputFilePath);

            //Remove temp files: delete input.csv and output.csv after download.
            unlink($inputFilePath);
            unlink($outputFilePath);

            exit; // Stop further execution
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "Upload error: " . $file['error'];
    }
} else {
    echo "No file uploaded.";
}
?>