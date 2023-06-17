<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "dbhotel";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if(isset($_REQUEST['cus_id'])){

        $cus_id = $_REQUEST['cus_id'];
        $ftype = array();

        $sql = "SELECT tbl_cart.cart_id, tbl_food.f_name,  tbl_food.Price, tbl_cart.f_qty, tbl_food.Image, tbl_cart.f_id FROM tbl_cart INNER JOIN tbl_food ON tbl_cart.f_id=tbl_food.f_id WHERE tbl_cart.cus_id='" . $cus_id . "';";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($cid, $name, $price, $qty, $image, $fid);

        while($stmt->fetch()){
         $temp = [
            'cid'=>$cid,
            'name'=>$name,
            'price'=>$price,
            'qty'=>$qty,
            'image'=>$image,
            'fid'=>$fid
         ];

         array_push($ftype, $temp);
        }

        echo json_encode($ftype);
    }else{
        echo "All Fields are Required";
    }

?>