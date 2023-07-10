<?php
session_start();

$pdo = new PDO('mysql:dbname=edouardburel_charleshome;host=mysql-edouardburel.alwaysdata.net', '302132_chome', 'Charleshome1');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['submit'])){
    $email= $_POST['email'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM Tenant WHERE Email = :email");
    $query->bindValue('email', $email);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_ASSOC);

    if ($res) {

       if($res['Role'] == 'admin'){
   
          $_SESSION['admin_id'] = $res['TenantID'];
          header('location:/admin.php');
 
       }elseif($res['Role'] == 'user'){
 
          $_SESSION['user_id'] = $res['TenantID'];
          header('location:index.php');

       }
    }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

        body {
            background-color: #343a40;
            color: white;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        .btn-login {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            background-color: orange;
            border-radius: 25px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="form-container">
            <img class="logo" src="image/logo_charles-home.png" alt="Logo">
            <form method="POST" enctype="multipart/form-data">
                <input name="email" type="text" class="form-control" placeholder="Username" required><br>
                <input name="password" type="password" class="form-control" placeholder="Password" required><br>
                <div class="btn-login">
                    <button name="submit" type="submit" class="btn">Login</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

