<?php
include "partials-food/menu.php";
?>

<?php

if (isset($_GET["category_id"])) {
    $category_id = $_GET["category_id"];

    $sql = "select title from tbl_category where id = $category_id";

    $res = mysqli_query($con, $sql);

    if ($res) {
        //query executed
        $count = mysqli_num_rows($res);
        if ($count > 0) {
            $row = mysqli_fetch_assoc($res);
            $title = $row["title"];
        } else {
            //category not found with given id
            //redirect to homepage
            header("location:" . SITEURL);
        }
    }
} else {
    //category id is not passed with url
    //redirect to homepage
    header("location:" . SITEURL);
}

?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">


        <h2>Foods on <a href="#" class="text-white"><?php echo '"' . $title . '"' ?></a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <!-- sql to get all the active foods by category id -->
        <?php
        $sql2 = "select * from tbl_food where category_id=$category_id";

        $res2 = mysqli_query($con, $sql2);
        if ($res2) {
            //executed
            $count = mysqli_num_rows($res2);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res2)) {
        ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <img src="<?php echo SITEURL . "images/food/" . $row["image_name"] ?>" alt="Image not found" class="img-responsive img-curve">
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $row["title"] ?></h4>
                            <p class="food-price"><?php echo $row["price"] ?></p>
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
                echo "<div class='error'>Food not Available</div>";
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