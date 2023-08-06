<?php
include "partials/menu.php";
?>


<div class="main-content">
    <div class="wrapper text-center">
        <h1>Update admin</h1>
        <br><br>
        <?php

        //get the id of the admin to be updated
        $id = $_GET["id"];

        //get the details of the admin by its id to display in the input fields
        $sql = "select * from tbl_admin where id=$id";

        $res = mysqli_query($con, $sql);

        if ($res) {
            //query executed successfully
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_array($res);
                $fullname = $row["fullname"];
                $username = $row["username"];
                $password = $row["password"];
        ?>
                <form action="" method="POST">
                    <div class="field-3">
                        <label for="full name" class="lbl">Full name :</label>
                        <input type="text" name="full_name" placeholder="Enter your name" value="<?php echo $fullname ?>" required>
                        <br>
                    </div>
                    <div class="field-3">
                        <label for="full name" class="lbl">Username :</label>
                        <input type="text" name="username" placeholder="Username" value="<?php echo $username ?>" required>
                        <br>
                    </div>
                    <br>
                    <div>
                        <input type="submit" class="btn-add" name="update" value="UPDATE">
                    </div>
                </form>
        <?php

            } else {
                header("location:" . SITEURL . "admin/manage-admin.php");
            }
        }

        ?>


    </div>
</div>

<?php
include "partials/footer.php";
?>

<?php

//process the value from the form and save it to the database

//check wheather update button is clicked or not
if (isset($_POST["update"])) {
    //button clicked

    //1.get data from the form

    $full_name = mysqli_real_escape_string($con, $_POST["full_name"]);
    $username = mysqli_real_escape_string($con, $_POST["username"]);

    //2.sql query to update data into the database from form
    $update_sql = "update tbl_admin set fullname='$full_name',username='$username' where id=$id";

    //3.Execute query and save data into database

    $res = mysqli_query($con, $update_sql) or die(mysqli_error($con));

    //check wheather the data is updated or not
    if ($res) {
        //create session variable to display msg on update
        $_SESSION["update"] = "<div class='success'>Admin data Updated Successfully</div>";
        //redirect page to manage admin
        header("location:" . SITEURL . "admin/manage-admin.php");
    } else {
        $_SESSION["update"] = "<div class='error'>Failed to update Admin data</div>";
        header("location:" . SITEURL . "admin/manage-admin.php");
    }
}
?>