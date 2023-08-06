<?php
include "partials-food/menu.php";
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <?php
        //get the searched keyword
        //mysqli_real_escape_string function Removes the special characters from the
        $search = mysqli_real_escape_string($con, $_POST["search"]);
        // 'pizza'
        ?>

        <h2>Foods on Your Search <a href="#" class="text-white"><?php echo '"' . $search . '"' ?></a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->


<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php

        //sql query to get food base on search keyword
        $sql = "select * from tbl_food where title like '%$search%' or description like '%$search%'";

        $res = mysqli_query($con, $sql);

        if ($res) {
            //query executed
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                //food found
                while ($row = mysqli_fetch_assoc($res)) {
        ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <img src="<?php echo SITEURL . "images/food/" . $row["image_name"]  ?>" alt="Image not found" class="img-responsive img-curve">
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $row["title"] ?></h4>
                            <p class="food-price"><?php echo $row["price"] ?></p>
                            <p class="food-detail">
                                <?php echo  $row["description"] ?>
                            </p>
                            <br>
                            <a href="<?php echo SITEURL . "order.php?food_id=" .  $row["id"] ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
        <?php
                }
            } else {
                //not found
                echo "<div class='error'>Food not Found</div>";
            }
        }

        ?>

        <div class="clearfix"></div>

    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php
include "partials-food/footer.php";
?>