<?php
//start session
session_start();
ob_start();

//create constants to store non repeating values
//contants are global they can be accessed from every where
define("SITEURL", "https://luddite-oils.000webhostapp.com/");
define("LOCALHOST", 'localhost');
define("USERNAME", 'id18651448_chirag');
define("PASSWORD", 'Chirag_bochi5454');
define("DB", 'id18651448_wowfood');

$con = mysqli_connect(LOCALHOST, USERNAME, PASSWORD, DB);

if (!$con) {
?>
    <script>
        alert("Database connection failed");
    </script>
<?php
}

?>