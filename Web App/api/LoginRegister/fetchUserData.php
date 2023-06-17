<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['email'])) {
    if ($db->dbConnect()) {
        $id = $db->fetchUserData( $_POST['email']);
            echo $id;
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>