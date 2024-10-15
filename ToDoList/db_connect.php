<?php
$servername = "localhost";
$username = "ToDoUser";
$password = "Password123"; //4 variables for the database
$dbname = "ToDoUser";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);//standardised name "conn" for connection so use it
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>