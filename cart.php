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

    // Если получен POST запрос из формы добавления в корзину
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["car_id"])) {
        $car_id = $_POST["car_id"];
        // Подготовка и выполнение SQL-запроса для добавления товара в корзину пользователя
        if (!empty($car_id)) {
            // Генерируем уникальный CartID
            $cart_id = uniqid('cartID');
            $sql_insert = "INSERT INTO Cart (CartID, UserID, CarID) VALUES ('$cart_id', '$user_id', '$car_id')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "Товар успешно добавлен в корзину!";
            } else {
                echo "Ошибка: " . $sql_insert . "<br>" . $conn->error;
            }
        } else {
            echo "ID машины пусто!";
        }
    }

    // Если получен POST запрос из формы удаления из корзины
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_car_id"])) {
        $remove_car_id = $_POST["remove_car_id"];
        // Подготовка и выполнение SQL-запроса для удаления товара из корзины пользователя
        if (!empty($remove_car_id)) {
            $sql_delete = "DELETE FROM Cart WHERE UserID = '$user_id' AND CarID = '$remove_car_id'";
            if ($conn->query($sql_delete) === TRUE) {
                echo "Товар успешно удален из корзины!";
            } else {
                echo "Ошибка: " . $sql_delete . "<br>" . $conn->error;
            }
        } else {
            echo "ID машины пусто!";
        }
    }

    // SQL-запрос для получения содержимого корзины пользователя
    $sql_cart = "SELECT CarID FROM Cart WHERE UserID = '$user_id'";
    $result_cart = $conn->query($sql_cart);

    // Вызов функции CalculateTotalPrice
    $total_price = CalculateTotalPrice($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart_modal.css">
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
                <p class="text-white me-2">Добро пожаловать, <?php echo $user_id; ?></p>
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
                // Запрос к таблице Cars для получения информации о машинах в корзине
                $car_id = $row["CarID"];
                $sql_car = "SELECT Model, Year, Price, Photo FROM Cars WHERE CarID = '$car_id'";
                $result_car = $conn->query($sql_car);
                if ($result_car->num_rows > 0) {
                    $car = $result_car->fetch_assoc();
                    echo "<div class='col-md-4'>";
                    echo "<div class='card h-100'>";
                    echo "<img src='" . $car["Photo"] . "' class='card-img-top' alt='Car Photo'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $car["Model"] . "</h5>";
                    echo "<p class='card-text'>Год: " . $car["Year"] . "</p>";
                    echo "<p class='card-text'>Цена: $" . $car["Price"] . "</p>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='remove_car_id' value='" . $car_id . "'>";
                    echo "<button type='submit' class='btn btn-danger'>Удалить из корзины</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        } else {
            echo "<p>Корзина пуста</p>";
        }
        ?>
    </div>
</div>
</body>

<?php
} else {
    echo "Не удалось найти UserID для данного пользователя.";
}
// Закрываем соединение с базой данных
$conn->close();

// Определение функции CalculateTotalPrice
function CalculateTotalPrice($user_id) {
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

    // Выполнение функции SQL для вычисления общей стоимости покупок пользователя
    $sql = "SELECT CalculateTotalPrice($user_id) AS total_price";
    $result = $conn->query($sql);

    // Проверяем, есть ли результат и извлекаем значение
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_price = $row["total_price"];
    } else {
        $total_price = 0;
    }

    // Закрываем соединение с базой данных
    $conn->close();

    // Возвращаем значение общей стоимости
    return $total_price;
}
?>
<body>

<button class="btn btn-primary" id="openModalBtn">Оформить заказ</button>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="totalPriceContent">Общая стоимость всех товаров в корзине :$ <span id="totalPrice"></span></h2>
        <h5>Продолжить оформление?</h5>
        <form id="orderForm" method="post" action="orders.php">
        <button class="btn btn-primary" id="checkoutBtn">Оформить заказ</button>
        <input type="hidden" id="totalPriceInput" name="total_price">
        </form>
    </div>
</div>

<div id="overlay"></div>
<script src="cart_modal.js"></script>

</body>
</html>

<footer class="bg-body-tertiary text-center text-lg-start">
  <!-- Контейнер сетки -->
  <div class="container p-4">
    <!--Ряд сетки-->
    <div class="row">
      <!--Колонка сетки-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">Свяжитесь с нами</h5>

        <p>
          Не стесняйтесь обращаться к нам с любыми вопросами или запросами по поводу продажи автомобилей. Наша команда всегда готова предоставить вам лучший сервис.
        </p>
      </div>
      <!--Колонка сетки-->

      <!--Колонка сетки-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">Подключитесь к нам</h5>

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
