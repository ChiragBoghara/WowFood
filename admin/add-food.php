<?php
include "partials/menu.php";
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
        <?php
        if (isset($_SESSION["upload"])) {
            echo $_SESSION["upload"];
            unset($_SESSION["upload"]);
        }
        ?>

        <br><br>
        <!-- form starts here -->
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-40">

                <tr>
                    <td><label for="title" class="lbl">Title :</label></td>
                    <td><input type="text" name="title" placeholder="Enter title" required></td>
                </tr>

                <tr>
                    <td><label for="description" class="lbl">Description :</label></td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="Enter description" required></textarea></td>
                </tr>

                <tr>
                    <td><label for="price" class="lbl">Price :</label></td>
                    <td><input type="number" name="price" placeholder="Enter Price" required></td>
                </tr>

                <tr>
                    <td><label for="Image" class="lbl">Select Image :</label></td>
                    <td><input type="file" name="image" required></td>
                </tr>

                <tr>
                    <td><label for="category" class="lbl">Category :</label></td>
                    <td>
                        <select name="category">
                            <!-- php code to display categories from the database -->
                            <?php
                            //query to get all the cateogries from db
                            $sql = "select * from tbl_category where active='Yes'";
                            $res = mysqli_query($con, $sql);
                            if ($res) {
                                //query executed
                                $count = mysqli_num_rows($res);
                                if ($count > 0) {
                                    //category found
                                    while ($row = mysqli_fetch_array($res)) {
                                        $id =  $row["id"];
                                        $title = $row["title"];
                            ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                    }
                                } else {
                                    //category not found
                                    ?>
                                    <option value="0">No Category Found</option>
                            <?php
                                }
                            }
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="featured" class="lbl">Featured :</label></td>
                    <td>
                        <input type="radio" value="Yes" name="featured" checked>&nbsp;&nbsp;Yes&nbsp;
                        <input type="radio" value="No" name="featured">&nbsp;&nbsp;No
                    </td>
                </tr>

                <tr>
                    <td><label for="active" class="lbl">Active :</label></td>
                    <td>
                        <input type="radio" value="Yes" name="active" checked>&nbsp;&nbsp;Yes&nbsp;
                        <input type="radio" value="No" name="active">&nbsp;&nbsp;No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" value="Add Food" name="add" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST["add"])) {
            //add button is clicked 
            //1.get the values from the form fields

            $title = mysqli_real_escape_string($con, $_POST["title"]);
            $description = mysqli_real_escape_string($con, $_POST["description"]);
            $price = mysqli_real_escape_string($con, $_POST["price"]);
            $category = $_POST["category"];
            $featured = $_POST["featured"];
            $active = $_POST["active"];

            //2.Upload the image if selected

            //check wheather image is selected or not

            if (isset($_FILES["image"]["name"])) {

                $image_name = $_FILES["image"]["name"];

                if ($image_name != "") {
                    //image is selected

                    //rename the image
                    $ext = end(explode(".", $image_name));

                    $image_name = "Food_Name_" . time() . "." . $ext;

                    $source_path = $_FILES["image"]["tmp_name"];

                    $destination_path = "../images/food/" . $image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    if ($upload == false) {
                        //failed to move image
                        $_SESSION["upload"] = "<div class='error'>Failed to Upload Image</div>";
                        header("location:" . SITEURL . "admin/add-food.php");
                        die();
                    }
                }
            }
            //3.Insert into database
            //query to insert data in db

            //for numerical value we don't need to pass value inside quotes,
            //but for string value it is compulsory
            $sql2 = "insert into tbl_food (title,description,price,image_name,category_id,featured,active) values ('$title','$description',$price,'$image_name',$category,'$featured','$active')";

            $res = mysqli_query($con, $sql2);

            //4. redirect with message to manage_food page
            if ($res) {
                //query executed
                // inserted successfully
                $_SESSION["add"] = "<div class='success'>Food Added Successfully</div>";
                header("location:" . SITEURL . "admin/manage-food.php");
            } else {
                //failed to insert
                $_SESSION["add"] = "<div class='error'>Failed to Add Food</div>";
                header("location:" . SITEURL . "admin/manage-food.php");
            }
        }

        ?>

    </div>
</div>

<?php
include "partials/footer.php";
?>