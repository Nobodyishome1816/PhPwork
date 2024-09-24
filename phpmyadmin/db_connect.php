<?php
$servername = "localhost";
$username = "membs";
$password = "Password123"; //4 variables for the database
$dbname = "membs";

$conn = new mysqli($servername, $username, $password, $dbname); //standardised name "conn" for connection so use it

if ($conn->connect_error) { //checks the connection to the database and tells what went wrong
    die("Connection failed: " . $conn->connect_error); //kills the connection
}
echo "Connected successfully";
?>