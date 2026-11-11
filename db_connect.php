<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "ibraah_express_db"; 

// Kutumia $conn yenye n mbili ili mechi na login na admin dashboard zako
$conn = new mysqli($servername, $username, $password, $dbname);

// Angalia kama muunganisho umefeli
if ($conn->connect_error) {
    die("Muunganisho wa Database Umefeli: " . $conn->connect_error);
}

// Set charset kwa kutumia $conn iliyorekebishwa
$conn->set_charset("utf8mb4");
?>