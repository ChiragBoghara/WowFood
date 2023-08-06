<?php
include "../config/constants.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body style="background-color: #ff6b81;">
    <section class="admin-login">
        <div class="login-card">
            <div class="text-center">
                <img src="../images/logo.png" alt="Logo">
            </div>
            <br>
            <div class="text-center">
                <h1 class="title">Login</h1>
                <br>
            </div>

            <?php
            if (isset($_SESSION["login"])) {
                echo $_SESSION["login"];
                unset($_SESSION["login"]);
            }
            if (isset($_SESSION["no-login-msg"])) {
                echo $_SESSION["no-login-msg"];
                unset($_SESSION["no-login-msg"]);
            }
            ?>


            <div class="text-center">
                <!-- Login form starts here -->
                <form action="" method="post">
                    <br>
                    <div>
                        <h4 class="subtitle">Username</h4>
                        <input type="text" name="username" id="username" placeholder="Enter username" required>
                    </div>
                    <br><br>

                    <div>
                        <h4 class="subtitle">Password</h4>
                        <input type="password" name="password" id="password" placeholder="Enter password" required>
                    </div>
                    <br><br>

                    <input type="submit" name="login" value="Login" class="btn-login">
                    <br>
                    <br><br>
                </form>
                <!-- Login form ends here -->
            </div>

            <div>
                <p class="text-center">Created By <a href="">Chirag Boghara</a></p>
                <br>
            </div>

        </div>
    </section>
</body>


<?php
//check wheather login button is clicked or not
if (isset($_POST["login"])) {
    //get values from form field
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);

    $sql = "select * from tbl_admin where username='$username'";

    $res = mysqli_query($con, $sql);

    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $row = mysqli_fetch_array($res);
        //user exists with entered username 
        if (password_verify($password, $row["password"])) {
            //password is correct
            $_SESSION["login"] = "<div class='success'>Login Successful</div>";
            // redirect to home page(dashboard)
            $_SESSION["user"] = $row["username"]; //to check wheather user is logged in or not and logout will unsets it
            header("location:" . SITEURL . "admin/index.php");
        } else {
            //password is incorrect
            $_SESSION["login"] = "<div class='error text-center'>Login failed Incorrect Password</div>";
            // redirect to home page(dashboard)
            header("location:" . SITEURL . "admin/login.php");
        }
    } else {
        $_SESSION["login"] = "<div class='error text-center'>Admin does not exists</div>";
        header("location:" . SITEURL . "admin/login.php");
    }
}
?>

</html>