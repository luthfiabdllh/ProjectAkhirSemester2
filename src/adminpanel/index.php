<?php
    require "session.php";
    require "../php/connect.php";

    $queryTicket = mysqli_query($con, "SELECT * FROM ticket");
    $jumlahTicket = mysqli_num_rows($queryTicket);

    $querySchedule = mysqli_query($con, "SELECT * FROM schedule");
    $jumlahSchedule = mysqli_num_rows($querySchedule);

    $queryRoute = mysqli_query($con, "SELECT * FROM route");
    $jumlahRoute = mysqli_num_rows($queryRoute);

    $queryTransport = mysqli_query($con, "SELECT * FROM transport");
    $jumlahTransport = mysqli_num_rows($queryTransport);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../bootstrap/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../../fontawesome/css/fontawesome.min.css">
    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <style>
        .mt-6{
            margin-top: 70px;
        }

        .square{
            border: solid 1px;
        }
        .summary-kategori{

        }
    </style>
</head>
<body>
    <div class="fixed-top">
        <?php require "navbar.php";?>
    </div>
    
    <div class="container mt-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i>
                    Home
                </li>
            </ol>
        </nav>
        <h2 class="blue">HALO <?php echo $_SESSION['username']?></h2>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class=" square bg-danger bg-gradient p-3 rounded-3">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa-solid fa-ticket fa-5x text-black-50 "></i>
                        </div>
                        <div class="col-6">
                            <h3 class="fs-5">Tiket</h3>
                            <p class="fs-6"><?php echo $jumlahTicket; ?> Tiket</p>
                            <p><a href="ticket.php" class="text-white text-decoration-none">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class=" square bg-danger bg-gradient p-3 rounded-3">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa-solid fa-calendar-days fa-5x text-black-50 "></i>
                        </div>
                        <div class="col-6">
                            <h3 class="fs-5">Schedule</h3>
                            <p class="fs-6"><?php echo $jumlahSchedule; ?> Schedule</p>
                            <p><a href="schedule.php" class="text-white text-decoration-none">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class=" square bg-danger bg-gradient p-3 rounded-3">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa-solid fa-route fa-5x text-black-50 "></i>
                        </div>
                        <div class="col-6">
                            <h3 class="fs-5">Route</h3>
                            <p class="fs-6"><?php echo $jumlahRoute; ?> Route</p>
                            <p><a href="route.php" class="text-white text-decoration-none">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class=" square bg-danger bg-gradient p-3 rounded-3">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa-solid fa-bus fa-5x text-black-50 "></i>
                        </div>
                        <div class="col-6">
                            <h3 class="fs-5">Transport</h3>
                            <p class="fs-6"><?php echo $jumlahTransport; ?> Transport</p>
                            <p><a href="tiket.php" class="text-white text-decoration-none">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

    <!-- Bootstrap JS and dependencies -->
    <script src="../../bootstrap/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../bootstrap/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome -->
    <script src="../../fontawesome/js/all.min.js"></script>
    <!-- Custom JS -->
    <script src="../js/script.js"></script>
</body>
</html>