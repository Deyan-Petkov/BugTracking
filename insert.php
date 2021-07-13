<?php
/* Database connection settings */
$host = 'localhost';
$user = 'hidrogra_luka';
$pass = 'Luka032Aleksa011';
$db = 'hidrogra_db';


$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

mysqli_query(mysqli_connect($host, $user, $pass),"set names 'utf8'");
$conn= mysqli_connect($host, $user, $pass);


$staff_id = $_POST['staff_id'];
$priority = $_POST['priority'];


$sql = $mysqli->query("SELECT * FROM staff WHERE id='$staff_id' ");
if ($sql->num_rows > 0) {

    if ($mysqli->query("UPDATE tickets SET assigned_to='$staff_id', priority= '$priority' WHERE id='$staff_id' "))  {
        echo json_encode(array('status' => true, 'Message' => 'Success!'));
    } else {
        echo json_encode(array('status' => false, 'Message' => 'Failed!'));
    }
} else {
    echo json_encode(array('status' => false, 'Message' => 'Staff Member not available'));
}
