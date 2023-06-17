<?php
include_Once('./config.php');

$sql1 = "SELECT * FROM tbl_food";
$result1 = mysqli_query($con, $sql1) or die( mysqli_error($con));
$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
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
<body id="food_bckgndlgn">
	<nav class="navbar navbar-expand-lg navbar-light bg-dark $orange-500">
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>
  		<img class="ml-3" src="img/logo.png" alt="Generic placeholder image" width="3%"
  						height="3%">
  		<a class="navbar-brand" href="index.php" id="main_name">&nbsp;&nbsp;<i><b>Prasad Suomi Villa</b></i></a>
  			<div class="collapse navbar-collapse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    	</div>

  		<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    			<ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    		<form class="form-inline my-2 my-lg-0">
      			<button class="btn btn-primary my-2 my-sm-0" type="submit" onclick="admin_dashboard.php"><a href="admin_dashboard.php">Back</a></button>
      			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    		</form>
  		</div>
	</nav>

	<div class="header_food">
		

	<div class="container ">
		<h2 class="text-center">&nbsp;</h2>
  		<div class="col food_tble">
      		<ul class="list-group">   			
  				<li class="list-group-item">
  					<h4>&nbsp;&nbsp;&nbsp;Breakfast</h4>
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
									  						<input type="hidden" name="foodid" value="'. $foodid.'"/>
				    										<input type=submit class="btn btn-danger" name="deletefood" id="deletefood" value="Delete">
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
  				<li class="list-group-item">
  					<h4>&nbsp;&nbsp;&nbsp;Lunch</h4>
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
									  						<input type="hidden" name="foodid" value="'. $foodid.'"/>
				    										<input type=submit class="btn btn-danger" name="deletefood" id="deletefood" value="Delete">
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
  				<li class="list-group-item">
  					<h4>&nbsp;&nbsp;&nbsp;Dinner</h4>
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
									  						<input type="hidden" name="foodid" value="'. $foodid.'"/>
				    										<input type=submit class="btn btn-danger" name="deletefood" id="deletefood" value="Delete">
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
  				<li class="list-group-item">
  					<h4>&nbsp;&nbsp;&nbsp;Decert</h4>
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
									  						<input type="hidden" name="foodid" value="'. $foodid.'"/>
				    										<input type=submit class="btn btn-danger" name="deletefood" id="deletefood" value="Delete">
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
    	if(isset($_POST['deletefood'])){
    		$foodid = $_POST['foodid'];

    		$delete = mysqli_query($con,"DELETE FROM `tbl_food` WHERE f_id = '$foodid'") or die("Action not successful".mysql_error());
    		echo '<script>alert("Successful Deleted !")</script>';
    		echo "<meta http-equiv='refresh' content='0'>";
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