<?php
include "partials/menu.php";
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <form action="" method="POST">

            <table class="tbl-40">

                <?php
                if (isset($_GET["order_id"])) {
                    $id = $_GET["order_id"];

                    $sql1 = "select * from tbl_order where id=$id";

                    $res1 = mysqli_query($con, $sql1);

                    if ($res1) {
                        //query executed
                        $count1 = mysqli_num_rows($res1);
                        if ($count1 > 0) {
                            //order found
                            $row1 = mysqli_fetch_array($res1);
                ?>
                            <tr>
                                <td>Food Name:</td>
                                <td>
                                    <b><?php echo $row1["food"] ?></b>
                                </td>
                            </tr>

                            <tr>
                                <td>Price:</td>
                                <td>
                                    <b><?php echo "Rs. &nbsp;" . $row1["price"] ?></b>
                                </td>
                            </tr>

                            <tr>
                                <td>Qty:</td>
                                <td>
                                    <input type="number" name="qty" min="1" value="<?php echo $row1['qty'] ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>Status:</td>
                                <td>
                                    <select name="status">
                                        <option value="Ordered" <?php
                                                                if ($row1['status'] == 'Ordered') {
                                                                    echo "selected";
                                                                } ?>>Ordered
                                        </option>
                                        <option value="On Delivery" <?php
                                                                    if ($row1['status'] == 'On Delivery') {
                                                                        echo "selected";
                                                                    } ?>>On Delivery</option>
                                        <option value="Delivered" <?php
                                                                    if ($row1['status'] == 'Delivered') {
                                                                        echo "selected";
                                                                    } ?>>Delivered</option>
                                        <option value="Cancelled" <?php
                                                                    if ($row1['status'] == 'Cancelled') {
                                                                        echo "selected";
                                                                    } ?>>Cancelled</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Customer Name:</td>
                                <td>
                                    <input type="text" name="customer_name" value="<?php echo $row1['customer_name'] ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>Customer Contact:</td>
                                <td>
                                    <input type="tel" name="customer_contact" value="<?php echo $row1['customer_contact'] ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>Customer Email:</td>
                                <td>
                                    <input type="text" name="customer_email" value="<?php echo $row1['customer_email'] ?>">
                                </td>
                            </tr>


                            <tr>
                                <td>Customer Address:</td>
                                <td>
                                    <textarea name="customer_address" id="" cols="30" rows="5"><?php echo $row1['customer_address'] ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <input type="hidden" name="id" value="<?php echo $row1['id'] ?>">
                                    <input type="hidden" name="price" value="<?php echo $row1['price'] ?>">
                                    <input type="submit" value="Update" name="submit" class="btn-secondary">
                                </td>
                            </tr>
                <?php
                        } else {
                            //order not found
                            //redirect to manage-order page with message
                            $_SESSION["order-not-found"] = "<div class='error'>Order not Found</div>";
                            header("location:" . SITEURL . "admin/manage-order.php");
                        }
                    }
                } else {
                    //redirect to manage_order page
                    header("location:" . SITEURL . "admin/manage-order.php");
                }
                ?>

            </table>
        </form>

        <?php
        if (isset($_POST["submit"])) {
            //button is clicked
            $id = $_POST["id"];
            $price = mysqli_real_escape_string($con, $_POST["price"]);
            $qty = mysqli_real_escape_string($con, $_POST["qty"]);
            $total = $price * $qty;
            $status = $_POST["status"];
            $customer_name = mysqli_real_escape_string($con, $_POST["customer_name"]);
            $customer_contact = mysqli_real_escape_string($con, $_POST["customer_contact"]);
            $customer_email = mysqli_real_escape_string($con, $_POST["customer_email"]);
            $customer_address = mysqli_real_escape_string($con, $_POST["customer_address"]);

            //query to update data in db

            $sql2 = "update tbl_order set qty=$qty,total=$total,status='$status',customer_name='$customer_name',customer_contact='$customer_contact',customer_email='$customer_email',customer_address='$customer_address' where id=$id";

            $res2 = mysqli_query($con, $sql2);

            if ($res2) {
                //executed updated
                $_SESSION["update"] = "<div class='success'>Order Updated Successfully</div>";
                header("location:" . SITEURL . "admin/manage-order.php");
            } else {
                //not updated
                $_SESSION["update"] = "<div class='error'>Failed To Update Order</div>";
                header("location:" . SITEURL . "admin/manage-order.php");
            }
        }
        ?>
    </div>
</div>

<?php
include "partials/footer.php";
?>