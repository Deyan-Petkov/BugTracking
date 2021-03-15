<?php
require $_SERVER['DOCUMENT_ROOT'] . '/libs/db.php';
session_start();
//get variables
$title = $_POST['title'];
$user_id=$_SESSION['id'];
$description = $_POST['description'];

$sql = "INSERT INTO tickets (title, description, date, submitted_by) "
    . "VALUES ('$title','$description',now(),'$user_id')";

//check file extensions
$total = count($_FILES['files']['name']);
for ($i = 0; $i < $total; $i++) {

    $target_file =basename($_FILES["files"]["name"][$i]);
    $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $uploadOk1 = 1;
    // Allow certain file formats
    if ($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg"
        && $FileType != "gif" && $FileType != "pdf") {
        $uploadOk1 = 0;
        $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG, GIF & PDF files are allowed.";
        echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
        break;
    }
}

// create ticket
if ( $mysqli->query($sql) && $uploadOk1==1){

    $ticket_id = mysqli_insert_id($mysqli);
    //make the ticket directory
    $target_dir = $_SERVER['DOCUMENT_ROOT'] .'/tickets/' . $ticket_id. '/';
    if (!is_dir($ticket_id))
    {
        mkdir($target_dir, 0755, true);
    }
    //loop through each file for upload
    for ($i = 0; $i < $total; $i++) {
        $target_file = $target_dir . basename($_FILES["files"]["name"][$i]);
        $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $newfilename = $i . '.' . $FileType;
        $newtarget_file = $target_dir . $newfilename;

        $uploadOk = 1;
        // Allow certain file formats
        if ($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg"
            && $FileType != "gif" && $FileType != "pdf"
            && $FileType != "doc"&& $FileType != "docs"&& $FileType != "pages") {
            echo "Sorry, only JPG, JPEG, PNG, GIF & PDF files are allowed.";
            $uploadOk = 0;
        }
        //heck if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['message'] = 'Sorry, your file was not uploaded!';
            echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
        //if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $newtarget_file)) {
                /*$_SESSION['message'] = "The file " . $newfilename . " has been uploaded.<br>";
                echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";*/
            } else {
                $_SESSION['message'] = "Sorry, there was an error uploading your file. Error: " . $_FILES["files"]["error"][$i] . "<br>";
                echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
            }
        }
    }
    if($uploadOk==1){
        $_SESSION['message'] = "The ticket has been submitted.<br>";
        echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
    }

}
else {
    $_SESSION['message'] = 'Submisson failed!';
    echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
}
