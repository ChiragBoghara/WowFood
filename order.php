<?php
include "partials-food/menu.php";
?>

<?php
if (isset($_GET["food_id"])) {
    $food_id = $_GET["food_id"];

    $sql1 = "select * from tbl_food where id=$food_id";

    $res1 = mysqli_query($con, $sql1);

    if ($res1) {
        //executed
        $count = mysqli_num_rows($res1);
        if ($count > 0) {
            //food found
            $row = mysqli_fetch_assoc($res1);
?>
            <!-- fOOD sEARCH Section Starts Here -->
            <section class="food-search">
                <div class="container">

                    <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

                    <form action="" class="order" method="POST">
                        <fieldset>
                            <legend>Selected Food</legend>

                            <div class="food-menu-img">
                                <img src="<?php echo SITEURL . "images/food/" . $row["image_name"] ?>" alt="Image not found" class="img-responsive img-curve">
                            </div>

                            <div class="food-menu-desc">
                                <h3><?php echo $row["title"] ?></h3>
                                <input type="hidden" name="food" value="<?php echo $row["title"] ?>">

                                <p class="food-price"><?php echo 'Rs. &nbsp;' . $row["price"] ?></p>
                                <input type="hidden" name="price" value="<?php echo $row["price"] ?>">

                                <div class="order-label">Quantity</div>
                                <input type="number" min="1" name="qty" class="input-responsive" value="1" required>
                            </div>

                        </fieldset>

                        <fieldset>
                            <legend>Delivery Details</legend>
                            <div class="order-label">Full Name</div>
                            <input type="text" name="full-name" placeholder="E.g. Chirag Boghara" class="input-responsive" required>

                            <div class="order-label">Phone Number</div>
                            <input type="tel" name="contact" placeholder="E.g. 99091xxxxx" class="input-responsive" required>

                            <div class="order-label">Email</div>
                            <input type="email" name="email" placeholder="E.g. hi@chiragboghara.com" class="input-responsive" required>

                            <div class="order-label">Address</div>
                            <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                            <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                        </fieldset>

                    </form>

                    <?php
                    if (isset($_POST["submit"])) {
                        //button is clicked
                        //get the values from the form field

                        $food = $_POST["food"];
                        $price = $_POST["price"];
                        $qty = $_POST["qty"];

                        $total = $price * $qty;

                        //order date
                        //get current date and time
                        $order_date = date("Y-m-d h:m:sa");

                        //Ordered
                        //On Delivery
                        //Delivered
                        //Cancelled

                        $status = "Ordered";

                        $customer_name = $_POST["full-name"];
                        $customer_contact = $_POST["contact"];
                        $customer_email = $_POST["email"];
                        $customer_address = $_POST["address"];

                        //save the order in database

                        $sql2 = "insert into tbl_order(food,price,qty,total,order_date,status,customer_name,customer_contact,customer_email,customer_address) values ('$food',$price,$qty,$total,'$order_date','$status','$customer_name','$customer_contact','$customer_email','$customer_address')";

                        $res2 = mysqli_query($con, $sql2);

                        if ($res2) {
                            //executed
                            // order inserted successfully
                            $_SESSION["order"] = "<div class='success text-center'>Food Ordered Successfully</div>";
                            header("location:" . SITEURL);
                        } else {
                            //order failed
                            $_SESSION["order"] = "<div class='error text-center'>Failed to order food</div>";
                            header("location:" . SITEURL);
                        }
                    }
                    ?>

                </div>
            </section>
            <!-- fOOD sEARCH Section Ends Here -->
<?php
        } else {
            //no food found for given id
            //redirect to home page
            header("location:" . SITEURL);
        }
    }
} else {
    //redirect to home page
    header("location:" . SITEURL);
}
?>



<?php
include "partials-food/footer.php";
?>