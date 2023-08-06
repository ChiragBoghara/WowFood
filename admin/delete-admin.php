<?php
//include constant.php file to use $con
include "../config/constants.php";

// //get the id of the admin to be deleted
$id = $_GET["id"];

//delete query
$delete_query = "delete from tbl_admin where id=$id";

$res = mysqli_query($con, $delete_query);

if ($res) {
    //query executed
    $_SESSION["delete"] = "<div class='success'>Admin Deleted Successfully</div>";
    //redirect to manage admin page
    header("location:" . SITEURL . "admin/manage-admin.php");
} else {
    //failed 
    $_SESSION["delete"] = "<div class='error'>Failed to Delete the Admin. Try again Later</div>";
    header("location:" . SITEURL . "admin/manage-admin.php");
}
