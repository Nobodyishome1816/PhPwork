<?php

session_start();  //starts a sessions which is needed to stay logged in
if(!$_SESSION["ssnlogin"]){  //if no login has been completed

    header("refresh:5;url=login.html");  //redirects them to login
    echo"You are not currently logged in, redirecting to login page";  //error message to reflect that
}else{
    include "db_connect.php";  //connects to the database
    echo "<!DOCTYPE html>"; // declares the DOCTYPE

    echo "<html lang='en'>";
    echo "<head>";
    echo "<title> Password Updater </title>";  //echoes title to the page
    $usnm = $_SESSION['uname'];  //copies session name
    $userid = $_SESSION['Userid'];  //copies session userid
    $Curntpswd = $_POST['Curntpswd'];
    echo $Curntpswd;
    echo 'Falafel';
    $Newpswd1 = $_POST['Newpswd1'];
    echo $Newpswd1;
    echo 'Falafel';
    $Newpswd2 = $_POST['Newpswd2'];
    echo $Newpswd2;

}


echo "</head>";
echo "<body>";

$sql = "SELECT * FROM mem WHERE Userid = ?";  //prepares sql to get details for logged in user

$stmt = $conn->prepare($sql); //prepares the sql

$stmt->bindParam(1,$userid);  //binds the parameters ready for execute

$stmt->execute();  // runs the query

$result = $stmt->fetch(PDO::FETCH_ASSOC);  //gets the result

if(!password_verify($Curntpswd, $result['Password'])){

    $act = "apc";
    $logtime = time();

    $sql = "INSERT INTO activity (userid, activity, date) VALUES (?, ?, ?)";  //prepare the sql to be sent
    $stmt = $conn->prepare($sql); //prepare to sql

    $stmt->bindParam(1, $userid);  //bind parameters for security
    $stmt->bindParam(2, $act);
    $stmt->bindParam(3, $logtime);

    $stmt->execute();  //run the query to insert
    session_destroy(); //kill session as dont know password
    header("refresh:5;url=login.html");
    echo "Incorrect current password given!";

} elseif($Newpswd1 != $Newpswd2){
    $act = "apc";
    $logtime = time();

    $sql = "INSERT INTO activity (userid, activity, date) VALUES (?, ?, ?)";  //prepare the sql to be sent
    $stmt = $conn->prepare($sql); //prepare to sql

    $stmt->bindParam(1, $userid);  //bind parameters for security
    $stmt->bindParam(2, $act);
    $stmt->bindParam(3, $logtime);

    $stmt->execute();  //run the query to insert
    header("refresh:5;url=pwchange.php");
    echo "New passwords do not match!";
}else{
    $hpswd = password_hash($Newpswd1, PASSWORD_DEFAULT);  //has the password
    $sql = "UPDATE mem SET Password=? WHERE Userid = ?";  //sets up the statement
    $stmt = $conn->prepare($sql);  //prepares the sql statement
    $stmt->bindParam(1,$hpswd);  //binding all the parameters
    $stmt->bindParam(2,$userid);
    $stmt->execute();  //execute the code

    $act = "spc";
    $logtime = time();

    $sql = "INSERT INTO activity (userid, activity, date) VALUES (?, ?, ?)";  //prepare the sql to be sent
    $stmt = $conn->prepare($sql); //prepare to sql

    $stmt->bindParam(1, $userid);  //bind parameters for security
    $stmt->bindParam(2, $act);
    $stmt->bindParam(3, $logtime);

    $stmt->execute();  //run the query to insert
    session_destroy();
    header("refresh:5; url=login.html");  //redirect with confirmation message
    echo "Password updated successfully, login again!";

}


echo "</body>";
echo"</html>";

?>