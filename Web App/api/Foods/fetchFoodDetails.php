<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "dbhotel";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if(isset($_REQUEST['columnData'])){

        $type = $_REQUEST['columnData'];

        if ($type == "") {
            $sql = "SELECT f_id, f_name, Type, Price, Image FROM tbl_food;";
        }else{
            $sql = "SELECT f_id, f_name, Type, Price, Image FROM tbl_food WHERE Type='" . $type . "';";
        }
        $ftype = array();


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $name, $type, $price, $image);

        while($stmt->fetch()){
         $temp = [
            'id'=>$id,
            'name'=>$name,
            'type'=>$type,
            'price'=>$price,
            'image'=>$image
         ];

         array_push($ftype, $temp);
        }

        echo json_encode($ftype);
    }else{
        echo "All Fields are Required";
    }

?>