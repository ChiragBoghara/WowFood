<?php include "partials/menu.php"; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br><br>
        <?php
        if (isset($_SESSION["add"])) {
            echo $_SESSION["add"];
            unset($_SESSION["add"]);
        }
        if (isset($_SESSION["remove"])) {
            echo $_SESSION["remove"];
            unset($_SESSION["remove"]);
        }
        if (isset($_SESSION["delete"])) {
            echo $_SESSION["delete"];
            unset($_SESSION["delete"]);
        }
        if (isset($_SESSION["no-category-found"])) {
            echo $_SESSION["no-category-found"];
            unset($_SESSION["no-category-found"]);
        }
        if (isset($_SESSION["update_cat"])) {
            echo $_SESSION["update_cat"];
            unset($_SESSION["update_cat"]);
        }
        if (isset($_SESSION["upload"])) {
            echo $_SESSION["upload"];
            unset($_SESSION["upload"]);
        }
        ?>
        <br><br>
        <!-- Button to add category -->
        <a href="<?php echo SITEURL . "admin/add-category.php" ?>" class="btn-primary">Add Category</a>
        <br><br><br>
        <div style="overflow-x:auto;">
            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php
                //query get categories from db
                $sql = "select * from tbl_category";

                $res = mysqli_query($con, $sql);

                if ($res == true) {
                    //query executed successfully
                    $count = mysqli_num_rows($res);
                    if ($count > 0) {
                        //records found
                        $sn = 1;
                        while ($row = mysqli_fetch_array($res)) {
                ?>
                            <tr>
                                <td><?php echo $sn++ ?></td>
                                <td><?php echo $row["title"] ?></td>
                                <td>
                                    <!-- check wheather image is available or not -->
                                    <?php
                                    if ($row["image_name"] != "") {
                                        //display the image
                                    ?>
                                        <img src="<?php echo SITEURL . "/images/category/" . $row["image_name"] ?>" alt="Not Found" width="100px">
                                    <?php
                                    } else {
                                        //display the message
                                        echo "<div class='error'>Image not available</div>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row["featured"] ?></td>
                                <td><?php echo $row["active"] ?></td>
                                <td>
                                    <a href="<?php echo SITEURL . "admin/update-category.php?id=" . $row['id'] ?>" class="btn-secondary">
                                        Update
                                    </a>
                                    <a href="<?php echo SITEURL . "admin/delete-category.php?id=" . $row['id'] . "&image_name=" . $row["image_name"] ?>" class="btn-danger">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        //records not found
                        //we will display data in the table
                        ?>
                        <tr>
                            <td colspan="6">
                                <div class="error text-center">No Category Added.
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    //failed
                }

                ?>

            </table>
        </div>
    </div>
</div>

<?php include "partials/footer.php"; ?>