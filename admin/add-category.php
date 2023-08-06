<?php
include "partials/menu.php";
?>

<div class="main-content">
    <div class="wrapper text-center">
        <h1>Add Category</h1>
        <br><br>
        <?php
        if (isset($_SESSION["add"])) {
            echo $_SESSION["add"];
            //removing session message
            unset($_SESSION["add"]);
        }
        ?>
        <br><br>
        <!-- Add category form starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-40">
                <tr>
                    <td><label for="full name" class="lbl">Title :</label></td>
                    <td><input type="text" name="title" placeholder="Enter Category title" required></td>
                </tr>

                <tr>
                    <td><label for="image" class="lbl">Select Image :</label></td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td><label for="featured" class="lbl">Featured :</label></td>
                    <td>
                        <input type="radio" name="featured" value="Yes" checked>&nbsp;&nbsp;Yes
                        <input type="radio" name="featured" value="No">&nbsp;&nbsp;No
                    </td>
                </tr>
                <tr>
                    <td><label for="active" class="lbl">Active :</label></td>
                    <td>
                        <input type="radio" name="active" value="Yes" checked>&nbsp;&nbsp;Yes
                        <input type="radio" name="active" value="No">&nbsp;&nbsp;No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="btn-add" name="add" value="Add Category">
                    </td>
                </tr>
            </table>

        </form>

        <?php
        //check add button is clicked or not
        if (isset($_POST["add"])) {

            // get the values from the form
            $title = mysqli_real_escape_string($con, $_POST["title"]);
            $featured = $_POST["featured"];
            $active = $_POST["active"];

            //check wheather image is selected or not and set the value for image name accordingly

            // print_r($_FILES['image']);

            if (isset($_FILES['image']['name'])) {
                //upload an image
                //to upload image we need image name and source path and destination path

                $image_name = $_FILES['image']['name'];

                //Auto rename the image because if the admin will upload the different image with the same name then 
                // previously uploaed image will be replaced with new image with the same name

                //Get the extension of our image(jpg,png,gif,jpeg etc)
                //i.e : food1.jpg
                //end is used because there can be more than one . in image name
                //i.e : sample.food1.jpg

                $ext = end(explode(".", $image_name));

                //rename the image now
                //time function will return the time in seconds
                //here use of time will be better because time will never repeat it will be always unique
                $image_name = "Food_Category_" . time() . "." . $ext;
                //food_category_83268714.jpg

                $source_path = $_FILES['image']['tmp_name'];

                $destination_path = "../images/category/" . $image_name;

                //finally upload an image in the destination folder
                $upload  = move_uploaded_file($source_path, $destination_path);

                //check wheather the image is uploaded or not
                //and if the image is not uploaded then we will stop the process and redirect with eror message

                if ($upload == false) {
                    //set error message
                    $_SESSION['upload'] = "<div class='error'>Failed to upload an image</div>";
                    //redirect to add category page
                    header("location:" . SITEURL . "admin/add-category.php");
                    //stop the process
                    die();
                }
            } else {
                //Don't upload image and set the image name value as blank
                //query is not executed
                $_SESSION["add"] = "<div class='error'>Image is not selected properly</div>";
                //redirect to same page
                header("location:" . SITEURL . "admin/add-category.php");
            }

            //create sql query insert category
            $sql = "insert into tbl_category (title,image_name,featured,active) values ('$title','$image_name','$featured','$active')";
            $res = mysqli_query($con, $sql);
            if ($res) {
                //query is executed
                $_SESSION["add"] = "<div class='success'>Category Added Successfully</div>";
                //redirect to manage category page
                header("location:" . SITEURL . "admin/manage-category.php");
            } else {
                //query is not executed
                $_SESSION["add"] = "<div class='error'>Failed to Add Category</div>";
                //redirect to same page
                header("location:" . SITEURL . "admin/add-category.php");
            }
        }

        ?>
        <!-- Add category form ends -->
    </div>
</div>

<?php
include "partials/footer.php";
?>