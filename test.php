<?php
    ini_set('display_errors', 'off');
    session_start();
    $pdo = new PDO('mysql:dbname=edouardburel_charleshome;host=mysql-edouardburel.alwaysdata.net', '302132_chome', 'Charleshome1');
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(!isset($_SESSION['admin_id'])) {
        header('location: login.php');
    }

    require_once('lib/CheckinTable.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Espace admin - Charles Home</title>
</head>
<body>

<table class="table table-striped" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th colspan="2" style="text-align: center; border-right: 2px solid black;">Check-in</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td scope="row" colspan="2" style="color: green; font-size: 30px; text-align: center; background-color: #F5F5F5; border-right: 2px solid black;"><?php echo $checkInCount; ?></td>
        </tr>
    </tbody>
    <thead>
        <tr>
            <th style="text-align: center;">Date</th>
            <th style="text-align: center;border-right: 2px solid black;">Apt</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($checkInRows as $row): ?>
        <tr>
            <td style="text-align: center;"><?php echo date('l jS F', strtotime($row['StartDate'])); ?></td>
            <td style="text-align: center; border-right: 2px solid black;">
            <?php
                $apartmentId = $row['ApartmentID'];
                $query = "SELECT ApartmentName FROM Apartment WHERE ApartmentID = ?";
                $statement = $pdo->prepare($query);
                $statement->execute([$apartmentId]);
                $apartmentResult = $statement->fetch(PDO::FETCH_ASSOC);

                if ($apartmentResult) {
                    echo $apartmentResult['ApartmentName'];
                }
            ?>
            </td>
        <?php endforeach; ?>
        </tr>
    </tbody>
</table>

<table class="table table-striped" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th colspan="2" style="text-align: center; border-right: 2px solid black;">Check-out</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td scope="row" colspan="2" style="color: red; font-size: 30px; text-align: center; background-color: #F5F5F5; border-right: 2px solid black;"><?php echo $checkOutCount; ?></td>
        </tr>
    </tbody>
    <thead>
        <tr>
            <th style="text-align: center;">Date</th>
            <th style="text-align: center;border-right: 2px solid black;">Apt</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($checkOutRows as $checkoutRow): ?>
        <tr>
            <td style="text-align: center;"><?php echo date('l jS F', strtotime($checkoutRow['EndDate'])); ?></td>
            <td style="text-align: center; border-right: 2px solid black;">
            <?php
                $apartmentId = $row['ApartmentID'];
                $query = "SELECT ApartmentName FROM Apartment WHERE ApartmentID = ?";
                $statement = $pdo->prepare($query);
                $statement->execute([$apartmentId]);
                $apartmentResult = $statement->fetch(PDO::FETCH_ASSOC);

                if ($apartmentResult) {
                    echo $apartmentResult['ApartmentName'];
                }
            ?>
            </td>
        <?php endforeach; ?>
        </tr>
    </tbody>
</table>

<script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>