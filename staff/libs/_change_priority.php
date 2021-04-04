<?php
require $_SERVER['DOCUMENT_ROOT'] . '/libs/db.php';
$id=$_POST['id'];
$new_priority=$_POST['newPriority'];

$sql = "UPDATE tickets SET priority='$new_priority' WHERE id='$id'";
if($mysqli->query($sql)){
    echo "<script type='text/javascript'>window.location.href = '../see_tickets.php';</script>";
}