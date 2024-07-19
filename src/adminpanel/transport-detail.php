<?php
    require "session.php";
    require "../php/connect.php";
    
    $id = $_GET['q'];

    $query = mysqli_query($con, "SELECT * FROM transport WHERE idTransport='$id'");
    $data = mysqli_fetch_array($query);

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Detail</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../bootstrap/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../../fontawesome/css/fontawesome.min.css">
    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
</head>
<body>
    <?php require "navbar.php"?>

    <div class="container mt-5"> 
        <h2>Transport Detail</h2>
        
        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="transport">Transport</label>
                    <input type="text" name="transport" id="transport" class="form-control" value="<?php echo $data['transportName'];?>"> 
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary" name="editBtn" >Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn" >Delete</button>
                </div>
            </form>

            <?php
                if(isset($_POST['editBtn'])) {
                    $transport = htmlspecialchars($_POST['transport']);

                    if($data['transportName']==$transport) {
            ?>
                        <meta http-equiv="refresh" content="0; url=transport.php" >
            <?php
            
                    }
                    else {
                        $query=mysqli_query($con, "SELECT * FROM transport WHERE transportName='$transport'");
                        $jumlahData = mysqli_num_rows($query);

                        if($jumlahData>0) {
            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Transport Already Exist!
                            </div>    
            <?php
                        }
                        else{
                            $queryUpdate = mysqli_query($con, "UPDATE transport SET transportName='$transport' WHERE idTransport='$id'");
                            if($queryUpdate){
            ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Transport Type Successfully Added!
                            </div>
                            <meta http-equiv="refresh" content="3; url=transport.php">                
            <?php
                            }
                            else{
                                echo mysqli_error($con);
                            }
                        }
                    }
                }

                if(isset($_POST['deleteBtn'])){
                    $queryCheck = mysqli_query($con, "SELECT * FROM transport WHERE idTransport='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);
                    if($dataCount>0){
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Transport Can't Delete
                        </div>
                        <meta http-equiv="refresh" content="3; url=transport.php">  
            <?php
                        die();
                    }
                    
                    $queryDelete = mysqli_query($con, "DELETE FROM transport WHERE idTransport = '$id'");

                    if($queryDelete) {
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Transport Successfully Deleted!
                        </div>
                        <meta http-equiv="refresh" content="3; url=transport.php">       
            <?php
                    }
                    else{
                        echo mysqli_error($con);
                    }
                }
            ?>
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