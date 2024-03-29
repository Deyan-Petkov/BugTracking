<?php
require 'libs/db.php';

/* User login process, checks if user exists and password is correct */

// Escape email to protect against SQL injections
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

if ( $result->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist!";
    echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
}
else { // User exists
    $user = $result->fetch_assoc();

    if ( password_verify($_POST['password'], $user['password']) ) {

        $_SESSION['email'] = $user['email'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['name'];
        $_SESSION['role'] = 'client';


        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;
        $_SESSION['privilege']='3';

        echo "<script type='text/javascript'>window.location.href = 'user';</script>";
    }
    else {
        $_SESSION['message'] = "You have entered wrong password, try again!";
        echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
    }
}

