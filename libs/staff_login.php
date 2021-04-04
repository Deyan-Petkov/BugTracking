<?php
require 'libs/db.php';

/* User login process, checks if staff exists and password is correct */

// Escape email to protect against SQL injections
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM staff WHERE email='$email'");

if ( $result->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist!";
    echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
}
else { // User exists
    $staff = $result->fetch_assoc();

    if ( password_verify($_POST['password'], $staff['password']) ) {

        $_SESSION['email'] = $staff['email'];
        $_SESSION['staff_id'] = $staff['id'];
        $_SESSION['first_name'] = $staff['first_name'];
        $_SESSION['last_name'] = $staff['last_name'];
        $_SESSION['privilege'] = $staff['level'];

        // This is how we'll know the staff is logged in
        $_SESSION['logged_in'] = true;

        echo "<script type='text/javascript'>window.location.href = 'staff';</script>";
    }
    else {
        $_SESSION['message'] = "You have entered wrong password, try again!";
        echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
    }
}

