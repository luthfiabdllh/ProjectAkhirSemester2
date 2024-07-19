<?php
    require "session.php";
    require "../php/connect.php";

    $queryTransport = mysqli_query($con, "SELECT t.*, tt.transportType AS transportType FROM transport t JOIN transportType tt ON t.idTransportType = tt.idTransportType");
    $jumlahTransport = mysqli_num_rows($queryTransport);

    $queryTransportType=mysqli_query($con, "SELECT * FROM transporttype");
    $jumlahTransportType = mysqli_num_rows($queryTransportType);
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
<body class=".bg-dark">
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
                    Transport
                </li>
            </ol>
        </nav>
        
        <div class="my-5 col-12 col-md-6">
            <h3>Add transport Type</h3>
            <form action="" method="post">
                <div>
                    <label for="transportType">Transport Type</label>
                    <input type="text" id="transportType" name="transportType" placeholder="Transport Type" class="form-control" required>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="submitTransportType">Submit</button>
                </div>
            </form>
            
            
            <?php
                if(isset($_POST['submitTransportType'])){
                    $transportType = htmlspecialchars($_POST['transportType']);

                    $queryExist = mysqli_query($con, "SELECT transportType FROM transporttype WHERE transportType = '$transportType'");$jumlahDataTransportTypeBaru = mysqli_num_rows($queryExist);

                    if($jumlahDataTransportTypeBaru>0){
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Transport Type Already Exist!
                        </div>    
            <?php
                    } 
                    else{
                        $querySubmit = mysqli_query($con, "INSERT INTO transporttype (transportType) VALUES ('$transportType')");
                        if($querySubmit){
            ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Transport Type Successfully Added!
                            </div>
                            <meta http-equiv="refresh" content="0">                
            <?php
                        }
                        else{
                            echo mysqli_error($con);
                        }
                    }
                    
                }
            ?>
        </div>

        <div class="my-5 col-12 col-md-6">
            <h3>Add Transport</h3>

            <form action="" method="post">
                <div>
                    <label for="transportType">Transport Type</label>
                    <select name="transportType" id="transportType" class="form-control" required>
                        <option value="">Choose Transport Type</option>
                        <?php
                            while($dataType = mysqli_fetch_array($queryTransportType)) {
                        ?>
                            <option value="<?php echo $dataType['idTransportType']?>"><?php echo $dataType['transportType']?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="transportName">Transport Name</label>
                    <input type="text" id="transportName" name="transportName" class="form-control" required>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="submit_transport">Submit</button>
                </div>
            </form>

            <?php
                if(isset($_POST['submit_transport'])){
                    $transportType = htmlspecialchars($_POST['transportType']);
                    $transportName = htmlspecialchars($_POST['transportName']);

                    // Debugging
                    echo "Debug - Transport Type: " . $transportType . "<br>";
                    echo "Debug - Transport Name: " . $transportName . "<br>";

                    if($transportType == '' || $transportName == '') {
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Field is NULL!
                        </div>
            <?php  
                    } else {    
                        $querySubmit = mysqli_query($con, "INSERT INTO transport (idTransportType, transportName) VALUES ('$transportType', '$transportName')"); 
                        if($querySubmit){
            ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Transport Successfully Added!
                            </div>
                            <meta http-equiv="refresh" content="0">                
            <?php
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Error: ' . mysqli_error($con) . '</div>';
                        }
                    }
                }
            ?>
        </div>
    </div>
    
    <div class="container mt-3">
        <h2>Transport Type</h2>
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Transport Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($jumlahTransportType==0){
                    ?>
                        <tr>
                            <td colspan=3 class="text-center">Data Transport Not Found</td>
                        </tr>
                    <?php
                        }
                        else{
                            $jumlah=1;
                            $queryTransportType = mysqli_query($con, "SELECT * FROM transporttype");
                            while($data=mysqli_fetch_array($queryTransportType)){
                    ?>
                                <tr>
                                    <td><?php echo $jumlah;?></td>
                                    <td><?php echo $data['transportType'];?></td>
                                    <td>
                                        <a href="transportType-detail.php?q=<?php echo $data['idTransportType']; ?>" class="btn btn-info">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
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

    <div class="container mt-3">
        <h2>Transport List</h2>
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Transport Name</th>
                        <th>Transport Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($jumlahTransport==0){
                    ?>
                        <tr>
                            <td colspan=2 class="text-center">Data Transport Not Found</td>
                        </tr>
                    <?php
                        }
                        else{
                            $jumlah=1;
                            while($data=mysqli_fetch_array($queryTransport)){
                    ?>
                                <tr>
                                    <td><?php echo $jumlah;?></td>
                                    <td><?php echo $data['transportName'];?></td>
                                    <td><?php echo $data['transportType'];?></td>
                                    <td>
                                    <a href="transport-detail.php?q=<?php echo $data['idTransport']; ?>" class="btn btn-info">
                                        <i class="fas fa-search"></i>
                                    </a>
                                    </td>
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