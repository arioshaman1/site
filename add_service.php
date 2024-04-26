<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "autoservice";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение данных из формы
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];

// Подготовка SQL-запроса
$sql = "INSERT INTO services (name, description, price) VALUES ('$name', '$description', '$price')";

if ($conn->query($sql) === TRUE) {
    echo "Новая услуга успешно добавлена";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

// Закрытие соединения
$conn->close();
?>
