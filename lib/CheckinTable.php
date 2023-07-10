<?php

    $stmt = $pdo->query("SELECT * FROM Tenant");
    $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtLease= $pdo->query("SELECT * FROM RentalLease");
    $leases = $stmtLease->fetchAll(PDO::FETCH_ASSOC);

    $currentDate = date('Y-m-d');
    $endOfMonth = date('Y-m-t', strtotime('this month'));

    /* CHECK-IN-OUT COUNTS  */
    $sqlCheckIn = "SELECT COUNT(*) AS checkInCount FROM RentalLease WHERE StartDate BETWEEN :currentDate AND :endOfMonth";
    $stmtCheckIn = $pdo->prepare($sqlCheckIn);
    $stmtCheckIn->bindParam(':currentDate', $currentDate);
    $stmtCheckIn->bindParam(':endOfMonth', $endOfMonth);
    $stmtCheckIn->execute();
    $checkInCount = $stmtCheckIn->fetchColumn();

    $sqlCheckOut = "SELECT COUNT(*) AS checkOutCount FROM RentalLease WHERE EndDate BETWEEN :currentDate AND :endOfMonth";
    $stmtCheckOut = $pdo->prepare($sqlCheckOut);
    $stmtCheckOut->bindParam(':currentDate', $currentDate);
    $stmtCheckOut->bindParam(':endOfMonth', $endOfMonth);
    $stmtCheckOut->execute();
    $checkOutCount = $stmtCheckOut->fetchColumn();

    $currentDate = date('Y-m-d');
    $endOfMonth = date('Y-m-t', strtotime('this month'));
    
    // Retrieve ApartmentIDs and StartDates
    $sqlCheckIn = "SELECT ApartmentID, StartDate FROM RentalLease WHERE StartDate BETWEEN :currentDate AND :endOfMonth";
    $stmtCheckIn = $pdo->prepare($sqlCheckIn);
    $stmtCheckIn->bindParam(':currentDate', $currentDate);
    $stmtCheckIn->bindParam(':endOfMonth', $endOfMonth);
    $stmtCheckIn->execute();
    $checkInRows = $stmtCheckIn->fetchAll(PDO::FETCH_ASSOC);
    
    // Retrieve ApartmentIDs and EndDates
    $sqlCheckOut = "SELECT ApartmentID, EndDate FROM RentalLease WHERE EndDate BETWEEN :currentDate AND :endOfMonth";
    $stmtCheckOut = $pdo->prepare($sqlCheckOut);
    $stmtCheckOut->bindParam(':currentDate', $currentDate);
    $stmtCheckOut->bindParam(':endOfMonth', $endOfMonth);
    $stmtCheckOut->execute();
    $checkOutRows = $stmtCheckOut->fetchAll(PDO::FETCH_ASSOC);
    ?>