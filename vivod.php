<?php
$hostname = "localhost";
$username = "root";
$password = "root";
$database_name = "autoservice";

// Подключение к базе данных
$connection = new mysqli($hostname, $username, $password, $database_name);

// Проверка соединения
if ($connection->connect_error) {
    die("Ошибка подключения:sdsd " . mysqli_connect_error());
}
$query = "SELECT * FROM users1";
$result = $connection->query($query);
if (!$result) {
    die("Error seledsdsdct");
}
echo '<pre>';
print_r($result);
echo '</pre>';