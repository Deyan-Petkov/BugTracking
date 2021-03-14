<?php
require $_SERVER['DOCUMENT_ROOT'] . '/libs/db.php';

//get variables
$title = $_POST['title'];
$user_id=$_SESSION['user_id'];
$description = $_POST['description'];

$sql = "INSERT INTO tickets (title, description, date, submitted_by) "
    . "VALUES ('$title','$description',now(),'$user_id')";

// insert into table
if ( $mysqli->query($sql) ){

    $result = $mysqli->query("SELECT LAST_INSERT_ID()");
    $id = $result->fetch_assoc();
    $ticket_id = ;
echo $ticket_id;
    //make the ticket directory
    $target_dir = $_SERVER['DOCUMENT_ROOT'] .'/tickets/' . $ticket_id. '/';
    if (!is_dir($ticket_id))
    {
        mkdir($ticket_id, 0755, true);
    }
    //loop through each file for upload
    $total = count($_FILES['files']['name']);
    for ($i = 0; $i < $total; $i++) {
        $target_file = $target_dir . basename($_FILES["files"]["name"][$i]);
        $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $newfilename = $i . '.' . $FileType;
        $newtarget_file = $target_dir . $newfilename;

        $uploadOk1 = 1;
        // Allow certain file formats
        if ($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg"
            && $FileType != "gif" && $FileType != "pdf") {
            echo "Sorry, only JPG, JPEG, PNG, GIF & PDF files are allowed.";
            $uploadOk1 = 0;
        }
        //heck if $uploadOk is set to 0 by an error
        if ($uploadOk1 == 0) {
            $_SESSION['message'] = 'Sorry, your file was not uploaded!';
            echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
        //if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $newtarget_file)) {
                $_SESSION['message'] = "The file " . $newfilename . " has been uploaded.<br>";
                echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
            } else {
                $_SESSION['message'] = "Sorry, there was an error uploading your file. Error: " . $_FILES["files"]["error"][$i] . "<br>";
                echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
            }
        }
    }

}
else {
    $_SESSION['message'] = 'Submisson failed!';
    echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
}
