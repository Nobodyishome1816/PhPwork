<!DOCTYPE HTML>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <?php
    session_start();
    if(!$_SESSION["ssnlogin"]){
        header("refresh:5;url=login.html");
        echo"You are not currently logged in, redirecting to login page";
    }else {
        echo '<title> updater</title>';
    }
    ?>
</head>
<body>
<?php
echo '<h1>Welcome to the Updator!</h1>';

// Retrieve user information using PDO
$userId = $_SESSION['Userid'];
$stmt = $conn->prepare("SELECT * FROM mem WHERE id = ?");
$stmt->bindParam(1, $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user information using PDO
    $updatedUsername = $_POST['uname'];
    $updatedFirstName = $_POST['fname'];
    $updatedLastName = $_POST['sname'];
    $updatedEmail = $_POST['email'];

    $updateStmt = $conn->prepare("UPDATE mem SET uname = ?, Fname = ?, Sname = ?, Email = ? WHERE id = ?");
    $updateStmt->bindParam(1, $updatedUsername);
    $updateStmt->bindParam(2, $updatedFirstName);
    $updateStmt->bindParam(3, $updatedLastName);
    $updateStmt->bindParam(4, $updatedEmail);
    $updateStmt->bindParam(5, $userId);

    if ($updateStmt->execute()) {
        // Update successful
        header("Location: profile_updated.php");
        exit();
    } else {
        // Update failed
        echo "Error updating profile.";
    }
}
?>

<form method="POST" action="">
    <input type="text" name="uname" placeholder="Enter your new Username" value="<?php echo $user['uname'] ?>">
    <input type="text" name="Fname" placeholder="Enter your new First name" value="<?php echo $user['fname'] ?>">
    <input type="text" name="Sname" placeholder="Enter your new Surname" value="<?php echo $user['sname'] ?>">
    <input type="text" name="uname" placeholder="Enter your new email" value="<?php echo $user['email'] ?>">
    <input type="submit" value="Update">
</form>

</body>
</html>