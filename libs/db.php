<?php
/* Database connection settings */
$host = '34.89.61.63';
$user = 'root';
$pass = 'TicketingSystem_UG13';
$db = 'ticketingSystem';


$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

mysqli_query(mysqli_connect($host, $user, $pass),"set names 'utf8'");
$conn= mysqli_connect($host, $user, $pass);


