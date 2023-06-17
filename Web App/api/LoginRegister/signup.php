<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['full_name']) && isset($_POST['nic']) && isset($_POST['age']) && isset($_POST['address']) && isset($_POST['phone_no']) && isset($_POST['email']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        if ($db->signUp($_POST['full_name'], $_POST['nic'], $_POST['age'], $_POST['address'], $_POST['phone_no'], $_POST['email'], $_POST['password'])) {
            echo "Sign Up Success.Please Login Back";
        } else echo "Sign up Failed";
    } else echo "Error: Database connection";
} else echo "All Fields are Required";
?>
