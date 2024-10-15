<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="styles.css">

    <?php

    session_start();  //starts a sessions which is needed to stay logged in
    if(!$_SESSION["ssnlogin"]){  //if no login has been completed

        header("refresh:5;url=login.html");  //redirects them to login
        echo"You are not currently logged in, redirecting to login page";  //error message to reflect that
    }
    ?>
    <title>Password Changer</title>
</head>
<body>
<div id="container">
    <h1>Welcome to the Password Changer pleb</h1>
    <h2> Use this to change your password correctly or get logged out</h2>
    <form method="post" action="pswdchangeval.php">
        <input type="text" name="Curntpswd" placeholder="Enter Current Password" required>
        <br>
        <input type="text" name="Newpswd1" placeholder="Enter New Password" required>
        <br>
        <input type="text" name="Newpswd2" placeholder="Re-enter New Password" required>
        <br><br>
        <input type="submit" value="login">
    </form>
</div>
</body>
</html>