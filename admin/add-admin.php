<?php
include "partials/menu.php";
?>

<div class="main-content">
    <div class="wrapper text-center">
        <h1>Add admin</h1>
        <br><br>
        <form action="" method="POST">
            <?php
            if (isset($_SESSION["add"])) {
                echo $_SESSION["add"];
                //removing session message
                unset($_SESSION["add"]);
            }
            ?>
            <div class="field-3">
                <label for="full name" class="lbl">Full name :</label>
                <input type="text" name="full_name" placeholder="Enter your name" required>
                <br>
            </div>
            <div class="field-3">
                <label for="full name" class="lbl">Username :</label>
                <input type="text" name="username" placeholder="Username" required>
                <br>
            </div>
            <div class="field-3">
                <label for="full name" class="lbl">Password :</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <br>
            <div>
                <input type="submit" class="btn-add" name="add" value="ADD">
            </div>
        </form>
    </div>
</div>

<?php
include "partials/footer.php";
?>

<?php

//process the value from the form and save it to the database

//check wheather add button is clicked or not
if (isset($_POST["add"])) {
    //button clicked

    //1.get data from the form

    $full_name = mysqli_real_escape_string($con, $_POST["full_name"]);
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);

    $encPass = password_hash($password, PASSWORD_BCRYPT);

    //2.sql query to insert data into the database from form
    $insert_sql = "insert into tbl_admin(fullname,username,password) values('$full_name','$username','$encPass')";

    //3.Execute query and save data into database

    $res = mysqli_query($con, $insert_sql) or die(mysqli_error($con));

    //check wheather the data is inserted or not
    if ($res) {
        //create session variable to display msg on insertion
        $_SESSION["add"] = "<div class='success'>Admin Added Successfully</div>";
        //redirect page to manage admin
        header("location:" . SITEURL . "admin/manage-admin.php");
    } else {
        //redirect page to add admin
        $_SESSION["add"] = "<div class='error'>Failed to Add Admin</div>";
        header("location:" . SITEURL . "admin/add-admin.php");
    }
}
?>