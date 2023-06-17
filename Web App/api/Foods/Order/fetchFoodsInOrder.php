<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "dbhotel";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if(isset($_REQUEST['o_id'])){

        $o_id = $_REQUEST['o_id'];
        $ftype = array();

        $sql = "SELECT tbl_order_n_food.o_item_id, tbl_food.f_name,  tbl_food.Price, tbl_order_n_food.f_qty, tbl_food.Image, tbl_order_n_food.f_id FROM tbl_order_n_food INNER JOIN tbl_food ON tbl_order_n_food.f_id=tbl_food.f_id WHERE tbl_order_n_food.o_id='" . $o_id . "';";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($o_item_id, $name, $price, $qty, $image, $fid);

        while($stmt->fetch()){
         $temp = [
            'o_item_id'=>$o_item_id,
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