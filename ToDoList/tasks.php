<!DOCTYPE HTML>
<html>
<head>

    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div id="container">
    <div id="navbar">
        <img id="navbar_logo" src="Watkins_copy.png" alt="Watkin's ToDo List">
        <ul>
            <li><a href="prof.php">Profile</a></li>
        </ul>
    </div>
    <h1>Task List</h1>
    <form method="post" action="taskcreator.php" id="task_setting">
        <input type="text" name="listname" placeholder="Enter The Name of the List" required>
        <br>
        <input type="submit" value="create">
    </form>
    <?php
    session_start();

    if(!$_SESSION["ssnlogin"]) {  //if no login has been completed
        session_destroy();
        header("refresh:5;url=login.html");  //redirects them to login
        echo "You are not currently logged in, redirecting to login page";
    }

    $userid = $_SESSION["Userid"];
    try {
        $sql = "SELECT * FROM List WHERE Userid = ?";  //prepares sql to get details for logged in user

        $stmt = $conn->prepare($sql); //prepares the sql

        $stmt->bindParam(1,$userid);  //binds the parameters ready for execute

        $stmt->execute();  // runs the query

        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //gets the result
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</div>
</body>
</html>