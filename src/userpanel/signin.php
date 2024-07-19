<?php
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
        border-radius: 10px        
    }
    .blur{
        background: rgba(255, 255, 255, 0.2); 
        backdrop-filter: blur(10px); 
    }
    </style>
</head>
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="p-5 blur w-25 rounded-4">
            <form action="" method="post" class="text-light">
                <div class="mx-auto mb-3">
                    <h1>Sign Up</h1>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control bg-primary bg-gradient text-white bg-opacity-25" name="email" id="email"  placeholder="Masukan email anda">
                </div>
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control bg-primary bg-gradient text-white bg-opacity-25" name="username" id="username"  placeholder="Buat username anda">
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control bg-primary bg-gradient text-white bg-opacity-25" name="password" id="password"  placeholder="Buat password anda">
                </div>
                <div class="mb-1">
                    <button class="btn btn-primary form-control mt-3" type="submit" name="submitBtn">Sign Up</button>
                </div>
                <div>
                    <a class="btn btn-outline-primary form-control mt-3" href="login.php">Login<a>
                </div>
            </form>
        </div>
        <div class="mt-5" style="width:400px">
            <?php
                if(isset($_POST['submitBtn'])){
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);
                    $email = htmlspecialchars($_POST['email']);
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    if($username == '' || $email=='' || $password=='') {
                ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Field is NULL!
                        </div>
                <?php  
                    }
                    else{
                        $querySubmit = mysqli_query($con, "INSERT INTO users(`email`, `username`, `password`) VALUES ('$email','$username','$hashedPassword')");
                        if($querySubmit){
                ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Account Successfully Created!
                            </div>
                            <meta http-equiv="refresh" content="3" url="login.php">                
                <?php
                        }
                        else{
                            echo mysqli_error($con);
                        }
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