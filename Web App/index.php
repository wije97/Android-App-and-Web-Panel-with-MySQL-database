<?php
include_Once('./config.php');

session_start();
$totalRooms = 0;

if(empty($_SESSION)){
	$logtype = "visiter";
}else{
	$logtype = $_SESSION["usertype"];
}

$sql1 = "SELECT * FROM tbl_food";
$result1 = mysqli_query($con, $sql1) or die( mysqli_error($con));
$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);


if(isset($_POST['submit'])){

$currentDate = $_POST['checkin'];
$roomqty = $_POST['roomsqty'];


$sql1 = "SELECT COUNT(*) as count FROM tbl_room";
  $result1 = mysqli_query($con, $sql1) or die( mysqli_error($con));
  $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);  
  $availableRooms= $row1["count"]; 
	//echo $availableRooms;


 $sql = "SELECT *  FROM tbl_booking ";

  if ($result = mysqli_query($con,$sql)) {
    while ($row = $result->fetch_assoc()) {

      $checkin = $row["checkin"];
      $checkout = $row["checkout"];
      $rooms = $row["rqty"];

		 $currentDate = date('Y-m-d', strtotime($currentDate));
			$startDate = date('Y-m-d', strtotime($checkin));
			$endDate = date('Y-m-d', strtotime($checkout));
							   
			if (($currentDate >= $startDate) && ($currentDate <= $endDate)){
				$totalRooms += $rooms;
			}
    }
    //echo $totalRooms;   
          }
    $currentAvailableRoom = $availableRooms - $totalRooms;
    if($currentAvailableRoom >= $roomqty){
    if($logtype != "user"){
			header("Location:../Soumi _Villa/login.php");
    }else{
      header("Location:../Soumi _Villa/add_booking.php");
    }
          	
    }else{
      echo '<script>alert("Sorry! No Rooms Available !")</script>';
    }
}

if(isset($_POST['logout'])){

	session_destroy();
	echo '<script>alert("Log Out !");
        window.location.href = "login.php";</script>';
  }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<link rel="stylesheet" type="text/js" href="js/custom.js">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-dark $orange-500">
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>
  		<img class="ml-3" src="img/logo.png" alt="Generic placeholder image" width="3%"
  						height="3%">

<?php if($logtype != "user") {?> 
  		<a class="navbar-brand" href="index.php" id="main_name">&nbsp;&nbsp;<i><b>Prasad Suomi Villa</b></i></a>
  		<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    			<ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    		<form class="form-inline my-2 my-lg-0">
      			<button class="btn btn-primary my-2 my-sm-0" type="submit" onclick="login.php"><a href="login.php">LOGIN</a></button>
      			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    		</form>
  		</div>
<?php }else {  ?>
  		<a class="navbar-brand" href="index.php" id="main_name">&nbsp;&nbsp;<i><b>Prasad Suomi Villa</b></i></a>
  			<div class="collapse navbar-collapse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      		<ul class="navbar-nav">
        		<li class="nav-item">
          		<a class="nav-link text-light" href="view_booking.php"> My Bookings</a>
        		</li>
        		<li class="nav-item">
          		<a class="nav-link text-light" href="view_orders.php">My Orders</a>
        		</li>
      		</ul>
    	</div>

  		<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    			<ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    		<form class="form-inline my-2 my-lg-0">
    				<button class="btn btn-primary my-2 my-sm-0" type="submit" onclick="cart.php"><a href="cart.php">Cart</a></button>
      			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></form>
      	<form class="form-inline my-2 my-lg-0" action="" method="POST">	
      			<button class="btn btn-primary my-2 my-sm-0" type="submit" name="logout" id="logout" value="Log Out">Logout</button>
      			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    		</form>
  		</div>

  	<?php } ?>
	</nav>


	<div class="header">
		
		<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="col-md-7 col-md-push-5">
						<div class="booking-cta">
							<h1>EMBRACE THE <br>HERITAGE</h1>
							<p>Thank you for choosing us as your preferred holiday partner.
							</p>
						</div>
					</div>
					<div class="col-md-4 col-md-pull-7">
						<div class="booking-form">
							<form action="" method="POST">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<span class="form-label">Check In</span>
											<input class="form-control" type="date" id="checkin" name="checkin" required>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<span class="form-label">Check out</span>
											<input class="form-control" type="date" id="checkout" name="checkout" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<span class="form-label">Rooms</span>
											<select class="form-control" id="roomsqty" name="roomsqty">
												<option>1</option>
												<option>2</option>
												<option>3</option>
											</select>
											<span class="select-arrow"></span>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<span class="form-label">Adults</span>
											<select class="form-control">
												<option>1</option>
												<option>2</option>
												<option>3</option>
											</select>
											<span class="select-arrow"></span>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<span class="form-label">Children</span>
											<select class="form-control">
												<option>0</option>
												<option>1</option>
												<option>2</option>
											</select>
											<span class="select-arrow"></span>
										</div>
									</div>
								</div>
								<div class="form-btn">
									<input class="submit-btn" type="submit" name="submit" value="Check Availability">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="" id="food_menu_one">
		<div class="container-fluid">
			<p>
				<br><br><br><br><br><br>
			</p>
		</div>
	</div>

	<br><br>

	<div class="container">
		<h2 class="text-center">TODAY SPECIAL</h2>
  		<div class="col">
      		<ul class="list-group">
      			<h4>&nbsp;&nbsp;&nbsp;Breakfast</h4>
  				<li class="list-group-item">
  					<div class="">
  						<div class="row">
  							<?php
  								 $sql = "SELECT * FROM tbl_food WHERE Type='breakfast' ";

					          if ($result = mysqli_query($con,$sql)) {
					            while ($row = $result->fetch_assoc()) {
					              
					              $food_name = $row["f_name"];
					              $food_type = $row["Type"];
					              $price = $row["Price"];
					              $details = $row["Details"];
					              $image = $row["Image"];
					              $foodid = $row["f_id"];

					              echo'
				    						<div class="col-4">
				      							<div class="card" style="width: 18rem;">
				  									<img src="data:image/jpg;base64,'.$image.'" class="card-img-top" alt="..." width="286px" height="188px">
				  										<div class="card-body">
				    										<h5 class="card-title">'.$food_name.'</h5>
				    										<p class="card-text">Rs.'.$price.'</p>
				    										<form action="" method = "POST">
				    										<table>
									  							<tr>
									  								<td><label>Quantity</label></td>
									  								<td><input type="number" style="width: 40px; margin-left: 70px;" id = "foodqty" name="foodqty" min = "1" value="1"></td>
									  							</tr>
									  						</table>
									  						<input type="hidden" name="foodid" value="'. $foodid.'"/>

				    										<input type=submit class="btn btn-primary" name="addtocart" id="addtocart" value="Add to Cart">
				    										</form>
				  										</div>
														</div>
				    						</div>
				    						';
				    					}
				    				}
    							?>
  						</div>

					</div>
  				</li>
	  		</ul>
    	</div>

    	<br>

    	<div class="col">
      		<ul class="list-group">
      			<h4>&nbsp;&nbsp;&nbsp;Lunch</h4>
  				<li class="list-group-item">
  					<div class="">
    						<div class="row">
  							<?php
  								 $sql = "SELECT * FROM tbl_food WHERE Type='lunch' ";

					          if ($result = mysqli_query($con,$sql)) {
					            while ($row = $result->fetch_assoc()) {
					              
					              $food_name = $row["f_name"];
					              $food_type = $row["Type"];
					              $price = $row["Price"];
					              $details = $row["Details"];
					              $image = $row["Image"];
					              $foodid = $row["f_id"];

					              echo'
				    						<div class="col-4">
				      							<div class="card" style="width: 18rem;">
				  									<img src="data:image/jpg;base64,'.$image.'" class="card-img-top" alt="..." width="286px" height="188px">
				  										<div class="card-body">
				    										<h5 class="card-title">'.$food_name.'</h5>
				    										<p class="card-text">Rs.'.$price.'</p>
				    										<form action="" method = "POST">
				    										<table>
									  							<tr>
									  								<td><label>Quantity</label></td>
									  								<td><input type="number" style="width: 40px; margin-left: 70px;" id = "foodqty" name="foodqty" min = "1" value="1"></td>
									  							</tr>
									  						</table>
									  						<input type="hidden" name="foodid" value="'. $foodid.'"/>

				    										<input type=submit class="btn btn-primary" name="addtocart" id="addtocart" value="Add to Cart">
				    										</form>
				  										</div>
														</div>
				    						</div>
				    						';
				    					}
				    				}
    							?>
  						</div>
					</div>
  				</li>
	  		</ul>
    	</div>

    	<br>

    	<div class="col">
      		<ul class="list-group">
      			<h4>&nbsp;&nbsp;&nbsp;Dinner</h4>
  				<li class="list-group-item">
  					<div class="">
  						<div class="row">
  							<?php
  								 $sql = "SELECT * FROM tbl_food WHERE Type='dinner' ";

					          if ($result = mysqli_query($con,$sql)) {
					            while ($row = $result->fetch_assoc()) {
					              
					              $food_name = $row["f_name"];
					              $food_type = $row["Type"];
					              $price = $row["Price"];
					              $details = $row["Details"];
					              $image = $row["Image"];
					              $foodid = $row["f_id"];

					              echo'
				    						<div class="col-4">
				      							<div class="card" style="width: 18rem;">
				  									<img src="data:image/jpg;base64,'.$image.'" class="card-img-top" alt="..." width="286px" height="200px">
				  										<div class="card-body">
				    										<h5 class="card-title">'.$food_name.'</h5>
				    										<p class="card-text">Rs.'.$price.'</p>
				    										<form action="" method = "POST">
				    										<table>
									  							<tr>
									  								<td><label>Quantity</label></td>
									  								<td><input type="number" style="width: 40px; margin-left: 70px;" id = "foodqty" name="foodqty" min = "1" value="1"></td>
									  							</tr>
									  						</table>
									  						<input type="hidden" name="foodid" value="'. $foodid.'"/>

				    										<input type=submit class="btn btn-primary" name="addtocart" id="addtocart" value="Add to Cart">
				    										</form>
				  										</div>
														</div>
				    						</div>
				    						';
				    					}
				    				}
    							?>
  						</div>
					</div>
  				</li>
	  		</ul>
    	</div>

    	<br>

    	<div class="col">
      		<ul class="list-group">
      			<h4>&nbsp;&nbsp;&nbsp;Decert</h4>
  				<li class="list-group-item">
  					<div class="">
  						<div class="row">
  							<?php
  								 $sql = "SELECT * FROM tbl_food WHERE Type='decert' ";

					          if ($result = mysqli_query($con,$sql)) {
					            while ($row = $result->fetch_assoc()) {
					              
					              $food_name = $row["f_name"];
					              $food_type = $row["Type"];
					              $price = $row["Price"];
					              $details = $row["Details"];
					              $image = $row["Image"];
					              $foodid = $row["f_id"];

					              echo'
				    						<div class="col-4">
				      							<div class="card" style="width: 18rem;">
				  									<img src="data:image/jpg;base64,'.$image.'" class="card-img-top" alt="..." width="286px" height="188px">
				  										<div class="card-body">
				    										<h5 class="card-title">'.$food_name.'</h5>
				    										<p class="card-text">Rs.'.$price.'</p>
				    										<form action="" method = "POST">
				    										<table>
									  							<tr>
									  								<td><label>Quantity</label></td>
									  								<td><input type="number" style="width: 40px; margin-left: 70px;" id = "foodqty" name="foodqty" min = "1" value="1"></td>
									  							</tr>
									  						</table>
									  						<input type="hidden" name="foodid" value="'. $foodid.'"/>

				    										<input type=submit class="btn btn-primary" name="addtocart" id="addtocart" value="Add to Cart">
				    										</form>
				  										</div>
														</div>
				    						</div>
				    						';
				    					}
				    				}
    							?>
  						</div>
					</div>
  				</li>
	  		</ul>
    	</div></div>


<?php 

		if(isset($_POST['addtocart'])){

				if($logtype != "user"){ 
					echo '<script type="text/javascript">
					window.location.href = "login.php";</script>';
				}else {
					$foodid = $_POST['foodid'];

					$pQuantity = $_POST['foodqty'];
					$cus_id = $_SESSION["cus_id"];
				

					$insert1="INSERT INTO `tbl_cart` (`cus_id`, `f_id`, `f_qty`) VALUES ('$cus_id','$foodid','$pQuantity')";

					$query = mysqli_query($con, $insert1) or die(mysqli_error($con));
					if($query == 1){	
						echo '<script>alert("Add to Cart Successful!")</script>';
					}
					else{
						echo '<script>alert("Add to Cart Unsuccessful !")</script>';
					}

			        mysqli_close($con);	
				}
				
			}
?>
    	<br>

		
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