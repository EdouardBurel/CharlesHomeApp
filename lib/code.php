<?php
$pdo = new PDO('mysql:dbname=edouardburel_charleshome;host=mysql-edouardburel.alwaysdata.net', '302132_chome', 'Charleshome1');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ADD TENANT

if(isset($_POST['saveTenant']))
{
    $apartment = $_POST['apartment'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $number = $_POST['number'];

    $res = $pdo->prepare("INSERT INTO Tenant (ApartmentID, LastName, FirstName, Email, Password, Number) VALUES (:apartment, :lastName, :firstName, :email, :password, :number)");
    $res->bindParam(':apartment', $apartment);
    $res->bindParam(':lastName', $lastName);
    $res->bindParam(':firstName', $firstName);
    $res->bindParam(':email', $email);
    $res->bindParam(':password', $password);
    $res->bindParam(':number', $number);
    $res->execute();

    $tenantID = $pdo->lastInsertId();

    $startLease = $_POST['startLease'];
    $endLease = $_POST['endLease'];
    $rent = $_POST['rent'];
    $deposit = $_POST['deposit'];

    $res = $pdo->prepare("INSERT INTO RentalLease (TenantID, ApartmentID, StartDate, EndDate, Rent, Deposit) VALUES (:tenantID, :apartment, :startLease, :endLease, :rent, :deposit)");
    $res->bindParam(':tenantID', $tenantID);
    $res->bindParam(':apartment', $apartment);
    $res->bindParam(':startLease', $startLease);
    $res->bindParam(':endLease', $endLease);
    $res->bindParam(':rent', $rent);
    $res->bindParam(':deposit', $deposit);

    $res->execute();


    if ($res) {;
        $messages[] = "La location a bien été ajouté"; header("Location: /admin.php");
        exit(0);
    } else {
        $errors[] = "Une erreur s\'est produite."; header("Location: /admin.php");
        exit(0);
    }
}

// DELETE TENANT

if(isset($_POST['delete_tenant']))
{
    $tenant_id = $_POST['delete_tenant'];

    $query = "DELETE FROM Tenant WHERE TenantID=:tenant_id";
    $res = $pdo->prepare($query);
    $res->bindParam(':tenant_id', $tenant_id);
    $res->execute();

    if($res)
    {
        $_SESSION['message'] = "Horaire supprimé";
        header("Location: /tenants.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Une erreur s'est produite.";
        header("Location: /tenants.php");
        exit(0);
    }

}

// DELETE INVOICE

if(isset($_POST['delete_invoice']))
{
    $tenant_id = $_POST['delete_invoice'];

    $query = "DELETE FROM MonthlyInvoice WHERE TenantID=:tenant_id";
    $res = $pdo->prepare($query);
    $res->bindParam(':tenant_id', $tenant_id);
    $res->execute();

    if($res)
    {
        header("Location: /invoiceAdmin.php");
        exit(0);
    }

}

// UPDATE TENANT

if(isset($_POST['updateTenant']))
{
    $tenant_id = $_POST['CurrentTenantID'];

    $apartment = $_POST['apartment'];
    $name = $_POST['name'];
    $endLease = $_POST['endLease'];
    $email = $_POST['email'];
    $number = $_POST['number'];

    $query = "UPDATE CurrentTenant SET Apartment=:apartment, TenantName=:name, EndLease=:endLease, Email=:email, Number=:number WHERE CurrentTenantID=:tenant_id";
    $res = $pdo->prepare($query);
    $res->execute([
        'CurrentTenantID' => $tenant_id,
        'Apartment' => $apartment,
        'TenantName' => $name,
        'EndLease' => $endLease,
        'Email' => $email,
        'Number' => $number
    ]);

    if($res)
    {
        $_SESSION['message'] = "Horaire modifié";
        header("Location: /tenants.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Une erreur s'est produite";
        header("Location: /tenants.php");
        exit(0);
    }
}

// FRONT DOOR CODE
function getFrontDoorCode($building) {
    switch ($building) {
        case 'Montagne':
            return '5962C';
        case 'Palmerston':
            return '09250';
        case 'Paul Lauters':
            return '&#x1F5DD; 1472 &#x1F5DD;';
        default:
            return 'Unknown';
    }
}
