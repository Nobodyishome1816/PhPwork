<!DOCTYPE HTML>
<html>
<head>
    <title>List creation</title>
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
    <h1>create a list for tasks</h1>
    <form method="post" action="listcreator.php" id="task_setting">
        <input type="text" name="listname" placeholder="Enter The Name of the List" required>
        <br>
        <input type="submit" value="create">
    </form>

    <?php

    include 'db_connect.php';

    session_start();

    if(!$_SESSION["ssnlogin"]) {  //if no login has been completed
        session_destroy();
        header("refresh:5;url=login.html");  //redirects them to login
        echo "You are not currently logged in, redirecting to login page";
    }

    try {
    $userid = $_SESSION["Userid"];

    $sql = "SELECT listname FROM List WHERE userid = ?";

    $stmt = $conn->prepare($sql);

    // Validate and sanitize user input if necessary
    $stmt->bindParam(1, $userid, PDO::PARAM_INT); // Assuming userid is an integer

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        echo "<h2><u>Current Lists</u></h2>";
        echo "<ul>";
        foreach ($result as $row) {
            echo "<li>" . $row['listname'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No lists found for user ID: " . $userid;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

    <form method="post" action="taskcreator.php" id="task_setting">
        <select name="list_id">
            <option value="">Select a list</option>
            <?php
            // Fetch list names from the database and populate the dropdown
            $list_sql = "SELECT listname FROM List WHERE userid = ?";
            $list_stmt = $conn->prepare($list_sql);
            $list_stmt->bindParam(1, $userid);
            $list_stmt->execute();
            $list_results = $list_stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($list_results as $list) {
                echo "<option value='" . $list['list_id'] . "'>" . $list['listname'] . "</option>";
            }
            ?>
        </select>
        <br>
        <input type="text" name="task_name" placeholder="Enter the task name" required>
        <br>
        <input type="submit" value="Create Task">
    </form>
</div>
</body>
</html>