<?php
    require_once('lib/code.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<body class="bodyForm">
    <main>
        <?php include('../../lib/message.php'); ?>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Modifier horaire
                                <a href="hourIndex.php" class="bttn btn float-end">Retour</a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php
                            if(isset($_GET['id']))
                            {
                                $hour_id = $_GET['id'];
                                $query = "SELECT * FROM restaurant_hours WHERE id = :hour_id";
                                $res = $pdo->prepare($query);
                                $res->bindParam(":hour_id", $hour_id);
                                $res->execute();

                                if ($res->rowCount() > 0) {
                                    $hour = $res->fetch(PDO::FETCH_ASSOC);
                            ?>            
                                    <form action="../../lib/hour.php" method="POST">
                                        <input type='hidden' name="hour_id" value="<?= $hour['id']; ?>">
                                        <div class="mb-3">
                                            <label>Jour</label>
                                            <input type="text" name="day" value="<?= $hour['day']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Heure d'ouverture</label>
                                            <input type="text" name="lunch_hours" value="<?= $hour['lunch_hours']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Heure de fermeture</label>
                                            <input type="text" name="dinner_hours" value="<?= $hour['dinner_hours']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <input type="text" name="status" value="<?= $hour['status']; ?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" name="update_hour" class=" bttn btn">Mettre à jour horaire</button>
                                        </div>

                                    </form>

                                    <?php
                                }
                                else
                                {
                                echo "<h4> No such Id found</h4>"; 
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
