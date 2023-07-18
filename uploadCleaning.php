<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
    $file = $_FILES['pdfFile'];

    // Check for errors during file upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo 'Error uploading the file.';
        exit;
    }

    // Set the target directory where you want to save the uploaded file
    $targetDirectory = 'docs/calendarAdmin/';
    
    // The name of the file should be "Check_in.pdf"
    $targetFileName = $targetDirectory . 'Cleaning.pdf';

    // Move the temporary uploaded file to the target directory and replace the existing file if it exists
    if (!move_uploaded_file($file['tmp_name'], $targetFileName)) {
        echo 'Error moving the uploaded file.';
        exit;
    }

    // Return the URL of the newly uploaded PDF to the client
    echo $targetFileName;
} else {
    echo 'Invalid request.';
}
?>
