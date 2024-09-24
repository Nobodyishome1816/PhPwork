<?php
include 'db_connect.php';

$usnm = $_POST['uname'];
$pswd = $_POST['password'];
$fname = $_POST['fname'];
$sname = $_POST['sname'];
$email = $_POST['email'];
$pattern = "[a-zA-Z0-9._-]+ @ [a-zA-Z0-9.-]+ \.[a-zA-Z]{2,4}";

$sql = "INSERT INTO mem (Username, Password, Fname, Sname, Email) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $usnm, $pswd, $fname, $sname, $email); //always bind parameters, stops easy sql injection
mysqli_stmt_execute($stmt);

if(!preg_match($email, $pattern)){
    echo "email format is correct";
    exit;
}

if (mysqli_stmt_error($stmt)) {
    echo "Error: " . mysqli_stmt_error($stmt);
} else {
    echo "new record created successfully";
}
?>