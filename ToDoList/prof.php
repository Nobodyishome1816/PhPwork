<?php


session_start();  //starts a sessions which is needed to stay logged in
if(!$_SESSION["ssnlogin"]){  //if no login has been completed

    header("refresh:5;url=login.html");  //redirects them to login
    echo"You are not currently logged in, redirecting to login page";  //error message to reflect that
}else{
    echo "<!DOCTYPE html>  <!-- Declares doctype, important -->";

    echo "<html lang='en'>";
    echo "<head>";
    $usnm = $_SESSION['uname'];  //copies session name
    $userid = $_SESSION['Userid'];  //copies session userid
    echo "<title>". $usnm. "'s profile page</title>";  //echoes title to the page
}

echo "</head>";
echo "<body>";



echo "Welcome ".$usnm. " To your profile page";  //welcome comment to the page

echo "<br><br>";
echo "Here is your data";

echo "<br><br>";
echo "the items in the boxes can be editted, if you wish to change them then please at the new value then press the 'update' button";
echo "<br><br>";
echo "To change your password, please press the 'Password Change' button";
echo "<br><br>";

include "db_connect.php";  //connects to the database


$sql = "SELECT * FROM mem WHERE Userid = ?";  //prepares sql to get details for logged in user

$stmt = $conn->prepare($sql); //prepares the sql

$stmt->bindParam(1,$userid);  //binds the parameters ready for execute

$stmt->execute();  // runs the query

$result = $stmt->fetch(PDO::FETCH_ASSOC);  //gets the result

echo "<form method='post' action='updater.php'>";  //echos out start of the form

foreach($result as $key=>$value){  //runs loop to go through each of the returned items

    if($key=="Userid"){  // if its the userid data
        echo $key.": ". $value."<br>";  //echo out as text, not editable
    } elseif($key=="signup"){ //detects the sign up date
        echo $key.": ". $value."<br>";
    } elseif ($key!="Password"){  //if its the password data, don't output
        echo "<label for='".$key."'>".$key."</label>";  //produce label and form element using data in assoc array
        echo "<input type='text' name='".$key."' value='".$value."'><br>";
    }

}
echo "<input type='submit'' value='Update'>";  //outputs button to allow update to be called
echo "<br><br>";
echo "</form>";
echo "<form method='post' action='pswdchange.php'>";
echo "<input type='submit' value='Password change'>";
echo '<br><br>';

$sql = "SELECT date FROM activity WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $userid);
$stmt->execute();
$date = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Last login: ".$date['date']."<br>";
$readableDate = date("Y-m-d H:i:s", $date['date']);
echo "Last login: ".$readableDate."<br>";

$sql = "SELECT activity FROM activity WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $userid);
$stmt->execute();
$act = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Last activity: ".$act['activity']."<br><br>";

$sql = "SELECT activity, COUNT(*) AS count FROM activity WHERE userid = ? GROUP BY activity";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $userid);
$stmt->execute();
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($activities as $activity) {
    echo "Activity: " . $activity['activity'] . " - Count: " . $activity['count'] . "<br>";
}
echo '<br>';
echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th>Activity | </th>';
echo '<th>Count</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($activities as $activity) {
    echo "<tr>";
    echo "<td>" . $activity['activity'] . "</td>";
    echo "<td>" . $activity['count'] . "</td>";
    echo "</tr>";
}
echo '</tbody>';
echo '</table>';
//foreach($act as $key=>$value){
//    echo $key.": ".$value."<br>";
//}

echo "</body>";
echo"</html>";

?>