<?php
ini_set('display_errors', 'off');
session_start();
$pdo = new PDO('mysql:dbname=edouardburel_charleshome;host=mysql-edouardburel.alwaysdata.net', '302132_chome', 'Charleshome1');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
$messages = [];

$stmt = $pdo->query("SELECT * FROM Tenant");
$tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtLease= $pdo->query("SELECT * FROM RentalLease");
$leases = $stmtLease->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
  <div class="container d-flex flex-column flex-md-row">
    <nav class="navbar navbar-expand-md navbar-light d-flex flex-md-column">
        <div class="ms-md-auto">
            <img class="logo-name" src="image/logo-key.png" alt="Charles Home" width="60">
        </div>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle Navigation"
        >
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navContent collapse navbar-collapse w-100" id="navbarSupportedContent">
            <ul class="navbar-nav w-100 d-flex flex-md-column text-center text-md-end">
                <li>
                    <a href="#" class="nav-link" aria-current="page">
                    <i class="fa fa-home"></i>
                        Dashboard</a>
                </li>
                <li>
                    <a href="tenants.php" class="nav-link">
                    <i class="fa fa-user"></i>
                        Tenants</a>
                </li>
                <li>
                    <a href="invoiceAdmin.php" class="nav-link" style="margin-bottom: 9rem;">
                    <i class="fa-solid fa-file-invoice"></i>
                        Invoices</a>
                </li>

                <li>
                    <a href="logout.php" class="logout nav-link" style="border-top: 1px solid lightgray;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <main class="mainContent ps-0 ps-md-5 flex-grow-1">
      <div class="container mt-5">
      <h1>Apartment Management</h1>
      <button class="btn btn-primary mb-3 mt-5" data-toggle="modal" data-target="#addTenantModal">Add a tenant</button>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Apartment</th>
            <th>Name</th>
            <th>End Lease</th>
            <th>Rent</th>
            <th>Deposit</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tenants as $tenant): ?>
            <?php foreach ($leases as $lease): ?>
              <?php if ($tenant['TenantID'] === $lease['TenantID']): ?>
            <tr>
              <td>
                <?php
                $apartmentId = $tenant['ApartmentID'];
                $query = "SELECT ApartmentName FROM Apartment WHERE ApartmentID = ?";
                $statement = $pdo->prepare($query);
                $statement->execute([$apartmentId]);
                $apartmentResult = $statement->fetch(PDO::FETCH_ASSOC);

                if ($apartmentResult) {
                    echo $apartmentResult['ApartmentName'];
                }
                ?>
              </td>
          
              <td><?= $tenant['LastName']; ?> <?= $tenant['FirstName']; ?></td>
              <td><?= $lease['EndDate']; ?></td>
              <td><?= $lease['Rent']; ?>€</td>
              <td><?= $lease['Deposit'];?>€</td>
              <td>
                <a href="lib/code.php?CurrentTenantID=<?= $tenant['TenantID']; ?>" class="btn btn-info" data-toggle="modal" data-target="#editTenantModal">Update</a>
                <form action="lib/code.php" method="POST" class="d-inline">
                  <button type="submit" name="delete_tenant" value="<?=$tenant['TenantID']; ?>" class="btn-delete btn btn-danger">Supprimer</a>
                </form>
              </td>
            </tr>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
      </table>
    </div>
    </main>
  </div>

  <div class="container mt-5">
    <h1>Apartment Management</h1>
    <button class="btn btn-primary mb-3 mt-5" data-toggle="modal" data-target="#addTenantModal">Add a tenant</button>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Apartment</th>
          <th>Name</th>
          <th>End Lease</th>
          <th>Rent</th>
          <th>Deposit</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tenants as $tenant): ?>
          <?php foreach ($leases as $lease): ?>
            <?php if ($tenant['TenantID'] === $lease['TenantID']): ?>
          <tr>
            <td>
              <?php
              $apartmentId = $tenant['ApartmentID'];
              $query = "SELECT ApartmentName FROM Apartment WHERE ApartmentID = ?";
              $statement = $pdo->prepare($query);
              $statement->execute([$apartmentId]);
              $apartmentResult = $statement->fetch(PDO::FETCH_ASSOC);

              if ($apartmentResult) {
                  echo $apartmentResult['ApartmentName'];
              }
              ?>
            </td>
        
            <td><?= $tenant['LastName']; ?> <?= $tenant['FirstName']; ?></td>
            <td><?= $lease['EndDate']; ?></td>
            <td><?= $lease['Rent']; ?>€</td>
            <td><?= $lease['Deposit'];?>€</td>
            <td>
              <a href="lib/code.php?CurrentTenantID=<?= $tenant['TenantID']; ?>" class="btn btn-info" data-toggle="modal" data-target="#editTenantModal">Update</a>
              <form action="lib/code.php" method="POST" class="d-inline">
                <button type="submit" name="delete_tenant" value="<?=$tenant['TenantID']; ?>" class="btn-delete btn btn-danger">Supprimer</a>
              </form>
            </td>
          </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </tbody>
    </table>
  </div>

  <!-- Add Tenant Modal -->
  <div class="modal fade" id="addTenantModal" tabindex="-1" role="dialog" aria-labelledby="addTenantModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTenantModalLabel">Add a Tenant</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Tenant form fields -->
          <form action="lib/code.php" method="POST">
            <div class="form-group">
              <label for="apartmentInput">Apartment</label>
              <select class="form-control" id="apartmentSelect" name="apartment">
                <?php
                $stmt = $pdo->query("SELECT ApartmentID, ApartmentName FROM Apartment");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $apartmentID = $row['ApartmentID'];
                    $apartmentName = $row['ApartmentName'];
                    ?>
                    <option value="<?= $apartmentID; ?>"><?= $apartmentName; ?></option>
                    <?php
                }
                ?>
            </select>
            </div>

            <div class="form-group">
              <label for="nameInput">First Name</label>
              <input type="text" class="form-control" name="firstName" id="fNameInput" placeholder="...">
            </div>

            <div class="form-group">
              <label for="nameInput">Last Name</label>
              <input type="text" class="form-control" name="lastName" id="lNameInput" placeholder="...">
            </div>

            <div class="form-group">
              <label for="emailInput">Login</label>
              <input type="text" class="form-control" id="emailInput" name="email" placeholder="Create login ID">
            </div>

            <div class="form-group">
              <label for="emailInput">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>

            <div class="form-group">
              <label for="numberInput">Phone Number</label>
              <input type="text" class="form-control" id="numberInput" name="number" placeholder="Number">
            </div>

            <div class="form-group">
              <label for="endLeaseInput">Start Lease</label>
              <input type="date" name="startLease" id="StartLeaseInput">
            </div>

            <div class="form-group">
              <label for="endLeaseInput">End Lease</label>
              <input type="date" name="endLease" id="endLeaseInput">
            </div>

            <div class="form-group">
              <label for="rent">Rent</label>
              <input type="number" name="rent">
            </div>

            <div class="form-group">
              <label for="rent">Deposit</label>
              <input type="number" name="deposit">
            </div>

        
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="saveTenant">Save Tenant</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Update Tenant Modal --> 
    <div class="modal fade" id="editTenantModal" tabindex="-1" role="dialog" aria-labelledby="editTenantModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addTenantModalLabel">Edit a Tenant</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <!-- Tenant form fields -->
            <?php
            if (isset($_GET['CurrentTenantID'])) {
                $tenant_id = $_GET['CurrentTenantID'];
                $query = "SELECT * FROM CurrentTenant WHERE  CurrentTenantID = :tenant_id";
                $res = $pdo->prepare($query);
                $res->bindParam(":tenant_id", $tenant_id);
                $res->execute();

                if ($res->rowCount() > 0) {
                    $tenant = $res->fetch(PDO::FETCH_ASSOC);
                ?>  
            <form action="lib/code.php" method="POST">
                <input type='hidden' name="CurrentTenantID" value="<?= $tenant['CurrentTenantID']; ?>">
                <div class="form-group">
                <label for="apartmentInput">Apartment</label>
                <select class="form-control" id="apartmentSelect" name="apartment">
                <?php
                  $stmt = $pdo->query("SELECT ApartmentID, Name FROM Apartment");
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $apartmentID = $row['ApartmentID'];
                    $apartmentName = $row['Name'];
                  ?>
                    <option value="<?= $apartmentID; ?>"><?= $apartmentName; ?></option>
                    <?php
                }
                ?>

              </select>
                </div>
                <div class="form-group">
                <label for="nameInput">Name</label>
                <input type="text" class="form-control" name="name" value="<?= $tenant['TenantName']; ?>" id="nameInput">
                </div>
                <div class="form-group">
                <label for="endLeaseInput">End Lease</label>
                <input type="date" name="endLease" class="form-control" id="endLeaseInput">
                </div>
                <div class="form-group">
                <label for="emailInput">Email</label>
                <input type="email" name="email" class="form-control" id="emailInput" placeholder="Email">
                </div>
                <div class="form-group">
                <label for="numberInput">Number</label>
                <input type="text" name="number" class="form-control" id="numberInput" placeholder="Number">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="updateTenant">Edit Tenant</button>
                </div>
            </form>
            </div>
        </div>
                    <?php
                } else {
                    echo "<h4> No such Id found</h4>"; 
                }
            }
            ?>
        </div>
    </div>

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
