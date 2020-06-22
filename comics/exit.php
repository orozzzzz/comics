<?php
session_start();
include("connect.php");
$client_ip = $_SERVER['REMOTE_ADDR'];
@mysqli_query($link, "DELETE FROM cart WHERE client = '$client_ip'");
session_destroy();
header('Location: http://comics/?page=main');
