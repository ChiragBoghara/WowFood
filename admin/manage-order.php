<?php include "partials/menu.php"; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br><br>

        <?php
        if (isset($_SESSION["order-not-found"])) {
            echo $_SESSION["order-not-found"];
            unset($_SESSION["order-not-found"]);
        }
        if (isset($_SESSION["update"])) {
            echo $_SESSION["update"];
            unset($_SESSION["update"]);
        }
        ?>

        <br>
        <br>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            <?php
            //get all the orders
            //display the latest order at first
            $sql = "select * from tbl_order order by id desc";

            $res = mysqli_query($con, $sql);

            if ($res) {
                //executed
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $status = $row['status'];
            ?>
                        <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $row["food"] ?></td>
                            <td><?php echo $row["price"] ?></td>
                            <td><?php echo $row["qty"] ?></td>
                            <td><?php echo $row["total"] ?></td>
                            <td><?php echo $row["order_date"] ?></td>
                            <td>
                                <?php
                                if ($status == "Ordered") {
                                    echo "<label style='font-weight:bold'>$status</label>";
                                } else if ($status == "On Delivery") {
                                    echo "<label style='color: orange;font-weight:bold'>$status</label>";
                                } else if ($status == "Cancelled") {
                                    echo "<label style='color: red;font-weight:bold'>$status</label>";
                                } else if ($status == "Delivered") {
                                    echo "<label style='color: green;font-weight:bold'>$status</label>";
                                }
                                ?>

                            </td>
                            <td><?php echo $row["customer_name"] ?></td>
                            <td><?php echo $row["customer_contact"] ?></td>
                            <td><?php echo $row["customer_email"] ?></td>
                            <td><?php echo $row["customer_address"] ?></td>
                            <td>
                                <a href="<?php echo SITEURL . "admin/update-order.php?order_id=" . $row["id"] ?>" class="btn-secondary">Update </a>
                            </td>
                        </tr>
            <?php
                    }
                } else {
                    echo "<tr><td colspan='12' class='error'>Orders not Available</td></tr>";
                }
            }

            ?>

        </table>
    </div>

</div>

<?php include "partials/footer.php"; ?>