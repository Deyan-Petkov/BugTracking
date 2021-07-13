<?php
require $_SERVER['DOCUMENT_ROOT'] . '/libs/db.php';
$id=$_GET['id'];

$sql = "UPDATE tickets SET resolved='1' WHERE id='$id'";
if($mysqli->query($sql)){
    echo "<script type='text/javascript'>window.location.href = '../see_tickets.php';</script>";
}