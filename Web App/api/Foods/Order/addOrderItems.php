<?php
require "../../LoginRegister/DataBase.php";

$db = new DataBase();
if (isset($_POST['f_id']) && isset($_POST['f_qty']) && isset($_POST['o_id'])) {
    if ($db->dbConnect()) {
        if ($db->insertOrderItems($_POST['f_id'], $_POST['f_qty'], $_POST['o_id'])) {
            echo "Order Confirmed";
        } else echo "Failed";
    } else echo "Error: Database connection";
} else echo "All Fields are Required";
?>