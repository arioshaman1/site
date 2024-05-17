<?php
// Начинаем сессию
session_start();

// Проверяем, есть ли у пользователя активная сессия (в данном случае, проверяем наличие сохраненного адреса электронной почты в сессионных данных)
if (!isset($_SESSION["email"])) {
    // Если нет сессии, перенаправляем пользователя на страницу входа
    header("Location: login.php");
    exit(); // Прекращаем выполнение скрипта
}

// Если сессия найдена, получаем адрес электронной почты пользователя из сессии
$email = $_SESSION["email"];

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "autoservice";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем UserID из базы данных на основе адреса электронной почты
$sql_user_id = "SELECT UserID FROM Users WHERE Email = '$email'";
$result_user_id = $conn->query($sql_user_id);

// Проверяем, есть ли результат и извлекаем UserID
if ($result_user_id->num_rows > 0) {
    $row = $result_user_id->fetch_assoc();
    $user_id = $row["UserID"];

    // Если получен POST запрос для оформления заказа
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Получаем данные из формы
        $total_price = $_POST["total_price"];
        $car_id = "aosdkd"; // Постоянный CarID
        $order_date = date("Y-m-d H:i:s"); // Текущая дата и время
        $quantity = 1; // Всегда 1, так как это заказ

        // Генерируем уникальный OrderID
        $order_id = uniqid('orderID');

        // Подготовка и выполнение SQL-запроса для добавления заказа в таблицу Orders
        $sql_insert = "INSERT INTO Orders (OrderID, UserID, CarID, OrderDate, Quantity, TotalPrice) VALUES ('$order_id', '$user_id', '$car_id', '$order_date', $quantity, $total_price)";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Заказ успешно оформлен!";
        } else {
            echo "Ошибка: " . $sql_insert . "<br>" . $conn->error;
        }
    } else {
        echo "Ошибка: Не удалось получить данные для оформления заказа.";
    }
} else {
    echo "Не удалось найти UserID для данного пользователя.";
}

// Закрываем соединение с базой данных
$conn->close();
?>
    