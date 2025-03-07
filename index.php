<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AKAP CSV PARSER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        h1 {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <h1>Upload AKAP Related CSV File</h1>
    <form action="process.php" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" id="csv_file">
        <input type="submit" value="Upload and Process" name="submit">
    </form>
</body>

</html>

<?php
// $elements = ['test','test'];
// foreach ($elements as $e) {
//     echo $e;
// }
?>