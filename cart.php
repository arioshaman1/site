<?php
// Начинаем сессию
session_start();

// Проверяем, есть ли у пользователя активная сессия (в данном случае, проверяем наличие сохраненного адреса электронной почты в сессионных данных)
if (!isset($_SESSION["email"])) {
    // Если нет сессии, перенаправляем пользователя на страницу входа
    header("Location: fake_cart.php");
    exit(); // Прекращаем выполнение скрипта
}

// Если сессия найдена, получаем адрес электронной почты пользователя из сессии
$email = $_SESSION["email"];

// Здесь вы можете выполнить дополнительные действия, специфичные для защищенной страницы

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

// Если получен POST запрос из формы добавления в корзину
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, получен ли ID машины
    if (isset($_POST["car_id"])) {
        $car_id = $_POST["car_id"];
        // Подготовка и выполнение SQL-запроса для добавления товара в корзину пользователя
        if (!empty($car_id)) {
            $sql_insert = "INSERT INTO Cart (user_email, car_id) VALUES ('$email', '$car_id')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "Товар успешно добавлен в корзину!";
            } else {
                echo "Ошибка: " . $sql_insert . "<br>" . $conn->error;
            }
        } else {
            echo "ID машины пусто!";
        }
    } else {
        echo "ID машины не получено!";
    }
}

// SQL-запрос для получения содержимого корзины пользователя
$sql_cart = "SELECT Cars.Model, Cars.Year, Cars.Price, Cars.Photo FROM Cart INNER JOIN Cars ON Cart.car_id = Cars.ID WHERE Cart.user_email = '$email'";
$result_cart = $conn->query($sql_cart);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <a href="#" class="nav-link text-white">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#speedometer2"></use></svg>
                            Dashboard
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
                <!-- Выводим имя пользователя вместо кнопок -->
                <p class="text-white me-2">Добро пожаловать, <?php echo $email; ?></p>
                <!-- Вместо кнопок login и sign up должно быть имя пользователя -->
                <button type="button" class="btn btn-primary" onclick="window.location.href = 'user_session.php';">Личный кабинет</button>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <h2>Корзина</h2>
        <?php
        // Выводим содержимое корзины пользователя
        if ($result_cart->num_rows > 0) {
            while ($row = $result_cart->fetch_assoc()) {
                echo "<div class='col-md-4'>";
                echo "<div class='card h-100'>";
                echo "<img src='" . $row["Photo"] . "' class='card-img-top' alt='Car Photo'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row["Model"] . "</h5>";
                echo "<p class='card-text'>Год: " . $row["Year"] . "</p>";
                echo "<p class='card-text'>Цена: $" . $row["Price"] . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>Корзина пуста</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
