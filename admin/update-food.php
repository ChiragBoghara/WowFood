<?php
include "partials/menu.php";
?>

<div class="main-content">
    <div class="wrapper text-center">
        <h1>Update Food</h1>
        <br><br>
        <?php
        //check wheather the id is set or not
        if (isset($_GET["id"])) {
            //get the id and all the details 
            $id =  $_GET["id"];
            $sql1 = "select * from tbl_food where id=$id";
            $res1 = mysqli_query($con, $sql1);

            if ($res1) {
                //query is executed
                $count = mysqli_num_rows($res1);

                if ($count == 1) {
                    //category is available 
                    //update category now
                    $row =  mysqli_fetch_array($res1);

        ?>
                    <!-- enctype is required to upload file -->
                    <form method="POST" enctype="multipart/form-data">

                        <table class="tbl-40">
                            <tr>
                                <td><label for="title" class="lbl">Title :</label></td>
                                <td>
                                    <input type="text" value="<?php echo $row["title"] ?>" name="title" placeholder="Enter Food title" required>
                                </td>
                            </tr>

                            <tr>
                                <td><label for="description" class="lbl">Description :</label></td>
                                <td>
                                    <textarea name="description" cols="30" rows="5" placeholder="Enter Food description" required><?php echo $row["description"] ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td><label for="price" class="lbl">Price :</label></td>
                                <td>
                                    <input type="number" value="<?php echo $row["price"] ?>" name="price" placeholder="Enter Food price" required>
                                </td>
                            </tr>

                            <tr>
                                <td><label for="current image" class="lbl">Current Image :</label></td>
                                <td>
                                    <img src="<?php echo SITEURL . "images/food/" . $row["image_name"] ?>" width="100px" alt="Image not found">
                                </td>
                            </tr>

                            <tr>
                                <td><label for="image" class="lbl">Select New Image :</label></td>
                                <td>
                                    <input type="file" name="image2">
                                </td>
                            </tr>

                            <tr>
                                <td><label for="image" class="lbl">Category :</label></td>
                                <td>
                                    <select name="category">
                                        <?php
                                        $sql2 = "select * from tbl_category where active='Yes'";

                                        $res2 = mysqli_query($con, $sql2);

                                        if ($res2) {
                                            $count = mysqli_num_rows($res2);
                                            if ($count > 0) {
                                                while ($row2 = mysqli_fetch_array($res2)) {
                                        ?>
                                                    <option value="<?php echo $row2["id"] ?>" <?php if ($row2["id"] == $row["category_id"]) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row2["title"] ?>
                                                    </option>
                                        <?php

                                                }
                                            } else {
                                                echo "<option value='0'>Category Not Found</option>";
                                            }
                                        }

                                        ?>

                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td><label for="featured" class="lbl">Featured :</label></td>
                                <td>
                                    <input type="radio" name="featured" value="Yes" <?php if ($row["featured"] == "Yes") {
                                                                                        echo "checked";
                                                                                    } ?>>&nbsp;&nbsp;Yes
                                    <input type="radio" name="featured" value="No" <?php if ($row["featured"] == "No") {
                                                                                        echo "checked";
                                                                                    } ?>>&nbsp;&nbsp;No
                                </td>
                            </tr>

                            <tr>
                                <td><label for="active" class="lbl">Active :</label></td>
                                <td>
                                    <input type="radio" name="active" value="Yes" <?php if ($row["active"] == "Yes") {
                                                                                        echo "checked";
                                                                                    } ?>>&nbsp;&nbsp;Yes
                                    <input type="radio" name="active" value="No" <?php if ($row["active"] == "No") {
                                                                                        echo "checked";
                                                                                    } ?>>&nbsp;&nbsp;No
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
                                    <input type="hidden" name="image_name" value="<?php echo $row["image_name"] ?>">
                                    <input type="submit" class="btn-add" name="update" value="Update Food">
                                </td>
                            </tr>

                        </table>

                    </form>

                    <?php
                    if (isset($_POST["update"])) {
                        //get the new values from the form
                        $id = $_POST["id"];
                        $title = mysqli_real_escape_string($con, $_POST["title"]);
                        $description = mysqli_real_escape_string($con, $_POST["description"]);
                        $price = mysqli_real_escape_string($con, $_POST["price"]);
                        $image_name = $_POST["image_name"];
                        $category = $_POST["category"];
                        $featured = $_POST["featured"];
                        $active = $_POST["active"];

                        //check wheather the image is selected or not

                        if (isset($_FILES["image2"]["name"])) {

                            //updating the image if the new selected in folder
                            $old_path = "../images/food/" . $image_name;
                            $new_image_name = $_FILES['image2']['name'];

                            //always check image name is empty or not

                            if ($new_image_name != "") {
                                //image is available

                                $ext = end(explode(".", $new_image_name));

                                $new_image_name = "Food_Name_" . time() . "." . $ext;

                                $source_path = $_FILES['image2']['tmp_name'];

                                $destination_path = "../images/food/" . $new_image_name;

                                //finally upload an image in the destination folder
                                $upload  = move_uploaded_file($source_path, $destination_path);
                                if ($upload == false) {
                                    echo "image is not uploaded <br>";
                                    //image is not uploaded
                                    $_SESSION["upload_failed"] = "<div class='error'>Failed to Upload an image</div>";
                                    //redirect to manage category
                                    header("location:" . SITEURL . "admin/manage-food.php");
                                    //stop the process
                                    die();
                                }

                                //image is uploaded
                                $remove = unlink($old_path);
                                //check wheather image is removed or not
                                if ($remove == false) {
                                    //failed to remove image
                                    echo "image is not removed <br>";
                                    $_SESSION["remove-failed"] = "<div class='error'>Failed to Remove an image</div>";
                                    //redirect to manage category
                                    header("location:" . SITEURL . "admin/manage-food.php");
                                    //stop the process
                                    die();
                                } else {
                                    echo "image is removed <br>";
                                    //new image is uploaded and old image is deleted so enter new image name in the database
                                    $image_name = $new_image_name;
                                }
                            } else {
                                echo "Image is null <br>";
                            }
                        } else {
                            echo "Image is not set <br>";
                        }

                        //update the database
                        //everything is okay
                        $sql3 = "update tbl_food set title='$title',description='$description',price=$price,image_name='$image_name',category_id=$category,featured='$featured',active='$active' where id=$id";

                        //execute the query 
                        $res3 = mysqli_query($con, $sql3);

                        if ($res3 == true) {
                            echo "Done <br>";
                            // executed
                            // category updated
                            $_SESSION["update_food"] = "<div class='success'>Food Updated Successfully</div>";
                            //redirect to manage category page
                            header("location:" . SITEURL . "admin/manage-food.php");
                        } else {
                            echo "not done <br>";
                            // failed to update category
                            $_SESSION["update_food"] = "<div class='error'>Failed to Update Food</div>";
                            //redirect to manage category page
                            header("location:" . SITEURL . "admin/manage-food.php");
                            // not executed
                        }
                    }
                    ?>
        <?php

                } else {
                    //food is not available 
                    $_SESSION["no-food-found"] = "<div class='error'>Food not found</div>";
                    //redirect to manage category
                    header("location:" . SITEURL . "admin/manage-food.php");
                }
            }
        } else {
            //redirect to manage category
            header("location:" . SITEURL . "admin/manage-food.php");
        }
        ?>
        <br><br>


    </div>
    <!-- wrapper ends here -->
</div>
<!-- main content ends here -->

<?php
include "partials/footer.php";
?>