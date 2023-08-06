<?php
include "partials/menu.php";
?>

<div class="main-content">
    <div class="wrapper text-center">
        <h1>Update Category</h1>
        <br><br>
        <?php
        //check wheather the id is set or not
        if (isset($_GET["id"])) {
            //get the id and all the details 
            $id =  $_GET["id"];
            $sql = "select * from tbl_category where id=$id";
            $res = mysqli_query($con, $sql);

            if ($res) {
                //query is executed
                $count = mysqli_num_rows($res);
                if ($count == 1) {
                    //category is available 
                    //update category now
                    $row =  mysqli_fetch_array($res);
        ?>
                    <!-- enctype is required to upload file -->
                    <form action="" method="POST" enctype="multipart/form-data">

                        <table class="tbl-40">
                            <tr>
                                <td><label for="full name" class="lbl">Title :</label></td>
                                <td>
                                    <input type="text" value="<?php echo $row["title"] ?>" name="title" placeholder="Enter Category title" required>
                                </td>
                            </tr>

                            <tr>
                                <td><label for="full name" class="lbl">Current Image :</label></td>
                                <td>
                                    <img src="<?php echo SITEURL . "images/category/" . $row["image_name"] ?>" width="100px" alt="Image not found">
                                </td>
                            </tr>

                            <tr>
                                <td><label for="image" class="lbl">Select New Image :</label></td>
                                <td>
                                    <input type="file" name="image1">
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
                                    <input type="submit" class="btn-add" name="update" value="Update Category">
                                </td>
                            </tr>
                        </table>

                    </form>

                    <?php
                    if (isset($_POST["update"])) {
                        //get the new values from the form
                        $title = mysqli_real_escape_string($con, $_POST["title"]);
                        $featured = $_POST["featured"];
                        $active = $_POST["active"];
                        $id = $_POST["id"];
                        $image_name = $_POST["image_name"];

                        //check wheather the image is selected or not

                        if (isset($_FILES["image1"]["name"])) {

                            echo "image is set" . "<br>";

                            //updating the image if the new selected in folder
                            $old_path = "../images/category/" . $image_name;
                            $new_image_name = $_FILES['image1']['name'];

                            //always check image name is empty or not

                            if ($new_image_name != "") {
                                //image is available

                                $ext = end(explode(".", $new_image_name));

                                $new_image_name = "Food_Category_" . time() . "." . $ext;

                                $source_path = $_FILES['image1']['tmp_name'];

                                $destination_path = "../images/category/" . $new_image_name;

                                //finally upload an image in the destination folder
                                $upload  = move_uploaded_file($source_path, $destination_path);
                                if ($upload == false) {
                                    //image is not uploaded
                                    $_SESSION["upload"] = "<div class='error'>Failed to Upload an image</div>";
                                    //redirect to manage category
                                    header("location:" . SITEURL . "admin/manage-category.php");
                                    //stop the process
                                    die();
                                }

                                //image is uploaded
                                $remove = unlink($old_path);
                                //check wheather image is removed or not
                                if ($remove == false) {
                                    //failed to remove image
                                    $_SESSION["upload"] = "<div class='error'>Failed to Remove an image</div>";
                                    //redirect to manage category
                                    header("location:" . SITEURL . "admin/manage-category.php");
                                    //stop the process
                                    die();
                                } else {
                                    //new image is uploaded and old image is deleted so enter new image name in the database
                                    $image_name = $new_image_name;
                                }
                            } else {
                                echo "image is null <br>";
                            }
                        } else {
                            echo "Image is not set <br>";
                        }

                        echo $image_name . "<br> before update";

                        //update the database
                        $sql2 = "update tbl_category set title='$title',featured='$featured',active='$active',image_name='$image_name' where id=$id";

                        //execute the query 
                        $res2 = mysqli_query($con, $sql2);

                        if ($res2) {
                            //executed
                            //category updated
                            $_SESSION["update_cat"] = "<div class='success'>Category Updated Successfully</div>";
                            //redirect to manage category page
                            header("location:" . SITEURL . "admin/manage-category.php");
                        } else {
                            //failed to update category
                            $_SESSION["update_cat"] = "<div class='error'>Failed to Update Category</div>";
                            //redirect to manage category page
                            header("location:" . SITEURL . "admin/manage-category.php");
                            //not executed
                        }
                    }
                    ?>
        <?php

                } else {
                    //category is not available 
                    $_SESSION["no-category-found"] = "<div class='error'>Category not found</div>";
                    //redirect to manage category
                    header("location:" . SITEURL . "admin/manage-category.php");
                }
            }
        } else {
            //redirect to manage category
            header("location:" . SITEURL . "admin/manage-category.php");
        }
        ?>
        <br><br>


    </div>
</div>


<?php
include "partials/footer.php";
?>