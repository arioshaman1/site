<?php
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

// Получаем UserID из сессии
session_start();
if (!isset($_SESSION["email"])) {
    die("No active session");
}
$email = $_SESSION["email"];
$sql_user_id = "SELECT UserID FROM Users WHERE Email = '$email'";
$result_user_id = $conn->query($sql_user_id);
if ($result_user_id->num_rows > 0) {
    $row = $result_user_id->fetch_assoc();
    $user_id = $row["UserID"];

    // Вызываем функцию CalculateTotalPrice
    $total_price = CalculateTotalPrice1($conn, $user_id);

    // Возвращаем общую стоимость в формате JSON
    echo json_encode(array("total_price" => $total_price));
} else {
    die("Failed to retrieve UserID");
}

// Закрываем соединение с базой данных
$conn->close();

// Определение функции CalculateTotalPrice
function CalculateTotalPrice1($conn, $user_id) {
    // Выполнение функции SQL для вычисления общей стоимости покупок пользователя
    $sql = "SELECT CalculateTotalPrice1('$user_id') AS total_price";
    $result = $conn->query($sql);

    // Проверяем, есть ли результат и извлекаем значение
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_price = $row["total_price"];
    } else {
        $total_price = 0;
    }

    // Возвращаем значение общей стоимости
    return $total_price;
}
?>
