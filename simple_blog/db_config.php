
<?php
// db_config.php - Konfigurimi i Lidhjes me Databazë

// Të dhënat e lidhjes
$servername = "localhost";
$username = "root";
$password = ""; // Lëre bosh nëse s'ke fjalëkalim (standard i XAMPP)
$dbname = "simple_blog"; 

// Krijimi i lidhjes (duke përdorur funksionet MySQLi)
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kontrolli i lidhjes
if (!$conn) {
    // Nëse lidhja dështon, shfaq mesazhin e gabimit
    die("Lidhja dështoi: " . mysqli_connect_error());
}

// Nuk ka tag mbyllës ?>