<?php
  include_Once('./config.php');

  session_start();

  if(isset($_POST['vieworder'])){
      $_SESSION["orderid"] = $_POST['orderid'];
    echo '<script type="text/javascript">
    window.location.href = "vieworderdetails.php";</script>';

      
    }
  if(isset($_POST['cancel'])){ 
    $orderid = $_POST['orderid'];

    $sql1 = "UPDATE tbl_order SET o_status = 'Cancel' WHERE o_id = '$orderid'";

    $query = mysqli_query($con, $sql1) or die(mysqli_error($sql1));
    if($query == 1){        
      echo '<script>alert("Order Cancel !")</script>';
      $delay = 0;
      header("Refresh: $delay;"); 
      }
  }

  if(isset($_POST['bcancel'])){ 
    $bookingid = $_POST['bookingid'];

    $sql2 = "UPDATE tbl_booking SET Status = 'Cancel' WHERE rid = '$bookingid'";

    $query2 = mysqli_query($con, $sql2) or die(mysqli_error($sql2));
    if($query2 == 1){        
      echo '<script>alert("Order Cancel !")</script>';
      $delay = 0;
      header("Refresh: $delay;"); 
      }
  }
  if(isset($_POST['bapprove'])){ 
       $bookingid = $_POST['bookingid'];
      $sql3 = "UPDATE tbl_booking SET Status = 'Approved' WHERE rid = '$bookingid'";

      $query3 = mysqli_query($con, $sql3) or die(mysqli_error($sql3));
      if($query3 == 1){        
        echo '<script>alert("Order Approved !")';
        $delay = 0;
        header("Refresh: $delay;"); 
      }
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
	<nav class="navbar navbar-expand-lg navbar-light $orange-500 bg-dark">
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>
  		<img class="ml-3" src="img/logo.png" alt="Generic placeholder image" width="3%"
  						height="3%">
  		<a class="navbar-brand" href="index.php" id="main_name">&nbsp;&nbsp;<i><b>Prasad Suomi Villa</b></i></a>
  		<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    			<ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    		<form class="form-inline my-2 my-lg-0">
            <button class="btn btn-primary my-2 my-sm-0" type="submit"><a href="admin_view_food.php">View Food</a></button>
            <p>&nbsp;</p>
      			<button class="btn btn-primary my-2 my-sm-0" type="submit"><a href="add_food.php">Add Food</a></button>
            <p>&nbsp;</p>
            <button class="btn btn-primary my-2 my-sm-0" type="submit"><a href="add_room.php">Add Room</a></button>
            <p>&nbsp;</p>
            <button class="btn btn-primary my-2 my-sm-0" type="Logout"><a href="login.php">Log Out</a></button>
      			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    		</form>
  		</div>
	</nav>

  <!-- adimin control -->
  <div class="container">

    <!-- Food -->
    <div class="row">
      <div class="col">
        <div class="list-group-item">
        <h4>All Orders</h4>
        <table class="table">
          <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Order ID</th>
                <th scope="col">Total</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
          </thead>
          <tbody>
             <?php
               // if ($usertype == "admin") {

                   $sql = "SELECT  tbl_order.* FROM tbl_order";

                      if ($result = mysqli_query($con,$sql)) {
                        while ($row = $result->fetch_assoc()) {
                          
                          $orderid = $row["o_id"];
                          $total = $row["o_total"];
                          $order_Date = $row["o_date"];
                          $status = $row["o_status"];

                          echo '<tr scope="row">
                            <td> </td>
                            <td>'.$orderid.'</td>
                            <td>'.$total.'</td>
                            <td>'.$order_Date.'</td> 
                            <td>'.$status.'</td>
                            <td>
                            <form action="" method="POST"><input type="submit" id="vieworder" name="vieworder" class="btn btn-warning my-2 my-sm-0" value="View">
                            <input type= "hidden" name="orderid" value="'.$orderid.'"></form></td>
                            <td>
                            <form action="" method="POST"><input type="submit" id="cancel" name="cancel" class="btn btn-danger my-2 my-sm-0" value="Cancel">
                            <input type= "hidden" name="orderid" value="'.$orderid.'"></form></td>
                          </tr>';
                        }
                        
                      }
                  echo '</tbody></table></div>';
                //}
              ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
<br>
    <!-- Room -->
    <div class="row">
      <div class="col">
      <div class="list-group-item">
        <h4>All Booking</h4>
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
            <?php

                //if ($usertype == "admin") {
                      $sql2 = "SELECT  tbl_booking.*, tbl_customer.* FROM tbl_booking INNER JOIN tbl_customer ON tbl_booking.nic = tbl_customer.NIC";

                      if ($result1 = mysqli_query($con,$sql2)) {
                        while ($row = $result1->fetch_assoc()) {
                          
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

                            <td>
                            <td>
                            <form action="" method="POST"><input type="submit" id="bapprove" name="bapprove" class="btn btn-success my-2 my-sm-0" value="Approve">
                            <input type= "hidden" name="bookingid" value="'.$rid.'"></form></td>
                            <td>
                            <form action="" method="POST"><input type="submit" id="bcancel" name="bcancel" class="btn btn-danger my-2 my-sm-0" value="Cancel">
                            <input type= "hidden" name="bookingid" value="'.$rid.'"></form></td>
                              </div>
                            </td>
                          </tr>';
                        }
                        
                      }
                  echo '</tbody></table></div>';
                //}
              ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>

	<br><br>

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