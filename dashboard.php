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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="dashboard.css">
</head>

<?php
function generate_cart_id() {
    // Генерируем уникальный идентификатор на основе текущего времени и случайного числа
    $cart_id = uniqid('cart_');

    return $cart_id;
}
// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Генерируем уникальный CartID
    $cart_id = generate_cart_id();
    
    // Получаем ID автомобиля из формы
    $car_id = $_POST['car_id'];

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

    // Если подключение успешно, выполняем запрос на вставку данных в таблицу Cart
    $sql = "INSERT INTO Cart (CartID, user_email, car_id) VALUES ('$cart_id', '$email', '$car_id')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Закрываем соединение с базой данных
    $conn->close();
}
?>


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
                            Выйти
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
                <p class="text-white me-2">Добро пожаловать, <?php echo $username; ?></p>
                <!-- Вместо кнопок login и sign up должно быть имя пользователя -->
                <button type="button" class="btn btn-primary" onclick="window.location.href = 'user_session.php';">Личный кабинет</button>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form action="dashboard.php" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Введите запрос для поиска" name="search">
                    <button class="btn btn-outline-secondary" type="submit">Искать</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
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

// Инициализация переменной для хранения запроса поиска
$search_query = "";

// Проверяем, был ли отправлен запрос поиска
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    // Получаем значение из поля поиска
    $search_query = $_GET["search"];

    // SQL-запрос для поиска машин по модели или году выпуска
    $sql = "SELECT * FROM Cars WHERE Model LIKE '%$search_query%' OR Year LIKE '%$search_query%'";
} else {
    // Если запрос поиска не отправлен, просто выбираем все машины
    $sql = "SELECT * FROM Cars";
}

// Выполняем запрос к базе данных
$result = $conn->query($sql);

// Проверяем, есть ли результаты
if ($result->num_rows > 0) {
    // Выводим данные о машинах
    while ($row = $result->fetch_assoc()) {
        // Выводим карточку машины
        echo "<div class='col-md-4'>";
        echo "<div class='card h-100'>";
        echo "<img src='" . $row["Photo"] . "' class='card-img-top img-fluid' alt='" . $row["Model"] . "'>";
        echo "<div class='card-body text-center'>";
        echo "<h5 class='card-title'>" . $row["Model"] . "</h5>";
        echo "<p class='card-text'>Year: " . $row["Year"] . "</p>";
        echo "<p class='card-text'>Price: $" . $row["Price"] . "</p>";
        // Добавляем форму с кнопкой "Добавить в корзину"
        echo "<form action='cart.php' method='post'>";
        echo "<input type='hidden' name='car_id' value='" . $row["CarID"] . "'>"; // Передаем ID автомобиля
        echo "<button type='submit' name='add_to_cart' class='btn btn-primary'>Добавить в корзину</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    // Если результатов не найдено, выводим сообщение
    echo "<p>Ничего не найдено.</p>";
}

// Закрываем соединение с базой данных
$conn->close();
?>

    </div>
</div>

</body>
</html>


<footer class="bg-body-tertiary text-center text-lg-start">
  <!-- Контейнер сетки -->
  <div class="container p-4">
    <!--Ряд сетки-->
    <div class="row">
      <!--Колонка сетки-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">Свяжитесь с нами:  adaikin.andr321@gmail.com</h5>

        <p>
          Не стесняйтесь обращаться к нам с любыми вопросами или запросами по поводу продажи автомобилей. Наша команда всегда готова предоставить вам лучший сервис.
        </p>
      </div>
      <!--Колонка сетки-->

      <!--Колонка сетки-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">Подключитесь к нам: @arioshaman0</h5>

        <p>
          Следите за нами в социальных сетях, чтобы быть в курсе последних новостей, акций и специальных предложений по автомобилям. Присоединяйтесь к нашему сообществу автолюбителей!
        </p>
      </div>
      <!--Колонка сетки-->
    </div>
    <!--Ряд сетки-->
  </div>
  <!-- Контейнер сетки -->

  <!-- Авторские права -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2024 Все права защищены. | Автосалон "Автомобильный мир" | Дизайн сайта: Адайкин А.
  </div>
  <!-- Авторские права -->
</footer>
