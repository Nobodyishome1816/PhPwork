<?php
include 'db_connect.php';

session_start();

if(!$_SESSION["ssnlogin"]) {  //if no login has been completed
    session_destroy();
    header("refresh:5;url=login.html");  //redirects them to login
    echo "You are not currently logged in, redirecting to login page";
}

$list = $_POST["listname"]; // takes the name from the form
$userid = $_SESSION['Userid']; // takes the userid from the session
$time = time();

if ($_SERVER["REQUEST_METHOD"] == "POST");
    if (empty($list)) {
        header("refresh:5; url=prof.php");
        echo 'list is empty';
    }

try {
    $sql = "INSERT INTO List (userid, listname, date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    echo $userid;
    echo $list;
    echo $time;
    // binds the parameter for extra security into the column
    $stmt->bindParam(1, $userid);
    $stmt->bindParam(2, $list);
    $stmt->bindParam(3, $time);
    $stmt->execute();
    header("refresh:10; url=lists.php");

    echo "Successfully created a new list";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>