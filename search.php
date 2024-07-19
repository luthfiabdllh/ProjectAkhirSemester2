<?php
    require "src/userpanel/session.php";
    require "src/php/connect.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $origin = $_POST['origin'];
        $depatureDate = $_POST['depatureDate'];
        $destination = $_POST['destination'];
        $returnDate = $_POST['returnDate'];
        $transporttype = $_POST['options'];

        $querySchedule = mysqli_query($con, "SELECT sc.idSchedule AS idSchedule, TIME(sc.depatureDate) AS depatureTime , TIME(sc.arrivalDate) AS arrivalTime ,sc.stock AS stock, DATE_FORMAT(DATE(sc.depatureDate), '%d %M %Y') AS depatureDate, ro.Origin As origin, ro.Destination AS destination, tr.transportName AS transportName, tt.transportType AS transportType, FORMAT(sc.price, 0) AS price
                                                FROM schedule sc 
                                                NATURAL JOIN route ro 
                                                NATURAL JOIN transport tr 
                                                NATURAL JOIN transporttype tt 
                                                WHERE ro.Origin = '$origin' AND ro.Destination = '$destination' AND tt.transportType = '$transporttype' AND (DATE_FORMAT(sc.depatureDate, '%Y-%m-%d') = '$depatureDate' 
                                                OR DATE_FORMAT(sc.depatureDate, '%Y-%m-%d') = '$returnDate')"
        );
        $jumlahSchedule = mysqli_num_rows($querySchedule);
        // Ambil datetime saat ini
        $datetimenow = date('Y-m-d H:i:s');
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
            background: url('src/assets/images/banner2.jpg');
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
<body>
    <div class="fixed-top">
        <?php require "src/userpanel/navbar.php";?>
    </div>
    <div class="bannerSearch container-fluid d-flex align-items-end">
        <div class="text-white container">
            <h1>Available Ticket</h1>
        </div>    
    </div>
    
    <div class="container mt-3">
        <?php
            if($jumlahSchedule <= 0){
        ?>
            <h2>Tiket Sedang Tidak Tersedia</h2>
        <?php
            } else {
                while($dataTicket = mysqli_fetch_array($querySchedule)){
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
                                <i class="fa-solid fa-suitcase-rolling me-3"></i><span><?php echo $dataTicket['stock']?></span>
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
                        <h4 class="text-danger mb-3">Rp. <?php echo $dataTicket['price']?>/pax</h4>
                        <div class="d-grid">
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Ticket</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Beli Tiket</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                <div class="modal-body">
                    <p>Apakah anda yakin melakukan pembelian tiket?</p>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <form method="POST" action="src/php/purchaseTicket.php">
                            <input type="hidden" name="datetime" value="<?php echo $datetimenow; ?>">
                            <input type="hidden" name="idSchedule" value="<?php echo $dataTicket['idSchedule']; ?>">
                            <input type="hidden" name="idUser" value="<?php echo $_SESSION['idUser']; ?>">
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
                }
            }
        ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="bootstrap/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="bootstrap/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome -->
    <script src="fontawesome/js/all.min.js"></script>
    <!-- Custom JS -->
    <script src="src/js/script.js"></script>
</body>
</html>