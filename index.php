
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
              <a href="index.php" class="nav-link text-secondary">
                <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#home"></use></svg>
                Домой
              </a>
            </li>
            <li>

            </li>
  
            <li>
              <a href="reviews.php" class="nav-link text-white">
                <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>
                Отзывы
              </a>
            </li>
            <li>
              <a href="fake_cart.php" class="nav-link text-white">
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
        <button type="button" class="btn btn-light text-dark me-2" onclick="window.location.href='login.php'">Войти</button>
          <button type="button" class="btn btn-primary" onclick="window.location.href = 'registration.php';">Регистрация</button>

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
        
        // Добавляем кнопку "Добавить в корзину"
        echo "<form action='cart.php' method='post'>";
        echo "<input type='hidden' name='car_id' value='" . $row["ID"] . "'>"; // Передаем ID автомобиля
        echo "<button type='submit' class='btn btn-primary'>Добавить в корзину</button>";
        echo "</form>";
        
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>



<footer class="bg-body-tertiary text-center text-lg-start">
  <!-- Контейнер сетки -->
  <div class="container p-4">
    <!--Ряд сетки-->
    <div class="row">
      <!--Колонка сетки-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">Свяжитесь с нами adaikin.andr@321gmail.com</h5>

        <p>
          Не стесняйтесь обращаться к нам с любыми вопросами или запросами по поводу продажи автомобилей. Наша команда всегда готова предоставить вам лучший сервис.
        </p>
      </div>
      <!--Колонка сетки-->

      <!--Колонка сетки-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">Подключитесь к нам @arioshaman0</h5>

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





