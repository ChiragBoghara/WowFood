<?php
include "partials-food/menu.php";
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL . "food-search.php" ?>" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->


<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        //get all the active foods

        $sql = "select * from tbl_food";

        $res = mysqli_query($con, $sql);

        if ($res) {
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                //food found
                while ($row = mysqli_fetch_array($res)) {
        ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <img src="<?php echo SITEURL . "images/food/" . $row["image_name"] ?>" alt="Image not found" class="img-responsive img-curve">
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $row["title"] ?></h4>
                            <p class="food-price"><?php echo "Rs. &nbsp;" . $row["price"] ?></p>
                            <p class="food-detail">
                                <?php echo $row["description"] ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL . "order.php?food_id=" .  $row["id"] ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
        <?php
                }
            } else {
                //food not found
                echo "<div class='error'>Food Not Available</div>";
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