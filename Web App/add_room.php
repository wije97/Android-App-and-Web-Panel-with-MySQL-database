
<?php
include_Once('./config.php');

    if(isset($_POST['submit'])){

        $roomnum = $_POST['roomnum'];
        $roomFloor = $_POST['roomFloor'];
        $guestperroom = $_POST['guestperroom'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $insert ="INSERT INTO `tbl_room` (roomNumber,roomFloor,oneDayprice,guestPerRom,description) VALUES ('$roomnum','$roomFloor','$price','$guestperroom','$description')";

            $query = mysqli_query($con, $insert) or die(mysqli_error($con));
            if($query == 1){        
                    echo '<script>alert("Room Added !")</script>';
                    header("Location:../Soumi _Villa/add_room.php");
            }
            else{
                echo '<script>alert("Room Not Added !")</script>';
            }

        mysqli_close($con);
    }
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
		<nav class="navbar navbar-expand-lg navbar-dark $orange-500 bg-dark">
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>
  		<img class="ml-3" src="img/logo.png" alt="Generic placeholder image" width="3%"
  						height="3%">
  		<a class="navbar-brand" href="admin_dashboard.php" id="main_name">&nbsp;&nbsp;<i><b>Prasad Suomi Villa</b></i></a>
  		<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    			<ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    		<form class="form-inline my-2 my-lg-0">
      			<button class="btn btn-primary my-2 my-sm-0" type="submit"><a href="admin_dashboard.php">Back</a></button>
      			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    		</form>
  		</div>
	</nav>

	<div class="container">
    <div class="row py-5 mt-4 align-items-center">
        <!-- For Demo Purpose -->
        <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
            <img src="img/add_room.jpg" alt="" class="img-fluid mb-3 d-none d-md-block">
            </p>
        </div>

        <!-- Registeration Form -->
        <div class="col-md-7 col-lg-6 ml-auto">
            <h1 class="text-center">Add Rooms</h1><br>
            <form action="#" method="POST">
                <div class="row">

                    <!-- Room Number -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="roonum" type="text" name="roomnum" placeholder="Room Number" class="form-control bg-white border-left-0 border-md">
                    </div>
                    <!-- Room Floor -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="roomFloor" type="text" name="roomFloor" placeholder="Room Floor" class="form-control bg-white border-left-0 border-md">
                    </div>
                    <!-- Guest Per Room -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="guestperroom" type="text" name="guestperroom" placeholder="Guest Per Room" class="form-control bg-white border-left-0 border-md">
                    </div>
                    <!-- Description-->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="description" type="text" name="description" placeholder="Description" class="form-control bg-white border-left-0 border-md">
                    </div>
                    <!-- Price -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="email" type="text" name="price" placeholder="Price" class="form-control bg-white border-left-0 border-md">
                    </div>

                    <!-- Add Button -->
                    <div class="form-group col-lg-12 mx-auto mb-0">
                        <input type="submit" name="submit" class="btn btn-primary btn-block py-2" value="Add Room">
                    </div>  
                </div>
            </form>
        </div>
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