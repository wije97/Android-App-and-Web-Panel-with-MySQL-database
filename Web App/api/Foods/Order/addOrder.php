<?php
require "../../LoginRegister/DataBase.php";

$db = new DataBase();
if (isset($_POST['cus_id']) && isset($_POST['o_total']) && isset($_POST['date'])) {
    if ($db->dbConnect()) {
        $lastID = $db->insertOrder($_POST['cus_id'], $_POST['o_total'], $_POST['date']);
        if ($lastID != 0) {
            echo $lastID;
        } else echo "Failed";
    } else echo "Error: Database connection";
} else echo "All Fields are Required";
?>