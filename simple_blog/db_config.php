<<<<<<< HEAD
<?php
// db_config.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simple_blog";

// Krijimi i lidhjes
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kontrolli i lidhjes
if (!$conn) {
    die("Lidhja dështoi: " . mysqli_connect_error());
}
=======
<?php
// db_config.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simple_blog";

// Krijimi i lidhjes
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kontrolli i lidhjes
if (!$conn) {
    die("Lidhja dështoi: " . mysqli_connect_error());
}
>>>>>>> e64f7dbfcfab5e039ad57c666537456aa99c4a7d
?>