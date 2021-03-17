<?php

session_start();
/*
resources:
- css file
- images
*/
include 'storage.php';
include 'libs/db.php';

echo '<link rel="stylesheet" href="assets/css/deyan.css">';

$storage = new storage();

// $ticketID = $_POST['ticketID'];
$ticketID = 1; //temporary id. The real one will be from the $_POST request sent when user chose a ticket to see

if ($_SESSION['logged_in'] != 1 && $_SESSION['priviledge'] != '3') {

    echo "<script type='text/javascript'>window.location.href = '../user_login.php';</script>";
} else {
    $user_id = $_SESSION['user_id'];
    $session = $_SESSION['logged_in'];
    // echo $session . " SESSION STATUS";
}



//Fetch the staff member and the client names associated with this ticket  
$result = $mysqli->query("select staff.name as staffName, users.name as userName, users.id as id, title from tickets inner join users on users.id = tickets.submitted_by inner join staff on staff.id = tickets.assigned_to where tickets.id = '$ticketID'");

if ($result->num_rows == 0) { // User doesn't exist
    echo "Nothing fetched from the DB";
    return;
} else {
    $ticket = $result->fetch_assoc();

    $staffName = $ticket['staffName'];
    $clientName = $ticket['userName'];
    $clientID = $ticket['id']; //resolves what type of user is sending the message
    $title = $ticket['title'];
    if ($clientID == $user_id) {
        $role = 'client';
    } else {
        $role = 'staff';
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['submit'])) {
            //get the chat
            $chat = $storage->getChat($ticketID);
            //get the new message
            $description = $_POST['description'];
            //add new message to the existing chat
            $chat[] = array(
                $role => $description,
                "date" => date("Y-m-d h:i a")

            ); //save the updated chat
            $storage->saveChat($chat, $ticketID);
        }
    }
}

include 'include/header.php';

?>

<!DOCTYPE HTML>

<!--

	Industrious by TEMPLATED

	templated.co @templatedco

	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)

-->

<html>

<head>

    <title>Ticketing</title>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <meta name="description" content="" />

    <meta name="keywords" content="" />

    <link rel="stylesheet" href="/assets/css/main.css" />

    <link rel="stylesheet" href="/assets/css/bootstrap.css" />

    <link rel="stylesheet" href="/assets/css/luka.css" />

</head>

<!-- <body class="is-preload"> -->

<!-- Banner -->

<section id="banner">

    <div class="inner">

        <h1>Ticketing</h1>

        <p>Best ticketing solution for all kinds of businesses.</p>

    </div>

    <video autoplay loop muted playsinline src="/images/banner.mp4"></video>

</section>


<?php


//show all files in the ticket folder
$ticketFolder = $storage->listFolder($ticketID);
// [0] => 1/
//     [1] => 1/apple.png
//     [2] => 1/pinguin.jpg
//     [3] => 1/smallpdf.pdf
//     [4] => 1/textFile.txt
//     [5] => 1/earth.gif


foreach ($ticketFolder as $file) {
    global $fileNames;
    //split the folder and file name
    $fileNameAndFolderName =  (explode("/", $file));
    $fileName = end($fileNameAndFolderName);

    //shwo only files (skip the folder name)
    if (strlen($fileName) > 0) {
        //get all names
        $fileNames[] = $fileName;
        // [0] => apple.png
        // [1] => pinguin.jpg
        // [2] => smallpdf.pdf
        // [3] => textFile.txt
    }
}


echo '<div id="listContent">
        <ul>';
foreach ($fileNames as $fileName) {
    //list the available files
    echo '<li><a href="?' . $fileName . '">' . $fileName . '</a></li>';
}
echo "</ul></div>";


//These chars are converted to _ from PHP so we need to replace them when check the $_GET
$convertedValues = array(" ", ".", "[");
$cleanArray = str_replace($convertedValues, "_", $fileNames);

//check which file was chosen by user and show it
for ($i = 0; $i < count($cleanArray); $i++) {
    if (isset($_GET[$cleanArray[$i]])) {
        // $_SESSION['fileToShow'] = $ticketID."/".$fileName;
        global $fileNames;
        showFile($ticketID . "/" . $fileNames[$i]);
    }
}


/**
 * This method resolves the file extension (from the parameter) 
 * and shows the file according to its type
 * @param $object the full Cloud Storage path to the file 
 *        (e.g. folder and file name - 1/earth.gif)
 */
function showFile($object)
{
    global $storage;
    //check the type of file
    $fileExt = explode('.', $object); //split the file name on the . in the file name - e.g. the file extension

    $fileActualExt = strtolower(end($fileExt)); //take the part after the . 
    $file = $storage->getURL($object);

    //if image type file
    echo "<div id=userSelection>";
    if ($fileActualExt == "jpg" || $fileActualExt == "jpeg" || $fileActualExt == "png" || $fileActualExt == "gif") {
        echo '<img src="' . $file . '" alt="picture">';
    } else if ($fileActualExt == "mp4") {
        ?>
        <button onclick="play()" type="button" class="button primary small" style="background-color: green;">Play</button>
        <button onclick="pause()" type="button" class="button primary small">Pause</button>
        <button onclick="forward()" type="button" class="button  small" style="background-color:yellow;">>></button>
        <button onclick="backward()" type="button" class="button  small" style="background-color:yellow;"><<</button>
        <button onclick="replay()" type="button" class="button small" >Replay</button>
        <br> 

        <video id="video" width="640" height="360" >
        <source src="<?php echo $file; ?>" type="video/mp4">
        Your browser does not support the video tag.
        </video> 
        
 

        <script>
        var video = document.getElementById("video");
        function play() {
            video.play();
        }

        function pause() {
        video.pause();
        }

        function replay(){
            video.currentTime = 0;
        }

        function forward(){
            video.currentTime += 5;
        }
        function backward(){
            video.currentTime -= 5;
        }

        </script>
        <?php
    } else if ($fileActualExt == "pdf") {
        echo '<iframe src="' . $file . '" style="width:600px; height:500px;" frameborder="0"></iframe>"';
    } else if ($fileActualExt == "txt") {
        echo '<iframe src="' . $file . '" frameborder="0" height="200"
      width="95%"></iframe>';
    }
    echo "</div>";
}


?>



<!-- Highlights -->

<section class="wrapper">

    <div class="inner">

        <header class="special">

            <h2><?php echo $title ?></h2>


        </header>

        <div class="">
            <form action="#" method="post" autocomplete="off" enctype="multipart/form-data">

                <div class="row gtr-uniform">

                    <div class="col-12 col-12-xsmall">

                        <form action="#" method="post" autocomplete="off" enctype="multipart/form-data">
                            <textarea type="description" name="description" id="description" placeholder="Message"></textarea>
                            <br>
                            <button type="submit" value="Submit" class="primary" name="submit">Submit</button></li>
                            <br><br>
                        </form>
                    </div>




                    <?php
                    //get the chat related to this ticket
                    $chat = $storage->getChat($ticketID);

                    //TODO  to show last message on top(not the first)
                    foreach ($chat as $message) {
                        //if $message contains client message show it as appropriate 
                        if (array_key_exists("client", (array)$message)) {

                            echo
                            '<div class="message">
                                <img src="images/client.png" alt="client_icon">
                                <p>' . $message->client . '</p>
                                <span class="clientName">' . $clientName . '</span>
                                <span class="time_right"><br><br>' . $message->date . '</span>

                            </div>';
                            //if $message contains staff member message show it as appropriate 
                        } else if (array_key_exists("staff", (array)$message)) {

                            echo
                            '<div class="message responce">
                                <img src="images/support.png" alt="support_icon" class="right">
                                <p>' . $message->staff . '<br></br>' . $staffName . '</br></p>
                                <span class="time_left">' . $message->date . '</span>
                            </div>';
                        }
                    }

                    ?>


                </div>
            </form>

        </div>

</section>







<?php include 'include/footer.php'; ?>



<!-- Scripts -->

<script src="/assets/js/jquery.min.js"></script>

<script src="/assets/js/browser.min.js"></script>

<script src="/assets/js/breakpoints.min.js"></script>

<script src="/assets/js/util.js"></script>

<script src="/assets/js/main.js"></script>



</body>

</html>