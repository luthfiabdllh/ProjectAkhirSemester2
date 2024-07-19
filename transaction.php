<?php
require "src/userpanel/session.php";
require "src/php/connect.php";

if (isset($_SESSION['idUser'])) {
    $idUser = mysqli_real_escape_string($con, $_SESSION['idUser']);

    $queryTransaction = "SELECT sc.idSchedule AS idSchedule, 
                                TIME(sc.depatureDate) AS depatureTime, 
                                TIME(sc.arrivalDate) AS arrivalTime, 
                                sc.stock AS stock, 
                                DATE_FORMAT(sc.depatureDate, '%d %M %Y') AS depatureDate, 
                                ro.Origin AS origin, 
                                ro.Destination AS destination, 
                                tr.transportName AS transportName, 
                                tt.transportType AS transportType, 
                                FORMAT(sc.price, 0) AS price
                            FROM ticket t
                            NATURAL JOIN schedule sc 
                            NATURAL JOIN route ro 
                            NATURAL JOIN transport tr 
                            NATURAL JOIN transporttype tt 
                            WHERE t.idUser = '$idUser'";

    $queryTransactionResult = mysqli_query($con, $queryTransaction);
    $jumlahTransaction = mysqli_num_rows($queryTransactionResult);
} else {
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Travel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="src/css/style.css">
    <style>
        .bannerSearch{
            background: url('src/assets/images/bannert.jpg');
            background-blend-mode: multiply;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            height: 350px;
        }
        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card:hover{
            background-color: #f8f8f8;
        }
    </style>
</head>
<body >
    <div class="fixed-top">
        <?php require "src/userpanel/navbar.php";?>
    </div>
    <div class="bannerSearch container-fluid d-flex align-items-end">
        <div class="text-white container">
            <h1>Transaksi Anda</h1>
        </div>    
    </div>
    
    <div class="container mt-3">
        <?php
            if($jumlahTransaction <= 0){
        ?>
            <h2>Lakukan pemesanan ticket</h2>
        <?php
            } else {
                while($dataTicket = mysqli_fetch_array($queryTransactionResult)){
        ?>
            <div class="card my-3 w-100">
                <h5 class="card-header d-flex justify-content-between">
                    <div><i class="fa-solid fa-ticket me-3"></i>Tiket <span><?php echo $dataTicket['transportType']?></span></div>
                    <div><i class="fa-solid fa-calendar me-2"></i><span><?php echo $dataTicket['depatureDate']?></span></div>
                </h5>
                <div class="card-body">
                    <div class="mb-2">
                        <h1 class="card-title mb-3"><?php echo $dataTicket['transportName']?></h1>
                        <div class="mb-3 border border-success p-0 rounded-pill d-flex justify-content-center align-items-center">
                            <div>
                                <i class="fa-solid fa-suitcase-rolling me-3"></i><span><?php echo $_SESSION['username']?></span>
                            </div>
                        </div>
                        <div>
                            <span><?php echo $dataTicket['origin']?></span>
                            <span><i class="fa-solid fa-right-long mx-3"></i></span>
                            <span><?php echo $dataTicket['destination']?></span>
                        </div>
                    </div>
                    <div class="fs-5 mb-2">
                        <div><i class="fa-solid fa-plane-departure me-3"></i><span><?php echo $dataTicket['depatureTime']?></span></div>
                        <div class="fs-3 mt-3 mb-3 d-flex justify-content-center"><i class="fa-solid fa-angles-down"></i></div>
                        <div><i class="fa-solid fa-plane-arrival me-3"></i><span><?php echo $dataTicket['arrivalTime']?></span></div>
                    </div>
                    <div class="mb-2">
                        <h4 class="text-danger mb-3">Rp. <?php echo $dataTicket['price']?></h4>
                        <div class="d-grid">
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Boarding Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            }
        ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="bootstrap/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="bootstrap/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome -->
    <script src="fontawesome/js/all.min.js"></script>
    <!-- Custom JS -->
    <script src="src/js/script.js"></script>
</body>
</html>