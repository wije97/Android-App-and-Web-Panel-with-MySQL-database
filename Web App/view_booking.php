<?php
  include_Once('./config.php');

  session_start();
  $cus_id = $_SESSION["cus_id"];
  $usertype = $_SESSION['usertype'];

  $sql1 = "SELECT * FROM tbl_customer WHERE c_id ='$cus_id'";
  $result1 = mysqli_query($con, $sql1) or die( mysqli_error($con));
  $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);  
  $fname= $row1["Cname"]; 
  $nic= $row1["NIC"];

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
<body id="">
	<nav class="navbar fixed-top navbar-expand-lg navbar-light $orange-500 bg-Secondary">
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>
  		<img class="ml-3" src="img/logo.png" alt="Generic placeholder image" width="3%"
  						height="3%">
  		<a class="navbar-brand" href="index.php">&nbsp;&nbsp;<i><b>Prasad Suomi Villa</b></i></a>
  		<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    			<ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    		<form class="form-inline my-2 my-lg-0" action="index.php">
                <button class="btn btn-primary my-2 my-sm-0" type="text" onclick="">Back</button>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    		</form>
  		</div>
	</nav>

    <br><br><br>



<div class="container-fluid">
    <div class="list-group-item">
  <div class="row">
    <div class="col">
      <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Booking ID</th>
      <th scope="col">Room Type</th>
      <th scope="col">Checkin</th>
      <th scope="col">Checkout</th>
      <th scope="col">Rooms</th>
      <th scope="col">Guest</th>
      <th scope="col">Price</th>
      <th scope="col">Status</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
<?php

    if ($usertype == "user") {

          $sql = "SELECT  tbl_booking.*, tbl_customer.* FROM tbl_booking INNER JOIN tbl_customer ON tbl_booking.nic = tbl_customer.NIC WHERE tbl_booking.nic = '$nic'";

          if ($result = mysqli_query($con,$sql)) {
            while ($row = $result->fetch_assoc()) {
              
              $rid = $row["rid"];
              $rtype = $row["rtype"];
              $checkin = $row["checkin"];
              $checkout = $row["checkout"];
              $rooms = $row["rqty"];
              $guest = $row["guest"];
              $price = $row["price"];
              $status = $row["Status"];

              echo '<tr scope="row">
                <td> </td>
                <td>'.$rid.'</td>
                <td>'.$rtype.'</td> 
                <td>'.$checkin.'</td>
                <td>'.$checkout.'</td>
                <td>'.$rooms.'</td> 
                <td>'.$guest.'</td>
                <td>'.$price.'</td>
                <td>'.$status.'</td>

              </tr>';
            }
            
          }
      echo '</tbody></table></div>';
    }
    mysqli_close($con);
  ?>
</table>
    </div>
  </div>
  </div>
</div>

<br><br><br>
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