<?php
    require "src/userpanel/session.php";
    require "src/php/connect.php";

    $queryOrigin=mysqli_query($con, "SELECT DISTINCT Origin FROM route");
    $queryDestination=mysqli_query($con, "SELECT DISTINCT Destination FROM route");
    


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
        .typeButton{
            width: 75px;
            height: 75px;
            border: solid 3px;
        }
    
        .input-data {
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: opacity 1s ease, max-height 1s ease;
        }

        .input-data.show {
            opacity: 1;
            max-height: 500px;
        }
        .carousel-item {
            padding: 20px;
        }
        .blur{
            background: rgba(255, 255, 255, 0.2); 
            backdrop-filter: blur(10px); 
        }

    </style>
</head>
<body>
    <div class="fixed-top">
        <?php require "src/userpanel/navbar.php";?>
    </div>

    <div class="banner container-fluid d-flex align-items-center">
        <div class="container text-center text-white">
            <h1 class="mb-3">Mau Kemana Kita?</h1>
            <div class="col-md-10 offset-md-1">
                <form action="search.php" method="POST">
                    <div class="my-5 d-flex justify-content-evenly">
                        <input type="checkbox" value="Bus" class="btn-check" name="options" id="option1" autocomplete="off">
                        <label class="typeButton btn btn-outline-success rounded-circle d-flex justify-content-center" for="option1"><img src="src\assets\images\TypeB.svg"></label>
                        <input type="checkbox" value="Pesawat" class="btn-check" name="options" id="option2" autocomplete="off" >
                        <label class="typeButton btn btn-outline-success rounded-circle d-flex justify-content-center" for="option2"><img src="src\assets\images\TypeP.svg"></label>
                        <input type="checkbox" value="Kereta" class="btn-check" name="options" id="option3" autocomplete="off" >
                        <label class="typeButton btn btn-outline-success rounded-circle d-flex justify-content-center" for="option3"><img src="src\assets\images\TypeT.svg"></label>
                    </div>
                    
                    <div class="my-3 container input-data">
                        <div class="row mb-5">
                            <div class="col-6 mb-3">
                                <div class="form-floating">
                                    <select name="origin" id="origin" class="form-control" required>
                                        <option value="">Choose Origin</option>
                                        <?php
                                            while($datao = mysqli_fetch_array($queryOrigin)) {
                                        ?>
                                            <option value="<?php echo $datao['Origin']?>"><?php echo $datao['Origin']?></option>
                                        <?php
                                            }
                                        ?>
                                    </select> 
                                    <label for="origin" class="text-body-tertiary">Origin</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="date" id="depatureDate" name="depatureDate" class="form-control"  placeholder="123-45-678" required>
                                    <label for="depatureDate">Tanggal Berangkat</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating ">
                                    <select name="destination" id="destination" class="form-control" required>
                                        <option value="">Choose Destination</option>
                                        <?php
                                            while($datad = mysqli_fetch_array($queryDestination)) {
                                        ?>
                                            <option value="<?php echo $datad['Destination']?>"><?php echo $datad['Destination']?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="destination">Destination</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="date" id="returnDate" name="returnDate" class="form-control">
                                    <label for="returnDate">Tanggal Pulang</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 col-12 mx-auto mb-4">
                            <button href type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <h2><i class="fa-solid fa-city mx-3"></i>Jelajahi Kota di Indonesia</h2>
        <?php require "src/userpanel/city.php";?>
    </div>
    
    <div class="container" >
        <h2><i class="fa-solid fa-mountain-sun mx-3"></i>Rekomendasi Wisata Favorit</h2>
        <?php require "src/userpanel/carousel-travel.php";?>
    </div>
        
    <div class="mt-4">
        <?php require "src/userpanel/card.php";?>
    </div>
    
    <div class="mt-4">
        <?php require "src/userpanel/features.php";?>
    </div>

    <div class="">
        <?php require "src/userpanel/saran.php";?>
    </div>
    
    <div class="container">
        <?php require "src/userpanel/description.php";?>
    </div>

    <div>
        <?php require "src/userpanel/footer.php";?>
    </div>
    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="options"]');
            const inputData = document.querySelector('.input-data');

            function toggleInputData() {
                const isSelected = Array.from(radioButtons).some(radio => radio.checked);
                if (isSelected) {
                    inputData.classList.add('show');
                } else {
                    inputData.classList.remove('show');
                }
            }

            radioButtons.forEach(radio => {
                radio.addEventListener('change', toggleInputData);
            });

            toggleInputData(); // Initial check

            function singleChoice(checkbox) {
                const checkboxes = document.getElementsByName('options');
                
                checkboxes.forEach((item) => {
                    if (item !== checkbox) item.checked = false;
                });
            }
        });

        document.querySelectorAll('input[name="options"]').forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    document.querySelectorAll('input[name="options"]').forEach((item) => {
                        if (item !== this) item.checked = false;
                    });
                }
            });
        });

    </script>
    <!-- Bootstrap JS and dependencies -->
    <script src="bootstrap/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="bootstrap/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome -->
    <script src="fontawesome/js/all.min.js"></script>
    <!-- Custom JS -->
    <script src="src/js/script.js"></script>
</body>
</html>