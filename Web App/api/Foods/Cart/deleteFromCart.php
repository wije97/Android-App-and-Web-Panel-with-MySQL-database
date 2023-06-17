<?php
require "../../LoginRegister/DataBase.php";

$db = new DataBase();
if (isset($_POST['c_id'])) {
    if ($db->dbConnect()) {
        if ($db->deletefromCart($_POST['c_id'])) {
            echo "Removed from Cart";
        } else echo "Failed";
    } else echo "Error: Database connection";
} else echo "All Fields are Required";
?>