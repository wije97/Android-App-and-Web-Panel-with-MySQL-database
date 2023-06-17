 <?php
require "DataBaseConfig.php";

    class DataBase
    {
        public $connect;
        public $data;
        private $sql;
        protected $servername;
        protected $username;
        protected $password;
        protected $databasename;

        public function __construct()
        {
            $this->connect = null;
            $this->data = null;
            $this->sql = null;
            $dbc = new DataBaseConfig();
            $this->servername = $dbc->servername;
            $this->username = $dbc->username;
            $this->password = $dbc->password;
            $this->databasename = $dbc->databasename;
        }

        function dbConnect()
        {
            $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
            return $this->connect;
        }

        function prepareData($data)
        {
            return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
        }

        function logIn($email, $password)
        {
            $email = $this->prepareData($email);
            $password = $this->prepareData($password);
            $this->sql = "SELECT * FROM tbl_customer WHERE Email = '" . $email . "'";
            $result = mysqli_query($this->connect, $this->sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) != 0) {
                $dbemail = $row['Email'];
                $dbpassword = $row['Password'];
                if ($dbemail == $email && $dbpassword == $password) {
                    $login = true;
                } else $login = false;
            } else $login = false;

            return $login;
        }

        function fetchUserData($email)
        {
            $email = $this->prepareData($email);
            $this->sql = "SELECT c_id FROM tbl_customer WHERE Email= '" . $email . "'";
            $result = mysqli_query($this->connect, $this->sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) != 0) {
                $id = $row['c_id'];
            } 
            return $id;
        }

        function signUp($fullname, $nic, $age, $address, $phone_no, $email,  $password)
        {
            $nic = $this->prepareData($nic);
            $fullname = $this->prepareData($fullname);
            $password = $this->prepareData($password);
            $email = $this->prepareData($email);
            $phone_no = $this->prepareData($phone_no);
            $address = $this->prepareData($address);
            $password = $this->prepareData($password);
            $this->sql =
                "INSERT INTO tbl_customer (`Cname`, `NIC`, `Age`, `Address`, `Phone`, `Email`, `Password`) VALUES 
                ('" . $fullname . "', '" . $nic . "', '" . $age . "', '" . $address . "', '" . $phone_no . "', '" . $email . "', '" . $password . "')";

            if (mysqli_query($this->connect, $this->sql)) {
                return true;
            } else return false;
        }

        
        function insertToCart($cus_id, $f_id, $f_qty)
        {
            $cus_id = $this->prepareData($cus_id);
            $f_id = $this->prepareData($f_id);
            $f_qty = $this->prepareData($f_qty);
            $this->sql =
                "INSERT INTO tbl_cart (cus_id, f_id, f_qty) VALUES 
                ('" . $cus_id . "', '" . $f_id . "', '" . $f_qty . "')";

            if (mysqli_query($this->connect, $this->sql)) {
                return true;
            } else return false;
        }

        function deletefromCart($c_id)
        {
            $c_id = $this->prepareData($c_id);
           
            $this->sql =
                "DELETE FROM tbl_cart WHERE cart_id = '$c_id'";

            if (mysqli_query($this->connect, $this->sql)) {
                return true;
            } else return false;
        }

        function insertOrder($cus_id, $total, $date)
        {
            $cus_id = $this->prepareData($cus_id);
            $total = $this->prepareData($total);
            $date = $this->prepareData($date);
            $this->sql =
                "INSERT INTO `tbl_order`(`cus_id`, `o_total`, `o_date`, `o_status`) VALUES 
                ('" . $cus_id . "', '" . $total . "', '" . $date . "', 'Pending')";

            if (mysqli_query($this->connect, $this->sql)) {
                $last_id = $this->connect->insert_id;
                return $last_id;
            } else return 0;
        }

        function insertOrderItems($f_id, $f_qty, $o_id)
        {
            $f_id = $this->prepareData($f_id);
            $f_qty = $this->prepareData($f_qty);
            $o_id = $this->prepareData($o_id);
            $this->sql =
                "INSERT INTO `tbl_order_n_food`(`f_id`, `f_qty`, `o_id`) VALUES 
                ('" . $f_id . "', '" . $f_qty . "', '" . $o_id . "')";

            if (mysqli_query($this->connect, $this->sql)) {
                return true;
            } else return false;
        }

        function deletefromCartByUser($cus_id)
        {
            $cus_id = $this->prepareData($cus_id);
           
            $this->sql =
                "DELETE FROM tbl_cart WHERE cus_id = '$cus_id'";

            if (mysqli_query($this->connect, $this->sql)) {
                return true;
            } else return false;
        }

        function deleteOrder($o_id)
        {
            $o_id = $this->prepareData($o_id);
           
            $this->sql = "DELETE FROM tbl_order WHERE o_id = '$o_id'";

            if (mysqli_query($this->connect, $this->sql)) {

                $this->sql = "DELETE FROM tbl_order_n_food WHERE o_id = '$o_id'";
                if (mysqli_query($this->connect, $this->sql)){
                    return true;
                }
            } else return false;
        }

        function updateUser($cus_id, $fullname, $nic, $age, $address, $phone_no, $email)
        {
            $cus_id = $this->prepareData($cus_id);
            $nic = $this->prepareData($nic);
            $fullname = $this->prepareData($fullname);
            $age = $this->prepareData($age);
            $email = $this->prepareData($email);
            $phone_no = $this->prepareData($phone_no);
            $address = $this->prepareData($address);
            $this->sql =
                "UPDATE `tbl_customer` SET `Cname`='$fullname',`NIC`='$nic',`Age`='$age',`Address`='$address',`Phone`='$phone_no',`Email`='$email' WHERE c_id='" . $cus_id .  "'";

            if (mysqli_query($this->connect, $this->sql)) {
                return true;
            } else return false;
        }
        
    }

?>
