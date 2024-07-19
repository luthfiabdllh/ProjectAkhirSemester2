<?php
    require "session.php";
    require "../php/connect.php";

    $queryTicket = mysqli_query($con, "SELECT us.username AS username, ti.bookingDate AS bookingDate, sc.depatureDate AS depatureDate, sc.arrivalDate AS arrivalDate, ro.Origin AS origin, ro.Destination AS destination, tr.transportName AS transportName, tt.transportType AS transportType FROM users us NATURAL JOIN ticket ti NATURAL JOIN schedule sc NATURAL JOIN route ro NATURAL JOIN transport tr NATURAL JOIN transporttype tt");
    $jumlahTicket = mysqli_num_rows($queryTicket);
    
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
                    <a href="../adminpanel" class="text-decoration-none text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Ticket
                </li>
            </ol>
        </nav>

    <div class="container mt-3">
        <h2>Ticket List</h2>
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Transport Type</th>
                        <th>Transport Name</th>
                        <th>Booking Date</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Depature Date</th>
                        <th>Arrival Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($jumlahTicket==0){
                    ?>
                        <tr>
                            <td colspan=2 class="text-center">Data Ticket Not Found</td>
                        </tr>
                    <?php
                        }
                        else{
                            $jumlah=1;
                            while($data=mysqli_fetch_array($queryTicket)){
                    ?>
                                <tr>
                                    <td><?php echo $jumlah;?></td>
                                    <td><?php echo $data['username'];?></td>
                                    <td><?php echo $data['transportType'];?></td>
                                    <td><?php echo $data['transportName'];?></td>
                                    <td><?php echo $data['bookingDate'];?></td>
                                    <td><?php echo $data['origin'];?></td>
                                    <td><?php echo $data['destination'];?></td>
                                    <td><?php echo $data['depatureDate'];?></td>
                                    <td><?php echo $data['arrivalDate'];?></td>
                                </tr>
                    <?php
                            $jumlah++;
                            }
                        }
                    ?>
                </tbody>
            </table>
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