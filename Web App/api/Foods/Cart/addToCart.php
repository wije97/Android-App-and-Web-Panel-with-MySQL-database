<?php
require "../../LoginRegister/DataBase.php";

$db = new DataBase();
if (isset($_POST['cus_id']) && isset($_POST['f_id']) && isset($_POST['f_qty'])) {
    if ($db->dbConnect()) {
        if ($db->insertToCart($_POST['cus_id'], $_POST['f_id'], $_POST['f_qty'])) {
            echo "Successfully Added to Cart";
        } else echo "Failed";
    } else echo "Error: Database connection";
} else echo "All Fields are Required";
?>