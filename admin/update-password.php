<?php
include "partials/menu.php";
?>

<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
?>
<div class="main-content">
    <div class="wrapper text-center">
        <h1>Change Password</h1>
        <br><br>
        <?php
        if (isset($_SESSION["pwd_not_match"])) {
            echo $_SESSION["pwd_not_match"];
            unset($_SESSION["pwd_not_match"]);
        }
        ?>
        <br><br>
        <form action="" method="POST">
            <div class="field-3">
                <label for="full name" class="lbl">Current Password :</label>
                <input type="password" name="c_password" placeholder="Current password" required>
                <br>
            </div>
            <div class="field-3">
                <label for="new password" class="lbl">New Password :</label>
                <input type="password" name="n_password" placeholder="New password" required>
                <br>
            </div>
            <div class="field-3">
                <label for="confirm password" class="lbl">Confirm Password :</label>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <br>
            </div>
            <br>
            <div>
                <input type="submit" class="btn-add" name="update" value="UPDATE PASSWORD">
            </div>
        </form>

    </div>
</div>

<?php
include "partials/footer.php";
?>

<?php
if (isset($_POST["update"])) {
    $current_password = mysqli_real_escape_string($con, password_hash($_POST["c_password"], PASSWORD_BCRYPT));
    $new_password = mysqli_real_escape_string($con, $_POST["n_password"]);
    $confirm_password = mysqli_real_escape_string($con, $_POST["confirm_password"]);

    //check wheather user with current id and password exist or not

    $sql = "select * from tbl_admin where id=$id";
    $res = mysqli_query($con, $sql);

    if ($res) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            //echo "found";
            $res = mysqli_fetch_array($res);

            if (password_verify($_POST["c_password"], $res["password"])) {
                echo "Varified";
                // admin exists and password can be changed
                // check wheather new and confirm password are matched or not
                if ($new_password === $confirm_password) {
                    $enc_new_pass = password_hash($new_password, PASSWORD_BCRYPT);
                    //everything is okay
                    //execute query to update password
                    $update_pwd_sql = "update tbl_admin set password='$enc_new_pass' where id=$id";
                    $res = mysqli_query($con, $update_pwd_sql);
                    if ($res) {
                        $_SESSION["pwd_changed"] = "<div class='success'>Password updated successfully</div>";
                        header("location:" . SITEURL . "admin/manage-admin.php");
                    } else {
                        $_SESSION["pwd_changed"] = "<div class='error'>Password is not updated</div>";
                        header("location:" . SITEURL . "admin/manage-admin.php");
                    }
                } else {
                    $_SESSION["pwd_not_match"] = "<div class='error'>Password are not matching</div>";
                    header("location:" . SITEURL . "admin/update-password.php");
                }
            } else {
                //user id not varified id and current password are not same
                $_SESSION["user_not_found"] = "<div class='error'>User not found</div>";
                header("location:" . SITEURL . "admin/manage-admin.php");
            }
        } else {
            //admin does not exists and password can't be changed
            $_SESSION["user_not_found"] = "<div class='error'>User not found</div>";
            header("location:" . SITEURL . "admin/manage-admin.php");
        }
    }
}
?>