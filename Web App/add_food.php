<?php
include_Once('./config.php');

    if(isset($_POST['submit'])){

        $fcatogary = $_POST['foodCatogery'];
        $fname = $_POST['foodname'];
        $price = $_POST['price'];
        $details = $_POST['details'];

        $filename = $_FILES["formFile"]["name"];

        $tempname = $_FILES["formFile"]["tmp_name"];   
        $folder = "uploads/".$filename;

        $image_base64 = base64_encode(file_get_contents($_FILES['formFile']['tmp_name']) );

        $insert ="INSERT INTO `tbl_food` (f_name,Type,Price,Details,Image) VALUES ('$fname','$fcatogary','$price','$details','$image_base64')";
        $query = mysqli_query($con, $insert) or die(mysqli_error($con));
        if($query == 1){   
            if (move_uploaded_file($tempname, $folder))  {
                echo '<script> alert ("Data inserted") </script>';

            }else{
                echo '<script> alert ("Data Not inserted") </script>';
            }     

            
        }
        else{
            echo '<script>alert("Registration Unsuccessful !")</script>';
        }
    }
    mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" type="text/js" href="js/custom.js">
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-light $orange-500 bg-Secondary">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <img class="ml-3" src="img/logo.png" alt="Generic placeholder image" width="3%"
                        height="3%">
        <a class="navbar-brand" href="index.php">&nbsp;&nbsp;<i><b>Prasad Suomi Villa</b></i></a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
            <form class="form-inline my-2 my-lg-0" action="" method="POST" enctype="multipart/form-data">
                <button class="btn btn-primary my-2 my-sm-0" type="button" name="back"><a href="admin_dashboard.php">Back</a></button>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        </div>
    </nav>
    <div class="container">
    <div class="row py-5 mt-4 align-items-center">
        <!-- For Demo Purpose -->
        <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
            <img src="img/food_add.png" alt="" class="img-fluid mb-3 d-none d-md-block">
            </p>
        </div>

        <!-- Registeration Form -->
        <div class="col-md-7 col-lg-6 ml-auto">
            <h1 class="text-center">Add Foods</h1><br>
                <div class="row">
                    <!-- Food Name -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="foodname" type="text" name="foodname" placeholder="Food Name" class="form-control bg-white border-left-0 border-md" required="">
                    </div>

                    <!-- cetogery -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-black-tie text-muted"></i>
                            </span>
                        </div>
                        <select id="foodCatogery" name="foodCatogery" class="form-control custom-select bg-white border-left-0 border-md">
                            <option value="disabled">Choose Food Catogery</option>
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="dinner">Dinner</option>
                            <option value="decert">Decert</option>
                        </select>
                    </div>

                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="price" type="text" name="price" placeholder="Price" class="form-control bg-white border-left-0 border-md" required="">
                    </div>

                    <!-- Price -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="details" type="text" name="details" placeholder="Details" class="form-control bg-white border-left-0 border-md" required="">
                    </div>

                    <!-- Add img -->
                    <div class="input-group col-lg-12 mb-4">
                        <label for="formFile" class="form-label"></label>
                        <input class="form-control" type="file" id="formFile" name="formFile" >
                    </div>

                    <!-- Add Button -->
                    <div class="form-group col-lg-12 mx-auto mb-0">
                            <input type="submit" name="submit" class="btn btn-primary btn-block py-2" value="Add Food">
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>

<footer class="footer-20192">
      <div class="site-section">
        <div class="container">
          <div class="row">
            <div class="col-sm">
              <a href="#" class="footer-logo">SUOMI VILLA</a>
              <p class="copyright">
                <small>&copy; 2021</small>
              </p>
            </div>
            <div class="col-sm">
              <h3>Customers</h3>
              <ul class="list-unstyled links">
                <li><a href="#">APPETIZERS</a></li>
                <li><a href="#">accommodation</a></li>
              </ul>
            </div>
            <div class="col-sm">
              <h3>Company</h3>
              <ul class="list-unstyled links">
                <li><a href="#">About us</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Contact us</a></li>
              </ul>
            </div>
            <div class="col-sm">
              <h3>Further Information</h3>
              <ul class="list-unstyled links">
                <li><a href="#">Terms &amp; Conditions</a></li>
                <li><a href="#">Privacy Policy</a></li>
              </ul>
            </div>
            <div class="col-md-3">
              <h3>Follow us</h3>
              <ul class="list-unstyled social">
                <li><a href="#"><span class="icon-facebook"></span></a></li>
                <li><a href="#"><span class="icon-twitter"></span></a></li>
                <li><a href="#"><span class="icon-linkedin"></span></a></li>
                <li><a href="#"><span class="icon-medium"></span></a></li>
                <li><a href="#"><span class="icon-paper-plane"></span></a></li>
              </ul>
            </div>
            
          </div>
        </div>
      </div>
    </footer>
</body>
</html>