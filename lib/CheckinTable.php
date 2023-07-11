<?php

    $stmt = $pdo->query("SELECT * FROM Tenant");
    $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtLease= $pdo->query("SELECT * FROM RentalLease ORDER BY StartDate ASC");
    $leases = $stmtLease->fetchAll(PDO::FETCH_ASSOC);

    $currentDate = date('Y-m-d');
    $endOfMonth = date('Y-m-t', strtotime('this month'));
    $nextMonth = date('Y-m-t', strtotime('+1 month'));

    /* CHECK-IN-OUT COUNTS  */
    $sqlCheckIn = "SELECT COUNT(*) AS checkInCount FROM RentalLease WHERE StartDate BETWEEN :currentDate AND :nextMonth";
    $stmtCheckIn = $pdo->prepare($sqlCheckIn);
    $stmtCheckIn->bindParam(':currentDate', $currentDate);
    $stmtCheckIn->bindParam(':nextMonth', $nextMonth);
    $stmtCheckIn->execute();
    $checkInCount = $stmtCheckIn->fetchColumn();

    $sqlCheckOut = "SELECT COUNT(*) AS checkOutCount FROM RentalLease WHERE EndDate BETWEEN :currentDate AND :nextMonth";
    $stmtCheckOut = $pdo->prepare($sqlCheckOut);
    $stmtCheckOut->bindParam(':currentDate', $currentDate);
    $stmtCheckOut->bindParam(':nextMonth', $nextMonth);
    $stmtCheckOut->execute();
    $checkOutCount = $stmtCheckOut->fetchColumn();
    
    // Retrieve ApartmentIDs and StartDates
    $sqlCheckIn = "SELECT ApartmentID, StartDate FROM RentalLease WHERE StartDate BETWEEN :currentDate AND :nextMonth ORDER BY StartDate ASC";
    $stmtCheckIn = $pdo->prepare($sqlCheckIn);
    $stmtCheckIn->bindParam(':currentDate', $currentDate);
    $stmtCheckIn->bindParam(':nextMonth', $nextMonth);
    $stmtCheckIn->execute();
    $checkInRows = $stmtCheckIn->fetchAll(PDO::FETCH_ASSOC);
    
    // Retrieve ApartmentIDs and EndDates
    $sqlCheckOut = "SELECT ApartmentID, EndDate FROM RentalLease WHERE EndDate BETWEEN :currentDate AND :nextMonth ORDER BY EndDate ASC";
    $stmtCheckOut = $pdo->prepare($sqlCheckOut);
    $stmtCheckOut->bindParam(':currentDate', $currentDate);
    $stmtCheckOut->bindParam(':nextMonth', $nextMonth);
    $stmtCheckOut->execute();
    $checkOutRows = $stmtCheckOut->fetchAll(PDO::FETCH_ASSOC);
    ?>