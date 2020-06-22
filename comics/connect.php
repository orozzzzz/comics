<?
$host = 'localhost'; // адрес сервера 
$database = 'comics'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль

$link = mysqli_connect($host, $user, $password, $database) 
    or mysqli_error($link);
?>