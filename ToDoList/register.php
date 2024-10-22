<?php
include 'db_connect.php';

$usnm = $_POST['uname'];
$pswd = $_POST['password'];
$fname = $_POST['fname'];
$sname = $_POST['sname'];
$email = $_POST['email'];
$pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
$passwordIsValid = true;
$signupDate = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first and last name
    if (empty($fname)) {
        $nameErr = "First name is required";
        header("refresh:5; url=index.html");
        echo $nameErr;
    } elseif (empty($sname)) {
        $nameErr = "Last name is required";
        header("refresh:5; url=index.html");
        echo $nameErr;
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
        $nameErr = "Only letters and white space allowed in first name";
        header("refresh:5; url=index.html");
        $passwordIsValid = false;
        echo $nameErr;
    } elseif (!preg_match($pattern, $email)) {
        header("refresh:5; url=index.html");
        echo "Email format is incorrect";
    } elseif (strlen($pswd) < 8) {
        header("refresh:10; url=index.html");
        $passwordErr = "Your Password Must Contain At Least 8 Characters!";
        $passwordIsValid = false;
        echo $passwordErr;
    } elseif (!preg_match("#[0-9]+#", $pswd)) {
        header("refresh:10; url=index.html");
        $passwordErr = "Your Password Must Contain At Least 1 Number!";
        $passwordIsValid = false;
        echo $passwordErr;
    } elseif (!preg_match("#[A-Z]+#", $pswd)) {
        header("refresh:10; url=index.html");
        $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
        $passwordIsValid = false;
        echo $passwordErr;
    } elseif (!preg_match("#[a-z]+#", $pswd)) {
        header("refresh:10; url=index.html");
        $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
        $passwordIsValid = false;
        echo $passwordErr;
    } elseif (!preg_match("#[^\w\s]+#", $pswd)) {
        header("refresh:10; url=index.html");
        $passwordErr = "Your Password Must Contain At Least 1 Special Character!";
        $passwordIsValid = false;
        echo $passwordErr;
    }

    // Check password validity
    if ($passwordIsValid) {
        $hashedPassword = password_hash($pswd, PASSWORD_DEFAULT);
        echo $hashedPassword;
    }
} else {
    echo 'Password is incorrect';
}

// Insert data into the database if password is valid
try {
    $sql = "INSERT INTO mem (Username, Password, Fname, Sname, Email, signup) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $usnm);
    $stmt->bindParam(2, $hashedPassword);
    $stmt->bindParam(3, $fname);
    $stmt->bindParam(4, $sname);
    $stmt->bindParam(5, $email);
    $stmt->bindParam(6, $signupDate);

    $stmt->execute();
    header("refresh:5; url=login.html");
    echo "Successfully Registered";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>