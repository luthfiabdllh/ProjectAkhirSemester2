<?php
// purchase_ticket.php

// Include file koneksi ke database
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datetimenow = $_POST['datetime'];
    $idSchedule = $_POST['idSchedule'];
    $idUser = $_POST['idUser'];

    // Query untuk mengurangi stok tiket
    $kurangiSchedule = "UPDATE schedule SET stock = stock - 1 WHERE idSchedule = '$idSchedule'";
    $insertTicket = "INSERT INTO ticket (idSchedule, idUser, bookingDate) VALUES ('$idSchedule', '$idUser', '$datetimenow')";

    if (mysqli_query($con, $insertTicket) and mysqli_query($con, $kurangiSchedule)) {
        ?>
        <h1><?php echo "Tiket berhasil dibeli! anda akan dialihkan ke halaman utama....";?></h1>
        <meta http-equiv="refresh" content="2; url=../../index.php"> 
        <?php
        
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($con);
        // Redirect atau tampilkan pesan error sesuai kebutuhan
    }

    mysqli_close($con);
}