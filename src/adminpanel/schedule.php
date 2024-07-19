<?php
    require "session.php";
    require "../php/connect.php";

    $query = mysqli_query($con, "SELECT s.*, t.transportName AS transportName, r.Origin AS origin, r.Destination AS destination FROM schedule s NATURAL JOIN route r NATURAL JOIN transport t");
    $jumlahSchedule = mysqli_num_rows($query);

    $queryRoute=mysqli_query($con, "SELECT * FROM route");
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
        form div{
            margin-bottom = 10px;
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
                    Route
                </li>
            </ol>
        </nav>
        
        <div class="my-5 col-12 col-md-6">
            <h3>Add Schedule</h3>

            <form action="" method="post">
                <div>
                    <label for="routeName">Route Name</label>
                    <select name="routeName" id="routeName" class="form-control" required>
                        <option value="">Choose Route Name</option>
                        <?php
                            while($data = mysqli_fetch_array($queryRoute)) {
                        ?>
                            <option value="<?php echo $data['idRoute']?>"><?php echo $data['routeName']?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="scheduleName">Schedule Name</label>
                    <input type="text" id="scheduleName" name="scheduleName" class="form-control" required>
                </div>
                <div>
                    <label for="depatureDate">Depature Time</label>
                    <input type="datetime-local" id="depatureDate" name="depatureDate" class="form-control" required>
                </div>
                <div>
                    <label for="arrivalDate">Arrival Time</label>
                    <input type="datetime-local" id="arrivalDate" name="arrivalDate" class="form-control" required>
                </div>
                <div>
                    <label for="stock">Stock Ticket</label>
                    <input type="number" id="stock" name="stock" class="form-control" required>
                </div>
                <div>
                    <label for="price">Price Ticket</label>
                    <input type="number" id="price" name="price" class="form-control" required>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="submit_schedule">Submit</button>
                </div>
            </form>

            <?php
                if(isset($_POST['submit_schedule'])){
                    $routeName = htmlspecialchars($_POST['routeName']);
                    $scheduleName = htmlspecialchars($_POST['scheduleName']);
                    $depatureDate = htmlspecialchars($_POST['depatureDate']);
                    $arrivalDate = htmlspecialchars($_POST['arrivalDate']);
                    $stock = htmlspecialchars($_POST['stock']);
                    $price = htmlspecialchars($_POST['price']);

                    if($routeName == '' || $scheduleName=='' || $depatureDate=='' ||  $arrivalDate=='' || $stock=='' || $price=='') {
                ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Field is NULL!
                        </div>
                <?php  
                    }
                    else{
                        $querySubmit = mysqli_query($con, "INSERT INTO schedule (idRoute, scheduleName, stock, depatureDate, arrivalDate, price) VALUES ('$routeName', '$scheduleName' , '$stock','$depatureDate', '$arrivalDate', '$price')");
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

        <div class="mt-3">
            <h2>Schedule List</h2>
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Schedule Name</th>
                            <th>Transport Name</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Depature Time</th>
                            <th>Arrival Time</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($jumlahSchedule==0){
                        ?>
                            <tr>
                                <td colspan=9 class="text-center">Data Schedule Not Found</td>
                            </tr>    
                        <?php
                            }
                            else{
                                $jumlah = 1;
                                while($data=mysqli_fetch_array($query)){
                        ?>
                                <tr>
                                    <td><?php echo $jumlah?></td>
                                    <td><?php echo $data['scheduleName']?></td>
                                    <td><?php echo $data['transportName']?></td>
                                    <td><?php echo $data['origin']?></td>
                                    <td><?php echo $data['destination']?></td>
                                    <td><?php echo $data['depatureDate']?></td>
                                    <td><?php echo $data['arrivalDate']?></td>
                                    <td><?php echo $data['stock']?></td>
                                    <td><?php echo $data['price']?></td>
                                    <td>
                                        <a href="schedule-detail.php?q=<?php echo $data['idSchedule']; ?>" class="btn btn-info">
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