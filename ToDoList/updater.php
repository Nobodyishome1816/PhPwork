<!DOCTYPE HTML>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div id="container">
    <h1>Welcome to the updater</h1>
</div>
<?php
session_start();
if(!$_SESSION["ssnlogin"]) {
    header("refresh:5;url=login.html");
    echo "You are not currently logged in, redirecting to login page";
}
//}else {
//    echo 'loading, you are logged in';
//}
include "db_connect.php";  // connects to the database

$usnm = $_POST['Username'];  // pulls data from posted form
//echo $usnm;
$fname = $_POST['Fname']; // pulls data from posted form
//echo $fname;
$sname = $_POST['Sname']; // pulls data from posted form
//echo $sname;
$email = $_POST['Email']; // pulls data from posted form
//echo $email;
$userid = $_SESSION["Userid"]; //pulls data from session variable
$susnm = $_SESSION["uname"]; //pulls the current username from session variables
//echo $userid;
//echo $susnm;

try {  // attempts this code
    if ($susnm!=$usnm) { //if the username stored and typed dont match then do this
        echo "usernames triggered";
        $sql = "SELECT * FROM mem WHERE Username = ?";  // Selects usernames from database that match entered
        $stmt = $conn->prepare($sql);  //perpares the statement
        $stmt->bindParam(1, $usnm);  // secures this parameters, good coding method
        $stmt->execute();  //executes the code

        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //fetches the result

        if ($result) {  //if there is a result
            header("refresh:5; url=prof.php");  //error message and redirect
            echo "Usernames Exists, try another name";
            exit();  // this was needed as below code still executed... which is bad
        }
    }

    $sql = "UPDATE mem SET Username=?, Fname=?, Sname=?, Email=? WHERE Userid = ?";  //sets up the statement
    $stmt = $conn->prepare($sql);  //prepares it
    $stmt->bindParam(1,$usnm);  //binding all the parameters
    $stmt->bindParam(2,$fname);
    $stmt->bindParam(3,$sname);
    $stmt->bindParam(4,$email);
    $stmt->bindParam(5,$userid);
    $stmt->execute();  //execute the code
    $_SESSION["uname"]=$usnm;  //update session variable


// update the activity table to reflect updating details

    try {
        $act = "upd";
        $logtime = time();

        $sql = "INSERT INTO activity (userid, activity, date) VALUES (?, ?, ?)";  //prepare the sql to be sent
        $stmt = $conn->prepare($sql); //prepare to sql

        $stmt->bindParam(1, $userid);  //bind parameters for security
        $stmt->bindParam(2, $act);
        $stmt->bindParam(3, $logtime);

        $stmt->execute();  //run the query to insert
        header("refresh:5; url=prof.php");  //redirect with confirmation message
        echo "Details updated successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }




} catch(PDOException $e){   //catch error if one occurs
    header("refresh:5; url=prof.php");
    echo $e->getMessage();

}
?>
</body>
</html>