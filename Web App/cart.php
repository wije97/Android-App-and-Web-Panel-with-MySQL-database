<?php
  include_Once('./config.php');
  $subTotal = 0.0;
  session_start();
  $cus_id =  $_SESSION["cus_id"];
  $usertype = $_SESSION['usertype'];

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
                <button class="btn btn-primary my-2 my-sm-0" type="submit" onclick="">Back</button>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        </form>
      </div>
  </nav>

    <br><br><br>



<div class="container-fluid">
    <div class="list-group-item">
  <div class="row">
    <div class="col">
  
<?php

      $sql = "SELECT  tbl_cart.*, tbl_food.* FROM tbl_cart INNER JOIN tbl_food ON tbl_cart.f_id = tbl_food.f_id WHERE tbl_cart.cus_id = '$cus_id'";

      if ($result = mysqli_query($con,$sql)) {
        if(mysqli_num_rows($result)>0){

          echo '<table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Food Name</th>
                  <th scope="col">Food Quantity</th>
                  <th scope="col">Unit Price</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>';

          while ($row = $result->fetch_assoc()) {
            
            $fname = $row["f_name"];
            $cartID = $row["cart_id"];
            $fqty = $row["f_qty"];
            $fprice = $row["Price"];

            $total = $fqty * $fprice;
            $subTotal += $total;

            echo '<tr scope="row">
              <td> </td>
              <td>'.$fname.'</td>
              <td>'.$fqty.'</td> 
              <td>'.$fprice.'</td>
              <td><form action="" method="POST"><input type="submit" id="remove" name="remove" class="btn btn-danger my-2 my-sm-0" value="Remove">
                  <input type= "hidden" name="cID" value="'.$cartID.'"></form></td>
              <td></td>
            </tr>';
          }

          ?>

            <table align="right" style="margin-top: 50px; margin-right: 280px;">
              <tr>
                <th>
                    <label for="from">Total:</label>
                </th>
                <th style="width: 500px; text-align:right">
                  
                    <h1  name="total" readonly=""> <b><?php echo "Rs: " . $subTotal;  ?></b></h1>
                  
                </th>
              </tr>
              </table>
              <table align="right" style="margin-top: 50px; margin-right: 280px;">
              <tr>
                
                <th style="width: 550px">
                  
                    <form action="" method="POST">
                     <input type="submit" class="btn btn-success btn-block" name ="place_order" value="Place Order">
                   </form>
                
                </th>
              </tr>
            </table>

          <?php

        }
        else{
           echo "<br><h3 align='center'>No Items in Your Cart</h3>";
        echo "</br></br></br></br></br>";
        }
         

      }else{
         echo '</tbody></table></div>';
       
      }

      


        if(isset($_POST['remove'])){
          //echo '<script>alert("Login Successful !")</script>';
          $key = $_POST['cID'];
          $delete = mysqli_query($con,"DELETE FROM `tbl_cart` WHERE cart_id = '$key'") or die("Action not successful".mysql_error());

          echo "<meta http-equiv='refresh' content='0'>";
        }


        if (isset($_POST['place_order'])) {

          $date= date("Y-m-d");

          $insert1="INSERT INTO `tbl_order`(`cus_id`, `o_total`, `o_date`, `o_status`) VALUES ('$cus_id','$subTotal','$date', 'Pending')";

          $query = mysqli_query($con, $insert1) or die(mysqli_error($con));
          if($query == 1){
            $last_id = $con->insert_id; 
            
            $sql = "SELECT * FROM tbl_cart WHERE cus_id = '$cus_id' ";
            if ($result = mysqli_query($con,$sql)) {
              while ($row = $result->fetch_assoc()) {
                $fID = $row["f_id"];
                $fQTY = $row["f_qty"];

                $insert2="INSERT INTO `tbl_order_n_food`(`f_id`, `f_qty`, `o_id`) VALUES ('$fID','$fQTY','$last_id')";
                $query = mysqli_query($con, $insert2) or die(mysqli_error($con));
                if($query != 1){
                  echo '<script>alert("Order Confirmation Falied!")</script>';
                }
              }

              $delete = mysqli_query($con,"DELETE FROM `tbl_cart` WHERE cus_id = '$cus_id'") or die("Action not successful".mysql_error());

              echo '<script>alert("Order Confirmed!")</script>';
              echo "<meta http-equiv='refresh' content='0'>";
            }
          }
          else{
            echo '<script>alert("Order Confirmation Falied!")</script>';
          }
            
        }

        mysqli_close($con);

  ?>

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