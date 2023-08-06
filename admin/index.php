<?php
include "partials/menu.php";
?>


<!-- Main Content section starts -->
<div class="main-content">


    <div class="wrapper">
        <h1>Dashboard</h1>
        <br>
        <br>
        <?php
        if (isset($_SESSION["login"])) {
            echo $_SESSION["login"];
            unset($_SESSION["login"]);
        }
        ?>
        <br>
        <br>
        <?php
        $sql1 = "select * from tbl_category";

        $res1 = mysqli_query($con, $sql1);

        if ($res1) {
            $count1 = mysqli_num_rows($res1);
        }

        ?>

        <div class="col-4 text-center">
            <h1><?php echo $count1 ?></h1>
            <br>
            Categories
        </div>

        <?php
        $sql2 = "select * from tbl_food";

        $res2 = mysqli_query($con, $sql2);

        if ($res2) {
            $count2 = mysqli_num_rows($res2);
        }

        ?>

        <div class="col-4 text-center">
            <h1><?php echo $count2 ?></h1>
            <br>
            Foods
        </div>

        <?php
        $sql3 = "select * from tbl_order";

        $res3 = mysqli_query($con, $sql3);

        if ($res3) {
            $count3 = mysqli_num_rows($res3);
        }

        ?>

        <div class="col-4 text-center">
            <h1><?php echo $count3 ?></h1>
            <br>
            Order
        </div>

        <?php
        $sql4 = "select sum(total) as TOTAL from tbl_order where status='Delivered'";

        $res4 = mysqli_query($con, $sql4);

        if ($res4) {
            $row = mysqli_fetch_array($res4);
            $total = $row["TOTAL"];
        }

        ?>

        <div class="col-4 text-center">
            <h1><?php
                if ($total == 0) {
                    echo 'Rs. 0' . $total;
                } else {
                    echo 'Rs. &nbsp;' . $total;
                }
                ?></h1>
            <br>
            Total Revenue
        </div>

        <div class="clearfix"></div>

    </div>
</div>
<!-- Main Content section ends -->

<?php
include "partials/footer.php";
?>