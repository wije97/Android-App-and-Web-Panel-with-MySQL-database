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
        $user = array();


         $sql = "SELECT Cname, NIC, Age, Address, Phone, Email FROM tbl_customer WHERE c_id = '" . $cus_id . "';";



        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($name, $nic, $age, $address, $phone, $email);

        while($stmt->fetch()){
         $temp = [
            'name'=>$name,
            'nic'=>$nic,
            'age'=>$age,
            'address'=>$address,
            'phone'=>$phone,
            'email'=>$email
         ];

         array_push($user, $temp);
        }

        echo json_encode($user);
    }else{
        echo "All Fields are Required";
    }

?>