<!DOCTYPE HTML>
<html lang = "en">
<head>
    <title>Profile page</title>
<?php
    session_start();
    if(!$_SESSION["ssnlogin"]){

    header("refresh:5;url=login.html");
    echo"You are not currently logged in, redirecting to login page";
}else{
    $usnm = $_SESSION['uname'];
    echo "<title>". $usnm. "'s profile page</title>";
}
?>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php

echo "Welcome " . $usnm . " To your profile page";

?>
<br><br>
Here is your data
<?php
include "db_connect.php";

    $sql = "SELECT * FROM mem WHERE Username = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1,$usnm);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
echo "<form method='post' action='updater.php'>";

foreach($result as $key=>$value){ // loops depending on the value in the table

    if($key=="Userid"){
        echo $key.": ". $value."<br>";
    } elseif ($key!="Password"){
        echo "<label for='".$key."'>".$key."</label>";
        echo "<input type='text' name='".$key."' value='".$value."'><br>";

    }

}
echo "<input type='submit'' value='Update'";
?>
 <br><br>
<?php
//if ($result) {
//    echo "<h2>" . "$usnm" . "'s Profile</h2>";
//    echo "<p> Username: " . $usnm . "</p>";
//    echo "<p>First Nmae: " . $result['Fname'] . "</p>";
//    echo "<p>Last Name: " . $result['Sname'] . "</p>";
//    echo "<p>Email: " . $result['Email'] . "</p>";
//
//    echo 'would you like to update anything ?';
//    echo "<input type='submit'' value='Update'";
//} else {
//    echo 'you have been lost to the pits of mystery';
//}
//?>
</body>
</html>