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

// SQL-запрос для получения информации о пользователе из базы данных
$sql = "SELECT * FROM Users WHERE Email = '$email'";
$result = $conn->query($sql);

// Проверяем, есть ли результат
if ($result->num_rows > 0) {
    // Если есть хотя бы одна строка результатов, извлекаем информацию о пользователе
    $user_info = $result->fetch_assoc();
} else {
    // Если нет результатов, вы можете вывести сообщение об ошибке или выполнить другие действия
    $user_info = array(); // Пустой массив, чтобы избежать ошибок при обращении к данным
}

// SQL-запрос для извлечения отзывов пользователя
$sql_reviews = "SELECT * FROM Reviews WHERE UserID = '{$user_info['UserID']}'";
$result_reviews = $conn->query($sql_reviews);

// Закрываем соединение с базой данных
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Добавьте другие стили или скрипты, если необходимо -->
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
                <!-- Выводим имя пользователя вместо кнопок -->
                <p class="text-white me-2">Welcome, <?php echo $user_info['FirstName']; ?></p>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1><?php echo 'Клиент: ';echo $user_info['FirstName'], $user_info['LastName'];?></h1>
            <h2>Личный кабинет</h2>
            <p><strong>Email:</strong> <?php echo $user_info['Email']; ?></p>
            <p><strong>Телефон:</strong> <?php echo $user_info['Phone']; ?></p>
            <p><strong>Адрес:</strong> <?php echo $user_info['Address']; ?></p>
            <h3>Отзывы пользователя</h3>
            <ul>
                <?php
                // Проверяем, есть ли отзывы для данного пользователя
                if ($result_reviews->num_rows > 0) {
                    // Выводим отзывы
                    while ($row_review = $result_reviews->fetch_assoc()) {
                        echo "<li>" . $row_review['Comment'],
                        $row_review['ReviewDate'] . "</li>";
                    }
                } else {
                    // Если отзывов нет, выводим сообщение
                    echo "<li>Отзывы не найдены.</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>

