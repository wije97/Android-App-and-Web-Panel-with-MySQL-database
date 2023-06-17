<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "dbhotel";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if(isset($_REQUEST['f_id'])){

        $f_id = $_REQUEST['f_id'];

        $sql = "SELECT f_name, Type, Price, Details, Image FROM tbl_food WHERE f_id='" . $f_id . "';";

        $ftype = array();

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($name, $type, $price, $details, $image);

        while($stmt->fetch()){
         $temp = [
            'name'=>$name,
            'type'=>$type,
            'price'=>$price,
            'details'=>$details,
            'image'=>$image
         ];

         array_push($ftype, $temp);
        }

        echo json_encode($ftype);
    }else{
        echo "All Fields are Required";
    }

?>