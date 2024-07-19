<?php
    session_start();
    if($_SESSION['login']==false){
        header('location: src/userpanel/login.php');
    }
?>