<?php

$pdo = new PDO('mysql:dbname=edouardburel_charleshome;host=mysql-edouardburel.alwaysdata.net', '302132_chome', 'Charleshome1');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['saveInvoice'])) {
    $filename = $_FILES['myfile']['name'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $invoiceNumber = $_POST['invoiceNumber'];
    $monthYear = $_POST['monthYear'];


    $destination = 'uploads/invoices/' . $filename;
    $extension = pathinfo($filename,PATHINFO_EXTENSION);
    $file = $_FILES['myfile']['tmp_name'];

    if(!in_array($extension,['pdf','zip','xlsx'])){
        echo "File not accepted";
    } else {
        if(move_uploaded_file($file,$destination)) {
            $sql = "INSERT INTO MonthlyInvoice (TenantID, InvoiceNumber, Month, Year) VALUES (:tenantID, :invoiceNumber, :month, :year)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':tenantID', $_POST['tenant']);
            $stmt->bindValue(':invoiceNumber', $invoiceNumber);
            $stmt->bindValue(':month', date('m', strtotime($monthYear)));
            $stmt->bindValue(':year', date('Y', strtotime($monthYear)));
            
            if ($pdo->query($sql)) {
                echo "file uploaded successully";
            } else {
                echo "failed to upload the file";
            }
        }
    }
}

?>