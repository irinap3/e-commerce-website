<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "ecommercedb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
}
?>
