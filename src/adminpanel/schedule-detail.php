<?php
    require "session.php";
    require "../php/connect.php";
    
    $id = $_GET['q'];

    $query = mysqli_query($con, "SELECT s.*, t.transportName, r.Origin AS origin, r.Destination AS destination, r.idRoute AS idRoute, r.routeName AS routeName FROM schedule s NATURAL JOIN route r NATURAL JOIN transport t WHERE idSchedule='$id'");
    $data = mysqli_fetch_array($query);

    $queryRoute=mysqli_query($con, "SELECT * FROM route WHERE idRoute != '$data[idRoute]'");

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
                    <label for="routeName">Route Name</label>
                    <select name="routeName" id="routeName" class="form-control" required>
                        <option value="<?php echo $data['idRoute']?>"><?php echo $data['routeName']?></option>
                        <?php
                            while($dataRoute = mysqli_fetch_array($queryRoute)) {
                        ?>
                            <option value="<?php echo $dataTransport['idRoute']?>"><?php echo $dataRoute['routeName']?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="scheduleName">Schedule Name</label>
                    <input type="text" id="scheduleName" name="scheduleName" class="form-control" value="<?php echo $data['scheduleName'];?>" required>
                </div>
                <div>
                    <label for="depatureDate">Depature Time</label>
                    <input type="datetime-local" id="depatureDate" name="depatureDate" class="form-control" value="<?php echo $data['depatureDate'];?>" required>
                </div>
                <div>
                    <label for="arrivalDate">Arrival Time</label>
                    <input type="datetime-local" id="arrivalDate" name="arrivalDate" class="form-control" value="<?php echo $data['arrivalDate'];?>" required>
                </div>
                <div>
                    <label for="stock">Stock Ticket</label>
                    <input type="number" id="stock" name="stock" class="form-control" value="<?php echo $data['stock'];?>" required>
                </div>
                <div>
                    <label for="price">Price Ticket</label>
                    <input type="number" id="price" name="price" class="form-control" value="<?php echo $data['price'];?>" required>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary" name="editBtn" >Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn" >Delete</button>
                </div>
            </form>

            <?php
                if(isset($_POST['editBtn'])) {
                    $routeName = htmlspecialchars($_POST['routeName']);
                    $scheduleName = htmlspecialchars($_POST['scheduleName']);
                    $depatureDate = htmlspecialchars($_POST['depatureDate']);
                    $arrivalDate = htmlspecialchars($_POST['arrivalDate']);
                    $stock = htmlspecialchars($_POST['stock']);
                    $price = htmlspecialchars($_POST['price']);

                    if($data['routeName']==$routeName) {
            ?>
                        <meta http-equiv="refresh" content="0; url=transport.php" >
            <?php
            
                    }
                    else {
                        $query=mysqli_query($con, "SELECT * FROM schedule WHERE scheduleName='$scheduleName'");
                        $jumlahData = mysqli_num_rows($query);

                        if($jumlahData>0) {
            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Schedule Already Exist!
                            </div>    
            <?php
                        }
                        else{
                            $queryUpdate = mysqli_query($con, "UPDATE schedule SET `idSchedule`='$id',`idRoute`='$routeName',`scheduleName`='$scheduleName',`stock`='$stock',`price`='$price',`depatureDate`='$depatureDate',`arrivalDate`='$arrivalDate' WHERE idRoute='$id'");
                            if($queryUpdate){
            ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Transport Type Successfully Added!
                            </div>
                            <meta http-equiv="refresh" content="3; url=schedule.php">                
            <?php
                            }
                            else{
                                echo mysqli_error($con);
                            }
                        }
                    }
                }

                if(isset($_POST['deleteBtn'])){
                    $queryCheck = mysqli_query($con, "SELECT * FROM schedule WHERE idSchedule='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);
                    if($dataCount>0){
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Schedule Can't Delete
                        </div>
                        <meta http-equiv="refresh" content="3; url=transport.php">  
            <?php
                        die();
                    }
                    
                    $queryDelete = mysqli_query($con, "DELETE FROM schedule WHERE idSchedule = '$id'");

                    if($queryDelete) {
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Schedule Successfully Deleted!
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