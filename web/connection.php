<?php
$user = 'root';
$password = 'root';
$db = 'ObjectLocationTracking';
$host = 'localhost';
$port = 3306;

$link = mysqli_init();
$success = mysqli_real_connect(
   $link, 
   $host, 
   $user, 
   $password, 
   $db,
   $port
);
if (!success) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}