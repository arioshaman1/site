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
    }

    // SQL-запрос для получения заказов пользователя
    $sql_orders = "SELECT OrderID, OrderDate, TotalPrice FROM Orders WHERE UserID = '$user_id'";
    $result_orders = $conn->query($sql_orders);

    // Проверяем, есть ли заказы у пользователя
    if ($result_orders->num_rows > 0) {
        $orders = [];
        while ($row = $result_orders->fetch_assoc()) {
            $orders[] = $row;
        }
    } else {
        $orders = [];
    }
} else {
    echo "Не удалось найти UserID для данного пользователя.";
}

// Закрываем соединение с базой данных
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header>
    <div class="px-3 py-2 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                </a>

                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    <li>
                        <a href="index.php" class="nav-link text-secondary">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#home"></use></svg>
                            Домой
                        </a>
                    </li>
                    <li>
                        <a href="dashboard.php" class="nav-link text-white">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#speedometer2"></use></svg>
                            Каталог
                        </a>
                    </li>
                    <li>
                        <a href="orders.php" class="nav-link text-white">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#table"></use></svg>
                            Заказы
                        </a>
                    </li>
                    <li>
                        <a href="reviews.php" class="nav-link text-white">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>
                            Отзывы
                        </a>
                    </li>
                    <li>
                        <a href="cart.php" class="nav-link text-white">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#people-circle"></use></svg>
                            Корзина
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <div class="text-end">
                <p class="text-white me-2">Добро пожаловать, <?php echo htmlspecialchars($email); ?></p>
                <button type="button" class="btn btn-primary" onclick="window.location.href = 'user_session.php';">Личный кабинет</button>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <h2>Ваши заказы</h2>
        <?php
        if (!empty($orders)) {
            foreach ($orders as $order) {
                echo "<div class='col-md-4'>";
                echo "<div class='card h-100'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>ID заказа: " . htmlspecialchars($order["OrderID"]) . "</h5>";
                echo "<p class='card-text'>Дата заказа: " . htmlspecialchars($order["OrderDate"]) . "</p>";
                echo "<p class='card-text'>Стоимость: $" . htmlspecialchars($order["TotalPrice"]) . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>У вас нет заказов.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
