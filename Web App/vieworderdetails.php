<?php
  include_Once('./config.php');

  session_start();
  $usertype = $_SESSION['usertype'];

  $cus_id=  $_SESSION['cus_id'];
 $order_id=  $_SESSION['orderid'];

  if(isset($_POST['approve'])){ 

    $sql1 = "UPDATE tbl_order SET o_status = 'Approved' WHERE o_id = '$order_id'";

    $query = mysqli_query($con, $sql1) or die(mysqli_error($sql1));
            if($query == 1){        
              echo '<script>alert("Order Approved !");
               window.location.href = "admin_dashboard.php";</script>';
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
        <form class="form-inline my-2 my-lg-0" <?php if ($usertype != "user") { ?> action="admin_dashboard.php" <?php }else { ?> action="view_orders.php" <?php } ?>>
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
                <th scope="col">Order ID</th>
                <th scope="col">Item Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit Price</th>
                <th scope="col">
                  <?php
                  if ($usertype == "admin") {
                              
                      echo'<form action="" method="POST">
                      <input type="submit" class="btn btn-success btn-block" id="approve" name ="approve" value="Approve">
                      </form>';
                    }
                  ?>
                </th>
              </tr>
            </thead>
            <tbody>
<?php
               // if ($usertype == "admin") {

                    $sql = "SELECT  tbl_order_n_food.*, tbl_food.* FROM tbl_order_n_food INNER JOIN tbl_food ON tbl_order_n_food.f_id=tbl_food.f_id WHERE tbl_order_n_food.o_id = '$order_id'";

                      if ($result = mysqli_query($con,$sql)) {
                        while ($row = $result->fetch_assoc()) {
                          
                          $orderid = $row["o_id"];
                          $food_name = $row["f_name"];
                          $food_qty = $row["f_qty"];
                          $price = $row["Price"];

                          echo '<tr scope="row">
                            <td> </td>
                            <td>'.$orderid.'</td>
                            <td>'.$food_name.'</td>
                            <td>'.$food_qty.'</td> 
                            <td>'.$price.'</td>
                          </tr>';
                        }
                        
                      }
                  echo '</tbody></table></div>';
                //}
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