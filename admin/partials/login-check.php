<?php
//authorization or access control
//check wheather user is logged in or not

if (!isset($_SESSION["user"])) {
    //means user session is not set
    //redirect to login page with message
    $_SESSION["no-login-msg"] = "<div class='error text-center'>Please Login First to Access Admin Panel </div>";
    //redirect to login page
    header("location:" . SITEURL . "admin/login.php");
}
