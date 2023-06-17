<?php
require "../../LoginRegister/DataBase.php";

$db = new DataBase();
if (isset($_POST['o_id'])) {
    if ($db->dbConnect()) {
        if ($db->deleteOrder($_POST['o_id'])) {
            echo "Order Removed";
        } else echo "Failed";
    } else echo "Error: Database connection";
} else echo "All Fields are Required";
?>