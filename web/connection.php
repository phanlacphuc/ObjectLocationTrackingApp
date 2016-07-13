<?php
$url=parse_url(getenv("DATABASE_URL"));
$host = $url["host"];
$user = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

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