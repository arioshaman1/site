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

// Предположим, что у нас есть адрес электронной почты пользователя, хранимый в переменной $email
$email = $_SESSION["email"]; // Предполагается, что вы уже получили адрес электронной почты из сессии

// SQL-запрос для получения имени пользователя из базы данных
$sql = "SELECT FirstName FROM Users WHERE Email = '$email'";
$result = $conn->query($sql);

// Проверяем, есть ли результат
if ($result->num_rows > 0) {
    // Если есть хотя бы одна строка результатов, извлекаем имя пользователя
    $row = $result->fetch_assoc();
    $username = $row["FirstName"]; // Получаем имя пользователя из результата запроса
} else {
    // Если нет результатов, устанавливаем имя пользователя по умолчанию или выводим сообщение об ошибке
    $username = "Unknown"; // Установка имени по умолчанию
}

// Закрываем соединение с базой данных
$conn->close();


?>

<header>
    <div class="px-3 py-2 bg-dark text-white">
        <div class="container">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                </a>

                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    <li>
                        <a href="main.html" class="nav-link text-secondary">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#home"></use></svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#speedometer2"></use></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#table"></use></svg>
                            Orders
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#people-circle"></use></svg>
                            Customers
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form>

            <div class="text-end">
                <!-- Выводим имя пользователя вместо кнопок -->
                <p class="text-white me-2">Welcome, <?php echo $username; ?></p>
                <!-- Вместо кнопок login и sign up должно быть имя пользователя -->
                <button type="button" class="btn btn-primary" onclick="window.location.href = 'cart.php';"><?php echo $username; ?></button>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <link rel="stylesheet" type="text/css" href="index.css">

        <?php
        // Подключение к базе данных
        $servername = "localhost";
        $username = "root";
        $password = "mysql";
        $dbname = "autoservice";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверка подключения
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL-запрос для извлечения данных о машинах
        $sql = "SELECT * FROM Cars";
        $result = $conn->query($sql);

        // Проверка наличия результатов
        if ($result->num_rows > 0) {
            // Вывод данных о машинах
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4'>";
                echo "<div class='card h-100'>";
                echo "<img src='" . $row["Photo"] . "' class='card-img-top img-fluid' alt='" . $row["Model"] . "'>";
                echo "<div class='card-body text-center'>";
                echo "<h5 class='card-title'>" . $row["Model"] . "</h5>";
                echo "<p class='card-text'>Year: " . $row["Year"] . "</p>";
                echo "<p class='card-text'>Price: $" . $row["Price"] . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

            }
        } else {
            echo "0 results";
        }
        $conn->close();

        ?>
