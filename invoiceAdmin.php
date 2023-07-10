<?php
ini_set('display_errors', 'off');
session_start();
$pdo = new PDO('mysql:dbname=edouardburel_charleshome;host=mysql-edouardburel.alwaysdata.net', '302132_chome', 'Charleshome1');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
$messages = [];

$stmt = $pdo->query("SELECT * FROM MonthlyInvoice");
$invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apartment Management</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-img">
                <img src="image/logo-key.png" alt="Charles Home">
            </div>

            <span class="logo_name">Charles Home</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li>
                    <a href="admin.php">
                        <i class="fa fa-home"></i>
                        <span class="link-name">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="tenants.php">
                        <i class="fa fa-user"></i>
                        <span class="link-name">Tenants</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa-solid fa-file-invoice"></i>
                        <span class="link-name">Invoice</span>
                    </a>
                </li>
            </ul>

            <ul class="logout-mode">
                <li>
                    <a href="#">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="link-name">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
  <div class="container mt-5">
    <h1>Invoices</h1>
    <button class="btn btn-primary mb-3 mt-5" data-toggle="modal" data-target="#addInvoiceModal">Add an invoice</button>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Month</th>
          <th>Number</th>
          <th>Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($invoices as $invoice): ?>
        <!-- Table rows will be dynamically populated from the database -->
        <tr>
          <td><?php echo $invoice['Month'].' '.$invoice['Year'];?></td>
          <td><?= $invoice['InvoiceNumber']; ?></td>
          <td><?= $invoice['FileInvoice']; ?></td>
          <td>
            <form action="lib/code.php" method="POST" class="d-inline">
                <button type="submit" name="delete_invoice" value="<?=$invoice['TenantID']; ?>" class="btn-delete btn btn-danger">Supprimer</a>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Add Tenant Modal -->
  <div class="modal fade" id="addInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="addInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addInvoiceModalLabel">Add an invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Invoice form fields -->
          <form class="formUpload" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="numberInput">Invoice Number</label>
                <input type="text" class="form-control" id="numberInput" name="invoiceNumber" placeholder="Number">
            </div>

            <div class="form-group">
              <label for="apartmentInput">Tenant</label>
              <select class="form-control" name="tenant">
                <?php
                $stmt = $pdo->query("SELECT TenantID, FirstName, LastName FROM Tenant");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $tenantID = $row['TenantID'];
                    $tenantName = $row['FirstName'] . ' ' . $row['LastName'];
                    ?>
                    <option value="<?= $tenantID; ?>"><?= $tenantName; ?></option>
                    <?php
                }
                ?>
            </select>
            </div>

            <div class="form-group">
                <label for="numberInput">Month</label>
                <input type="month" class="form-control" name="monthYear" placeholder="Month">
            </div>

            <div class="form-group">
              <label for="endLeaseInput">File</label>
              <input type="file" class="form-control" name="myfile" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="saveInvoice">Save Invoice</button>
            </div>
          </form>
        </div>
        <?php
        if(isset($_POST['saveInvoice'])) {
          $filename = $_FILES['myfile']['name'];
          $tenantID = $_POST['tenant'];
          $invoiceNumber = $_POST['invoiceNumber'];
          $monthYear = $_POST['monthYear'];


          $destination = 'uploads/invoices/' . $filename;
          $extension = pathinfo($filename,PATHINFO_EXTENSION);
          $file = $_FILES['myfile']['tmp_name'];

            if(!in_array($extension,['pdf','zip','xlsx'])){
                echo "File not accepted";
            } else {
                if(move_uploaded_file($file,$destination)) {
                    $sql = "INSERT INTO MonthlyInvoice (TenantID, InvoiceNumber, Month, Year, FileInvoice) VALUES (:tenantID, :invoiceNumber, :month, :year, :filename)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':tenantID', $tenantID);
                    $stmt->bindValue(':invoiceNumber', $invoiceNumber);
                    $stmt->bindValue(':month', intval(date('m', strtotime($monthYear))));
                    $stmt->bindValue(':year', intval(date('Y', strtotime($monthYear))));
                    $stmt->bindValue(':filename', $filename);
                    
                    if ($stmt->execute()) {
                      echo "File uploaded successfully";
                  } else {
                      echo "Failed to upload the file";
                  }
                }
            }
        }?>
      </div>
    </div>
  </div>

  <!-- jQuery and Bootstrap JS -->

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
