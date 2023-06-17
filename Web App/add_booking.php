<?php
include_Once('./config.php');

    if(isset($_POST['submit'])){

        $rtype = $_POST['roomType'];
        $checkin = $_POST['checkindate'];
        $checkout = $_POST['checkoutdate'];
        $rqty = $_POST['roomsqty'];
        $guest = $_POST['guest'];
        $nic = $_POST['nic'];

        if($rtype == "FullBoard"){
            $price = "5500";
        }elseif($rtype == "HalfBoard"){
            $price = "3500";
        }else{
            $price = "2500";
        }

        $insert ="INSERT INTO `tbl_booking` (rtype,nic,checkin,checkout,rqty,guest,price,Status) VALUES ('$rtype','$nic','$checkin','$checkout','$rqty','$guest','$price','Pending')";
        $query = mysqli_query($con, $insert) or die(mysqli_error($con));
        if($query == 1){   
             
              echo '<script> alert ("Booking Successful") </script>';
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
    		<form class="form-inline my-2 my-lg-0">
      			<button class="btn btn-primary my-2 my-sm-0" type="submit"><a href="index.php">Back</a></button>
      			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    		</form>
  		</div>
	</nav>

	<div class="container">
    <div class="row py-5 mt-4 align-items-center">
        <!-- For Demo Purpose -->
        <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
            <img src="img/booking.jpg" alt="" class="img-fluid mb-3 d-none d-md-block">
            </p>
        </div>

        <!-- Registeration Form -->
        <div class="col-md-7 col-lg-6 ml-auto">
            <h1 class="text-center">Book Your Room</h1><br>
            <form action="" method="POST">
                <div class="row">

                <!-- NIC -->
                <div class="input-group col-lg-12 mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white px-4 border-md border-right-0">
                            <i class="fa fa-envelope text-muted"></i>
                        </span>
                    </div>
                    <input id="nic" type="text" name="nic" placeholder="NIC" class="form-control bg-white border-left-0 border-md">
                </div>
                <!-- Type -->
                <div class="input-group col-lg-12 mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white px-4 border-md border-right-0">
                            <i class="fa fa-black-tie text-muted"></i>
                        </span>
                    </div>
                    <select id="roomType" name="roomType" class="form-control custom-select bg-white border-left-0 border-md">
                        <option value="disabled">Room Type</option>
                        <option value="FullBoard">FB</option>
                        <option value="HalfBoard">HB</option>
                        <option value="BedAndBreakfast">BB</option>
                    </select>
                </div>                    

                    <!-- Chekin Date -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div><label class="form-control bg-white border-left-0 border-md">Check in Date</label>
                        <input id="checkindate" type="Date" name="checkindate" placeholder="Checkin Date" class="form-control bg-white border-left-0 border-md">
                    </div>
                    <!-- ChekOut Date -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div><label class="form-control bg-white border-left-0 border-md">Check out Date</label>
                        <input id="checkoutdate" type="Date" name="checkoutdate" placeholder="Check out Date" class="form-control bg-white border-left-0 border-md">
                    </div>
                    <!-- How many rooms -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="roomsqty" type="text" name="roomsqty" placeholder="How many Rooms" class="form-control bg-white border-left-0 border-md">
                    </div>                    
                    <!-- Guest -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-envelope text-muted"></i>
                            </span>
                        </div>
                        <input id="guest" type="text" name="guest" placeholder="How many Guest" class="form-control bg-white border-left-0 border-md">
                    </div>
                    <!-- Add Button -->
                    <div class="form-group col-lg-12 mx-auto mb-0">
                        <input type="submit" class="btn btn-primary btn-block py-2" name="submit" value="Book">
                        </a>
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