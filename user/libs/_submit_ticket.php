<?php

use Google\Cloud\Core\Upload\StreamableUploader;

require $_SERVER['DOCUMENT_ROOT'] . '/libs/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/storage.php';

//get variables
$title = $_POST['title'];
$user_id = $_SESSION['user_id'];
$description = $_POST['description'];



//check file extensions
$total = count($_FILES['files']['name']);
for ($i = 0; $i < $total; $i++) {

    $target_file = basename($_FILES["files"]["name"][$i]);
    $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $uploadOk = 1;
    // Allow certain file formats
    if (
        $FileType != "jpg" && $FileType != "png" && $FileType != "jpeg"
        && $FileType != "gif" && $FileType != "pdf" && $FileType != "mp4"  && $FileType != "txt" 

    ) {
        $uploadOk = 0;
        $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG, GIF, PDF, MP4 & TXT files are allowed.";
        echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
        break;
    }
}


if ($uploadOk == 1) {

    //find if there is staff member without assigned tickets yet
    $result = $mysqli->query(" select id from staff where id not in (SELECT assigned_to from 
(select assigned_to, count(assigned_to) as perStaff from tickets group by assigned_to order by perStaff asc) as y) limit 1;");
    if ($result->num_rows > 0) {
        $id =  $result->fetch_assoc();
        $staffWithLessTickets = $id['id'];

        $sql = "INSERT INTO tickets (title, description, date, submitted_by, assigned_to) "
            . "VALUES ('$title','$description',now(),'$user_id','$staffWithLessTickets');";
    } else {

        //Find the staff member with least tickets assigned and assign the new ticket to him/her
        $result = $mysqli->query("SELECT assigned_to from (select assigned_to, count(assigned_to)
     as perStaff from tickets group by assigned_to order by perStaff asc limit 1) as y
");

        if ($result->num_rows > 0) {
            $id = $result->fetch_assoc();
            $staffWithLessTickets = $id['assigned_to'];

            $sql = "INSERT INTO tickets (title, description, date, submitted_by, assigned_to) "
                . "VALUES ('$title','$description',now(),'$user_id','$staffWithLessTickets');";
        }
    }
}



// create ticket
if ($mysqli->query($sql) && $uploadOk == 1) {
    //add to the chat
    $message[] = array(
        "client" => $description,
        "date" => date("Y-m-d h:i a")
    );

    $ticket_id = mysqli_insert_id($mysqli);
    $storage = new storage();
    $storage->saveChat($message, $ticket_id);


    //make the ticket directory
    $storage->createFolder($ticket_id); //google storage

    //loop through each file for upload
    for ($i = 0; $i < $total; $i++) {
        //store to cloud
        $storage->uploadObject($_FILES["files"]["name"][$i], $_FILES["files"]["tmp_name"][$i], $ticket_id . "/");
    }

    $_SESSION['message'] = "The ticket has been submitted.<br>";
    echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
    
} else {

    $_SESSION['message'] = 'Submisson failed!';
    echo "<div class='error-mess'>" . $_SESSION['message'] . "</div>";
}
