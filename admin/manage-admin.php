<?php
include "partials/menu.php";
?>

<!-- Main Content section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>

        <?php
        if (isset($_SESSION["add"])) {
            echo $_SESSION["add"];
            //removing session message
            unset($_SESSION["add"]);
        }
        if (isset($_SESSION["delete"])) {
            echo $_SESSION["delete"];
            //removing session message
            unset($_SESSION["delete"]);
        }
        if (isset($_SESSION["update"])) {
            echo $_SESSION["update"];
            //removing session message
            unset($_SESSION["update"]);
        }
        if (isset($_SESSION["user_not_found"])) {
            echo $_SESSION["user_not_found"];
            //removing session message
            unset($_SESSION["user_not_found"]);
        }
        if (isset($_SESSION["pwd_changed"])) {
            echo $_SESSION["pwd_changed"];
            //removing session message
            unset($_SESSION["pwd_changed"]);
        }
        ?>

        <br><br><br>
        <!-- Button to add Admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br><br><br>
        <table class="tbl-full">
            <?php
            //sql to get all admins from the db
            $get_admins_query = "select * from tbl_admin";
            $res = mysqli_query($con, $get_admins_query);
            if ($res == true) {
                // query executed successfully
                if (mysqli_num_rows($res) == 0) {
                    //we don't have data in db
                    echo "No data found";
                } else {
                    //we have data in db

            ?>
                    <tr>
                        <th>S.N</th>
                        <th>Full name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $sn = 1; //create a variable to displat sn number in table
                    while ($row = mysqli_fetch_array($res)) {
                        $id = $row["id"];
                        $fname = $row["fullname"];
                        $uname = $row["username"];
                    ?>
                        <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $fname ?></td>
                            <td><?php echo $uname ?></td>
                            <td colspan="3">
                                <a href="<?php echo SITEURL . "admin/update-password.php?id=$id" ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL . "admin/update-admin.php?id=$id" ?>" class="btn-secondary">Update</a>
                                <a href="<?php echo SITEURL . "admin/delete-admin.php?id=$id" ?>" class="btn-danger">Delete</a>
                            </td>
                        </tr>
            <?php
                    }
                }
            }


            ?>

        </table>
    </div>
</div>
<!-- Main Content section ends -->

<?php
include "partials/footer.php";
?>