<?php
include 'db_connect.php';


 // put here for any additional time it may need to recognise there is a

try {
    session_start();

    $usnm = $_POST['uname']; // get username from login page

    $pswd = $_POST['password']; // gets password from login page

    // Prepare and execute the SQL statement using PDO
    $sql = "SELECT password FROM mem WHERE Username = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $usnm);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['ssnlogin'] = true;
        $_SESSION['uname'] = $usnm;
        $hashedpassword = $result["password"];
        if (password_verify($pswd, $hashedpassword)) {
            header("location: prof.php");
            exit();
        } else {
            session_destroy();
            echo "invalid password";
        }
        // tries the password and username against the database
    } else {
        // ends the session and doesn't allow them i
        header("refresh:5; url=login.html");
        echo 'user not found'; // if nothing is found then it tells the user
    }
} catch (PDOException $e) {
    header("refresh:5; url=login.html");
    echo $e->getMessage();
}


?>