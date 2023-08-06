<?php
include "partials-food/menu.php";
?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        //fetch active and featured categories from the database
        //limit 3 to display only
        $sql1 = "select * from tbl_category where active='Yes'";

        $res1 = mysqli_query($con, $sql1);

        if ($res1) {
            $count = mysqli_num_rows($res1);

            if ($count > 0) {
                //cateogries found
                while ($row1 = mysqli_fetch_array($res1)) {
        ?>
                    <a href="<?php echo SITEURL . "category-foods.php?category_id=" . $row1["id"] ?>">
                        <div class="box-3 float-container">
                            <img src="<?php echo SITEURL . "images/category/" . $row1["image_name"] ?>" alt="Image not found" class="img-responsive img-curve">

                            <h3 class="float-text text-white"><?php echo $row1["title"] ?></h3>
                        </div>
                    </a>
        <?php
                }
            } else {
                //no categories
                echo "<div class='error'>No category Found</div>";
            }
        }

        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php
include "partials-food/footer.php";
?>