<?php
include "partials/menu.php";
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br><br>
        <?php
        if (isset($_SESSION["add"])) {
            echo $_SESSION["add"];
            unset($_SESSION["add"]);
        }
        if (isset($_SESSION["delete"])) {
            echo $_SESSION["delete"];
            unset($_SESSION["delete"]);
        }
        if (isset($_SESSION["remove"])) {
            echo $_SESSION["remove"];
            unset($_SESSION["remove"]);
        }
        if (isset($_SESSION["no-food-found"])) {
            echo $_SESSION["no-food-found"];
            unset($_SESSION["no-food-found"]);
        }
        if (isset($_SESSION["update_food"])) {
            echo $_SESSION["update_food"];
            unset($_SESSION["update_food"]);
        }
        if (isset($_SESSION["remove-failed"])) {
            echo $_SESSION["remove-failed"];
            unset($_SESSION["remove-failed"]);
        }
        if (isset($_SESSION["upload-failed"])) {
            echo $_SESSION["upload-failed"];
            unset($_SESSION["upload-failed"]);
        }
        ?>
        <br><br>
        <!-- Button to add Food -->
        <a href="<?php echo SITEURL . "admin/add-food.php" ?>" class="btn-primary">Add Food</a>
        <br><br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "select * from tbl_food";

            $res = mysqli_query($con, $sql);

            if ($res) {
                //query exectuted no error
                //check food data is available or not

                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    //food available
                    $sn = 1;
                    while ($row = mysqli_fetch_array($res)) {
                        $id = $row["id"];
                        $title = $row["title"];
                        $description = $row["description"];
                        $price = $row["price"];
                        $image_name = $row["image_name"];
                        $category_id = $row["category_id"];
                        $featured = $row["featured"];
                        $active = $row["active"];

            ?>
                        <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $title ?></td>
                            <td><?php echo $price ?></td>
                            <td>
                                <img src="<?php echo SITEURL . '/images/food/' . $image_name ?>" alt="Not Found" width="100px">
                            </td>
                            <td><?php echo $featured ?></td>
                            <td><?php echo $active ?></td>
                            <td>
                                <a href="<?php echo SITEURL . 'admin/update-food.php?id=' . $id ?>" class="btn-secondary">Update </a>
                                <a href="<?php echo SITEURL . 'admin/delete-food.php?id=' . $id . "&image_name=" . $image_name ?>" class="btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    //no food available

                    ?>
                    <tr>
                        <td colspan="7"><?php echo "<div class='error text-center'>No Food Available</div>" ?></td>
                    </tr>
            <?php
                }
            }

            ?>



        </table>

    </div>
</div>

<?php
include "partials/footer.php";
?>