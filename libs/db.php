<?php
/* Database connection settings */
$host = 'localhost';
$user = 'hidrogra_luka';
$pass = 'Luka032Aleksa011';
$db = 'hidrogra_db';


$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

mysqli_query(mysqli_connect($host, $user, $pass),"set names 'utf8'");
$conn= mysqli_connect($host, $user, $pass, $db);


