<?php
    ini_set('display_errors', 'off');
    session_start();
    require_once 'lib/code.php';

    $pdo = new PDO('mysql:dbname=edouardburel_charleshome;host=mysql-edouardburel.alwaysdata.net', '302132_chome', 'Charleshome1');
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(!isset($_SESSION['user_id'])) {
        header('location: login.php');
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/override-bootstrap.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    
    <title>Charles Home</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
            <?php
                $id = (int)$_SESSION['user_id'];
                $query = "SELECT * FROM Tenant WHERE TenantID = ?";
                $res = $pdo->prepare($query);
                $res->execute([$id]);

                $user = $res->fetch(PDO::FETCH_ASSOC);

                $reservationName = (string)$user['FirstName'].' '.(string)$user['LastName'];
                $reservationLastName = (string)$user['LastName'];



                echo <<<HTML
              <img src="image/logo_charles-home.png" alt="CHARLES HOME">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Your stay</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#help" style="color:red; cursor: pointer">Need Assistance</a>
                  </li>
                </ul>
                <span class="helloText navbar-text">
                    Hello $reservationName !
                </span>
                <span class="nav-item">
                    <a href="logout.php" class="nav-link" style="text-align: end">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                    Logout</a>
                </span>

              </div>
            </div>
            HTML;
            ?>
        </nav>
    </header>
    <main>
        <?php
        // Query to fetch the ApartmentID for the name "John Doe"
        $query = "SELECT ApartmentID FROM Tenant WHERE FirstName = ? AND LastName = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$user['FirstName'], $user['LastName']]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $apartmentId = $result['ApartmentID'];
            // Use the $apartmentId to fetch the corresponding apartment name
            $query = "SELECT ApartmentName FROM Apartment WHERE ApartmentID = :apartment_id";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':apartment_id', $apartmentId);
            $statement->execute();
            $apartmentResult = $statement->fetch(PDO::FETCH_ASSOC);

            if ($apartmentResult) {
                $apartmentName = $apartmentResult['ApartmentName'];
                $buildingName = rtrim($apartmentName, ' 1234567890');
                $extractedApartmentName = strtolower(preg_replace('/[^a-zA-Z]/', '', $apartmentName));
            }
        }
        ?>
        <div class="container">
            <img class="imgApart" src="image/apartment/<?php echo strtolower(str_replace(' ', '', $apartmentName)); ?>.jpg" alt="Apartment">
            <div class="centered">
            <h3><?php echo $apartmentName; ?></h3>
            </div>
        </div>

        <div class="container cards mt-3">
            <div class="card mb-3">
                <div class="card-header">
                    <h5>
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm54.2 253.8c-6.1 20.3-24.8 34.2-46 34.2H80c-8.8 0-16-7.2-16-16s7.2-16 16-16h8.2c7.1 0 13.3-4.6 15.3-11.4l14.9-49.5c3.4-11.3 13.8-19.1 25.6-19.1s22.2 7.7 25.6 19.1l11.6 38.6c7.4-6.2 16.8-9.7 26.8-9.7c15.9 0 30.4 9 37.5 23.2l4.4 8.8H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-6.1 0-11.6-3.4-14.3-8.8l-8.8-17.7c-1.7-3.4-5.1-5.5-8.8-5.5s-7.2 2.1-8.8 5.5l-8.8 17.7c-2.9 5.9-9.2 9.4-15.7 8.8s-12.1-5.1-13.9-11.3L144 349l-9.8 32.8z"/></svg>
                    About your stay
                    </h5>
                </div>
                <div class="card-body text-secondary">
                    <span> - </span><a href="docs/lease/lease_<?php echo $reservationLastName.'-'.strtolower(str_replace(' ', '', $apartmentName)); ?>.pdf" target="_blank" class="card-text mb-1"> Rental lease (PDF)</a>
                    <p class="card-text mb-1">- Monthly Rent: 2500€</p>
                    <p class="card-text mb-1">- Deposit: 900€</p>
                    <p class="card-text mb-1">- End of the lease: dd/mm/yy</p>
                </div>
            </div>


            <a href="invoicePage.php" class="custom-card">
                <div class="card border-secondary mb-3">
                    <div class="card-header">
                        <h5>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                        Invoices
                        </h5>
                    </div>
                        <div class="card-body text-secondary" style="display: flex; justify-content:center; align-items:center">
                            <p class="card-text">View your rental invoices.</p>
                        </div>
                </div>
            </a>


            <div class="card border-success mb-3">
                <h5 class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                     Useful Information
                </h5>
                <div class="card-body text-secondary">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#garbage">View waste collection days</a>
                    <p></p>
                    <?php $frontDoorCode = getFrontDoorCode($buildingName); ?>
                    <?php echo '<p class="card-text mb-2">Front door code: ' . $frontDoorCode . '</p>'?>
                    <p></p>
                    <p class="card-text mb-2">Ask for a cleaning service.</p>
                </div>
            </div>
            <div class="modal fade" id="garbage" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title"><?php echo $buildingName; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="image/collectes/<?php echo $extractedApartmentName; ?>.jpg" alt="bin" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <a href="#" data-bs-toggle="modal" data-bs-target="#help" class="custom-card">
                <div class="card border-danger mb-3">
                    <h5 class="card-header">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                        </svg>
                        Need Assistance
                    </h5>
                    <div class="card-body d-flex flex-column">
                        <span class="card-text"> - Cannot access the apartment?</span>
                        <br>
                        <span class="card-text"> - No hot water? Leak? etc...</span>
                        <div class="mt-auto text-center">
                            <h5 class="card-text text-danger">Click for assistance</h5>
                        </div>
                    </div>
                </div>
            </a>



            <div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="addInvoiceModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addInvoiceModalLabel">Assistance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                            <div class="mb-3" style="font-size: small;">
                                <p style="font-weight:bold">Office number Tel: 02 318 42 10</p>
                                <p>We kindly requested to <span style="color: red;">leave a voice message</span> on our office number. Once we receive the message, we will promptly get in touch with you.</p>
                            </div>
                                <div class="mb-3">
                                    <label for="concern" class="form-label">Select your concern:</label>
                                    <select class="form-select" id="concern">
                                        <option disabled selected>---</option>
                                        <option value="no-hot-water">No hot water in the apartment</option>
                                        <option value="cannot-access">Cannot access the apartment</option>
                                        <option value="washing-machine-issue">Issue with the washing machine</option>
                                        <option value="apartment-leak">Leak in the apartment</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div id="concern-text" class="mb-3"></div>
                                <div id="other-description" class="mb-3" style="display: none;">
                                    <label for="issue-description" class="form-label">Please describe your issue:</label>
                                    <textarea class="form-control" id="issue-description" rows="3"></textarea>
                                </div>
                                <button type="submit" id="submit-btn" class="btn btn-primary" style="display: none;">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </main>
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-3 d-flex align-items-center">
          <span class="mb-2 mb-md-0" style="color:#fff">© 2023 Charles Home. All rights reserved</span>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <a href="https://www.charleshome.com/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                <img src="image/logo-key.png" alt="CHARLES HOME" width="30px">
              </a>
        </div>
        <div class="col-md-3 d-flex align-items-center justify-content-end">
            <span class="mb-2 m-md-1" style="color:#fff">contact@charleshome.com</span>
          </div>
      </footer>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script>
        // Assign values to JavaScript variables
        var apartmentName = '<?php echo $apartmentName; ?>';
        var reservationName = '<?php echo $reservationName; ?>';
        </script>
      <script src="script.js"></script> 
</body>
</html>