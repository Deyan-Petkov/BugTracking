<?php
require $_SERVER['DOCUMENT_ROOT'] . '/libs/db.php';
$id=$_POST['id'];
$new_assigned=$_POST['newAssigned'];

$sql = "UPDATE tickets SET assigned_to='$new_assigned' WHERE id='$id'";
if($mysqli->query($sql)){
    echo "<script type='text/javascript'>window.location.href = '../see_tickets.php';</script>";
}