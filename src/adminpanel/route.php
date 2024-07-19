<?php
    require "session.php";
    require "../php/connect.php";

    $query = mysqli_query($con, "SELECT r.*, t.transportName AS transportName FROM route r NATURAL JOIN transport t");
    $jumlahRoute = mysqli_num_rows($query);

    $queryTransport=mysqli_query($con, "SELECT * FROM transport");
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
            <h3>Add Route</h3>

            <form action="" method="post">
                <div>
                    <label for="transporName">Transport Name</label>
                    <select name="transportName" id="transportName" class="form-control" required>
                        <option value="">Choose Transport Name</option>
                        <?php
                            while($data = mysqli_fetch_array($queryTransport)) {
                        ?>
                            <option value="<?php echo $data['idTransport']?>"><?php echo $data['transportName']?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="routeName">Route Name</label>
                    <input type="text" id="routeName" name="routeName" class="form-control" required>
                </div>
                <div>
                    <label for="origin">Origin</label>
                    <input type="text" id="origin" name="origin" class="form-control" required>
                </div>
                <div>
                    <label for="destination">Destination</label>
                    <input type="text" id="destination" name="destination" class="form-control" required>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="submit_route">Submit</button>
                </div>
            </form>

            <?php
                if(isset($_POST['submit_route'])){
                    $transportName = htmlspecialchars($_POST['transportName']);
                    $origin = htmlspecialchars($_POST['origin']);
                    $destination = htmlspecialchars($_POST['destination']);
                    $routeName = htmlspecialchars($_POST['routeName']);

                    if($transportName == '' || $origin=='' || $destination=='' ||  $routeName=='') {
                ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Field is NULL!
                        </div>
                <?php  
                    }
                    else{
                        $querySubmit = mysqli_query($con, "INSERT INTO route (idTransport,routeName, Origin, Destination) VALUES ('$transportName', '$routeName' ,'$origin', '$destination')");
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
            <h2>Route List</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Transport Name</th>
                            <th>Route Name</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($jumlahRoute==0){
                        ?>
                            <tr>
                                <td colspan=6 class="text-center">Data Route Not Found</td>
                            </tr>    
                        <?php
                            }
                            else{
                                $jumlah = 1;
                                while($data=mysqli_fetch_array($query)){
                        ?>
                                <tr>
                                    <td><?php echo $jumlah?></td>
                                    <td><?php echo $data['transportName']?></td>
                                    <td><?php echo $data['routeName']?></td>
                                    <td><?php echo $data['Origin']?></td>
                                    <td><?php echo $data['Destination']?></td>
                                    <td>
                                        <a href="route-detail.php?q=<?php echo $data['idRoute']; ?>" class="btn btn-info">
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