<?php
include "../config/constants.php";
//check wheather the id and image_name value is set or not

//we can use and or $$
if (isset($_GET["id"]) and isset($_GET["image_name"])) {
    //get value and delete
    $id = $_GET["id"];
    $image_name = $_GET["image_name"];

    //first check iamge given id and name is available in database or not
    //because hacker/user can enter any id and image name in url to harm our database

    $query = "select * from tbl_food where id=$id and image_name='$image_name'";

    $res = mysqli_query($con, $query);

    $count = mysqli_num_rows($res);

    if ($count == 1) {
        //food available
        //now delete

        if ($image_name != "") {
            //image is available so delete
            $path = "../images/food/" . $image_name;
            //after getting the path of the image we can delete it

            //unlink function deletes the file from given path and returns true if deleted else false
            $remove = unlink($path);

            if ($remove == false) {
                //deletion failed

                //set the session message
                $_SESSION["remove"] = "<div class='error'>Failed to Remove Food Image</div>";
                //redirect to manage category page
                header("location:" . SITEURL . "admin/manage-food.php");
                //stop the process
                die();
            }
        }

        //delete data from the database

        //delete query
        $sql = "delete from tbl_food where id=$id";

        $res = mysqli_query($con, $sql);

        if ($res == true) {
            //query executed (deleted)
            //set success session message and redirect
            $_SESSION["delete"] = "<div class='success'>Food Deleted Successfully</div>";

            //redirect to manage category page
            header("location:" . SITEURL . "admin/manage-food.php");
        } else {
            //execution failed
            //set error session message and redirect
            $_SESSION["delete"] = "<div class='error'>Failed to delete Food</div>";

            //redirect to manage category page
            header("location:" . SITEURL . "admin/manage-food.php");
        }
    } else {
        //user is trying to delete the food with wrong id or image_name
        //redirect to manage_category page
        header("location:" . SITEURL . "admin/manage-food.php");
    }
} else {
    //user is trying to request the url without id and username
    //redirect to manage_food page
    header("location:" . SITEURL . "admin/manage-food.php");
}
