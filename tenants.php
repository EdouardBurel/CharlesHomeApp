<?php
ini_set('display_errors', 'off');

session_start();
$csrfToken = bin2hex(random_bytes(32)); // Génère un jeton CSRF aléatoire
$_SESSION['csrf_token'] = $csrfToken; // Stocke le jeton dans la session

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
                <img src="image/logos/logo-key.png" alt="Charles Home">
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
                    <a href="invoiceAdmin.php">
                        <i class="fa-solid fa-file-invoice"></i>
                        <span class="link-name">Invoice</span>
                    </a>
                </li>
            </ul>

            <ul class="logout-mode">
                <li>
                    <a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="link-name">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
  <div class="container mt-5">
    <h1>Apartment Management</h1>
    <button class="btn btn-primary mb-3 mt-5" data-toggle="modal" data-target="#addTenantModal">Add a tenant</button>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Apartment</th>
          <th>Name</th>
          <th>Source</th>
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
            <td><?= $tenant['Source']; ?></td>
            <td><?= $lease['EndDate']; ?></td>
            <td><?= $lease['Rent']; ?>€</td>
            <td><?= $lease['Deposit'];?>€</td>
            <td>
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
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Tenant form fields -->
          <form action="lib/code.php" method="POST">
            
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

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
              <label for="nameInput">Source</label>
              <select class="form-control" name="source" id="source">
                <option value="CharlesHome">Charles Home</option>
                <option value="Silverdoor">Silverdoor</option>
                <option value="Airbnb">Airbnb</option>
                <option value="Homelike">Homelike</option>
              </select>
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

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
