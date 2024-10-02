<?php
$servername = "localhost";
$username = "membs";
$password = "Password123"; //4 variables for the database
$dbname = "membs";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);//standardised name "conn" for connection so use it
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>