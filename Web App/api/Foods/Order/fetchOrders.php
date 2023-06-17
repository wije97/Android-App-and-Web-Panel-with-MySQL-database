<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "dbhotel";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if(isset($_REQUEST['cus_id']) && isset($_REQUEST['status'])){

        $cus_id = $_REQUEST['cus_id'];
        $status = $_REQUEST['status'];
        $orders = array();

        if ($status == "") {
            $sql = "SELECT o_id, o_total, o_date, o_status FROM tbl_order WHERE cus_id = '" . $cus_id . "';";
        }else{
            $sql = "SELECT o_id, o_total, o_date, o_status FROM tbl_order WHERE cus_id = '" . $cus_id . "' AND o_status = '" . $status . "';";
        }


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($oid, $ototal, $odate, $ostatus);

        while($stmt->fetch()){
         $temp = [
            'oid'=>$oid,
            'ototal'=>$ototal,
            'odate'=>$odate,
            'ostatus'=>$ostatus
         ];

         array_push($orders, $temp);
        }

        echo json_encode($orders);
    }else{
        echo "All Fields are Required";
    }

?>