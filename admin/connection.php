<?php
$con = mysqli_connect("localhost", "id18651448_chirag", "Chirag_bochi5454", "id18651448_wowfood");

if (!$con) {
?>
    <script>
        alert("Database connection failed");
    </script>
<?php
}

?>