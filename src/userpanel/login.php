<?php
    session_start();
    require "../php/connect.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../bootstrap/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <style>
    .main{
        height: 100vh;
        background: url('../assets/images/bannerlog.jpg');
        background-blend-mode: multiply;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }
    
    .login-box{
        width: 400px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 25px        
    }
    .blur{
        background: rgba(255, 255, 255, 0.2); 
        backdrop-filter: blur(10px); 
    }
    </style>
</head>
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="p-5 w-25 rounded-4 blur">
            <form action="" method="post" class="text-light">
                <div class="mx-auto mb-3">
                    <h1>Login</h1>
                </div>
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control bg-primary bg-gradient text-white bg-opacity-25" name="username" id="username">
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control bg-primary bg-gradient text-white bg-opacity-25" name="password" id="password">
                </div>
                <div class="mb-1">
                    <button class="btn btn-primary form-control mt-3" type="submit" name="loginbtn">Login</button>
                </div>
                <div>
                    <a class="btn btn-outline-primary form-control mt-3" href="signin.php">Sign Up<a>
                </div>
            </form>
        </div>
        <div class="mt-5" style="width:400px">
            <?php
                if(isset($_POST['loginbtn'])){
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);


                    $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                    $countdata = mysqli_num_rows($query);
                    $data = mysqli_fetch_array($query);

                    if($countdata>0) {
                        if (password_verify($password, $data['password'])) {
                            $_SESSION['username'] = $data['username'];
                            $_SESSION['idUser'] = $data['idUser'];
                            $_SESSION['login'] = true;
                            header('location: ../../index.php');
                        } else{
                            ?>
                            <div class="alert alert-warning" role="alert">
                                Password salah;
                            </div>
                            <?php
                        }
                    }else{
                        ?>
                        <div class="alert alert-warning" role="alert">
                            Akun tidak tersedia
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="../../bootstrap/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../bootstrap/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../js/script.js"></script>
</body>
</html>