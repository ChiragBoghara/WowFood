<?php
include "config/constants.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <!-- Navbar Section Starts Here -->
    <button onclick="topFunction()" id="myBtn" title="Go to top">
        <!-- <img src="https://img.icons8.com/ios-glyphs/30/ffffff/up--v1.png" /> -->
        <img src="https://img.icons8.com/material-outlined/24/ffffff/up.png" />
    </button>
    <section class="navbar">
        <div class="container nav">
            <div class="logo">
                <a href="<?php echo SITEURL ?>" title="Logo">
                    <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL . "categories.php" ?>">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL . "foods.php" ?>">Foods</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL . "categories.php" ?>">Contact</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->

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

    <?php
    if (isset($_SESSION["order"])) {
        echo "<br><br>";
        echo $_SESSION["order"];
        unset($_SESSION["order"]);
    }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
            //fetch active and featured categories from the database
            //limit 3 to display only
            $sql1 = "select * from tbl_category where active='Yes' and featured='Yes' limit 3";

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
                    echo "<div class='error'>Category not Available</div>";
                }
            }

            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            //get active and featured foods
            $sql2 = "select * from tbl_food where active='Yes' and featured='Yes' limit 6";

            $res2 = mysqli_query($con, $sql2);

            if ($res2) {
                //query executed
                $count2 = mysqli_num_rows($res2);

                if ($count2 > 0) {
                    //foods found
                    while ($row2 = mysqli_fetch_array($res2)) {
            ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <img src="<?php echo SITEURL . "images/food/" . $row2["image_name"] ?>" alt="Image not found" class="img-responsive img-curve">
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $row2["title"] ?></h4>
                                <p class="food-price"><?php echo "Rs  &nbsp;" . $row2["price"] ?></p>
                                <p class="food-detail">
                                    <?php echo $row2["description"] ?>
                                </p>
                                <br>
                                <a href="<?php echo SITEURL . "order.php?food_id=" .  $row2["id"] ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo "<div class='error'>Food not Available</div>";
                    //foods not found
                }
            }
            ?>

            <div class="clearfix"></div>

        </div>

        <p class="text-center">
            <a href="<?php echo SITEURL . "foods.php" ?>">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <script>
        //Get the button:
        mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>

    <?php
    include "partials-food/footer.php";
    ?>