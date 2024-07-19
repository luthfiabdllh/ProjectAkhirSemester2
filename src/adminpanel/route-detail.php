<?php
    require "session.php";
    require "../php/connect.php";
    
    $id = $_GET['q'];

    $query = mysqli_query($con, "SELECT r.*,t.idTransport, t.transportName AS transportName FROM route r NATURAL JOIN transport t WHERE idRoute='$id'");
    $data = mysqli_fetch_array($query);

    $queryTransport=mysqli_query($con, "SELECT * FROM transport WHERE idTransport != '$data[idTransport]'");

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
                    <label for="transportName">Transport Name</label>
                    <select name="transportName" id="transportName" class="form-control" required>
                        <option value="<?php echo $data['idTransport']?>"><?php echo $data['transportName']?></option>
                        <?php
                            while($dataTransport = mysqli_fetch_array($queryTransport)) {
                        ?>
                            <option value="<?php echo $dataTransport['idTransport']?>"><?php echo $dataTransport['transportName']?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="routeName">Route Name</label>
                    <input type="text" id="routeName" name="routeName" class="form-control"
                    value="<?php echo $data['routeName'];?>" required>
                </div>
                <div>
                    <label for="origin">Origin</label>
                    <input type="text" id="origin" name="origin" class="form-control" value="<?php echo $data['Origin'];?>" required>
                </div>
                <div>
                    <label for="destination">Destination</label>
                    <input type="text" id="destination" name="destination" class="form-control" value="<?php echo $data['Destination'];?>" required>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary" name="editBtn" >Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn" >Delete</button>
                </div>
            </form>

            <?php
                if(isset($_POST['editBtn'])) {
                    $transportName = htmlspecialchars($_POST['transportName']);
                    $routeName = htmlspecialchars($_POST['routeName']);
                    $origin = htmlspecialchars($_POST['origin']);
                    $destination = htmlspecialchars($_POST['destination']);

                    if($data['routeName']==$routeName) {
            ?>
                        <meta http-equiv="refresh" content="0; url=transport.php" >
            <?php
            
                    }
                    else {
                        $query=mysqli_query($con, "SELECT * FROM route WHERE routeName='$routeName'");
                        $jumlahData = mysqli_num_rows($query);

                        if($jumlahData>0) {
            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Transport Already Exist!
                            </div>    
            <?php
                        }
                        else{
                            $queryUpdate = mysqli_query($con, "UPDATE route SET idTransport='$id', routeName='$routeName',Origin='$origin',Destination='$destination' WHERE idRoute='$id'");
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
                    $queryCheck = mysqli_query($con, "SELECT * FROM route WHERE idRoute='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);
                    if($dataCount>0){
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Route Can't Delete
                        </div>
                        <meta http-equiv="refresh" content="3; url=transport.php">  
            <?php
                        die();
                    }
                    
                    $queryDelete = mysqli_query($con, "DELETE FROM route WHERE idRoute = '$id'");

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