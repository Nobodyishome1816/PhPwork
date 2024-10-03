<?php
    include 'db_connect.php';

    $usnm = $_POST['uname'];
    $pswd = $_POST['password'];
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $email = $_POST['email'];
    $pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
    $passwordisvalid = true;
    $signupdate = date ("Y-m-d");

    if ($_SERVER["REQUEST_METHOD"] == "POST") { //used to start the if statement after everything
        if (empty($fname)) {
            $nameErr = "First name is required";
            header("refresh:5; url=index,html");
            echo $nameErr;
        } elseif (empty($sname)) {
            $nameErr = "Last name is required";
            header("refresh:5; url=index.html");
            echo $nameErr;
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $nameErr = "Only letters and white space allowed in first name";
            header("refresh:5; url=index.html");
            $passwordisvalid = false;
            echo $nameErr;
        } elseif (!preg_match($pattern, $email)) {  // trying to use the pattern variable to check the email
            header("refresh:5; url=index.html");
            echo "email format is incorrect";
        } elseif (strlen($pswd) <= '8') {
            header("refresh:10; url=index.html");
            $passwordErr = "Your Password Must Contain At Least 8 Characters!";
            $passwordisvalid = false;
            echo $passwordErr;
        } elseif (!preg_match("#[0-9]+#", $_POST['password'])) {
            header("refresh:10; url=index.html");
            $passwordErr = "Your Password Must Contain At Least 1 Number!";
            $passwordisvalid = false;
            echo $passwordErr;
        } elseif (!preg_match("#[A-Z]+#", $pswd)) {
            header("refresh:10; url=index.html");
            $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
            $passwordisvalid = false;
            echo $passwordErr;
            exit;
        } elseif (!preg_match("#[a-z]+#", $pswd)) {
            header("refresh:10; url=index.html");
            $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
            $passwordisvalid = false;
            echo $passwordErr;
            exit;
        } elseif (!preg_match("#[^\w\s]+#", $pswd)) {
            header("refresh:10; url=index.html");
            $passwordErr = "Your Password Must Contain At Least 1 Special Character!";
            $passwordisvalid = false;
            echo $passwordErr;
            exit;
        } if ($passwordisvalid == true) {
            $hashedpassword = password_hash($pswd, PASSWORD_DEFAULT);
            echo $hashedpassword;
        }
    }
    else {
        echo 'password is incorrect';
    }try {
    $sql = "INSERT INTO mem (Username, Password, Fname, Sname, Email, signup) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);


    $stmt->bindParam(1, $usnm);
    $stmt->bindParam(2, $hashedpassword);
    $stmt->bindParam(3, $fname);
    $stmt->bindParam(4, $sname);
    $stmt->bindParam(5, $email);
    $stmt->bindParam(6, $signupdate);

    $stmt->execute();
    header("refresh:5; url=login.html");
    echo "Successfully Registered";
}catch (PDOException $e){
        echo "Error: " . $e->getMessage();
}
?>