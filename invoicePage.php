<?php
    ini_set('display_errors', 'off');
    session_start();
    $pdo = new PDO('mysql:dbname=edouardburel_charleshome;host=mysql-edouardburel.alwaysdata.net', '302132_chome', 'Charleshome1');
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(!isset($_SESSION['user_id'])) {
        header('location: login.php');
    }

    $id = (int)$_SESSION['user_id'];
    $query = "SELECT * FROM Tenant WHERE TenantID = ?";
    $res = $pdo->prepare($query);
    $res->execute([$id]);

    $user = $res->fetch(PDO::FETCH_ASSOC);

    $userID = (int)$user['TenantID'];

    $sql = "SELECT MonthlyInvoice.* FROM MonthlyInvoice
        WHERE MonthlyInvoice.TenantID = '$userID'";
    
    $res = $pdo->query($sql);
    $files = $res->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rental Invoices</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/override-bootstrap.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">


</head>
<body class="bg-white">
    <?php require_once ('templates/header.php'); ?>

    <div class="container mt-5">
        <div class="header d-flex justify-content-between align-items-center">
            <h1>Invoices</h1>
            <a href="index.php" class="btn btn-primary btn-sm" style="padding: 5px 10px;">Return</a>
        </div>
        <div class="row">
            <table class=" bg-white table table-bordered mt-5">
                <thead>
                    <th>Month</th>
                    <th>File Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach($files as $file): ?>
                        <tr>
                            <td><?php echo date('F', mktime(0, 0, 0, $file['Month'], 1)).' '.$file['Year'];?></td>
                            <td><?php echo $file['FileInvoice'];?></td>
                            <td>
                                <a href="download.php?file_id=<?php echo $file['TenantID']; ?>">Download</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

  <script src="script.js"></script> 
  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>