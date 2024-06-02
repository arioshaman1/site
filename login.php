<?php
// Начинаем сессию
session_start();

// Создаем переменную $message для сообщения об ошибке
$message = "";

// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Подключаемся к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $database = "autoservice";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Получаем данные из формы
    $email = $_POST["email"];
    $password = $_POST["password"];

    // SQL-запрос для получения хэшированного пароля из базы данных
    $sql = "SELECT * FROM Users WHERE Email='$email'";
    $result = $conn->query($sql);
    $message = "Неверный пароль или Email, проверьте еще раз.";
    // Проверяем, найден ли пользователь
    if ($result->num_rows == 1) {
        // Получаем строку с данными пользователя
        $row = $result->fetch_assoc();
        // Сравниваем введенный пароль с паролем из базы данных
        if ($password === $row["Password"]) {
            // Пользователь найден, устанавливаем сессию для пользователя
            $_SESSION["email"] = $email;
            // Перенаправляем на защищенную страницу
            header("Location: dashboard.php");
            exit(); // Для прекращения выполнения скрипта после перенаправления
        } else {
            // Пользователь не найден или пароль не совпадает, сохраняем сообщение об ошибке
            $message = "Неверный пароль или Email, проверьте еще раз.";
        }
    } else {
        // Пользователь не найден или пароль не совпадает, сохраняем сообщение об ошибке
        $message = "Неверный пароль или Email, проверьте еще раз.";
    }

    // Закрываем соединение с базой данных
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <style>
        /* CSS для модального окна */
        .modal {
            display: <?php echo ($message) ? 'block' : 'none'; ?>; /* Показываем модальное окно только при наличии сообщения */
            position: fixed;
            z-index: 1000; /* Выше других элементов */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4); /* Прозрачный черный фон */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Располагаем по центру вертикально и горизонтально */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px; /* Максимальная ширина модального окна */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
    </style>
</head>

<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Предупреждение</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><?php echo $message; ?></p>
      </div>
    </div>
  </div>
</div>

<script>
    // JavaScript для закрытия модального окна при нажатии на крестик
    var closeButton = document.querySelector(".close");
    var modal = document.querySelector(".modal");

    closeButton.addEventListener("click", function() {
        modal.style.display = "none";
    });
</script>

<body>

<div class="login-page">
  <div class="form">
    <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <input type="email" name="email" placeholder="Email Address" required/>
      <input type="password" name="password" placeholder="Password" required/>
      <button type="submit">Отправить</button>
      <p class="message">Не зарегистрированы? <a href="registration.php">Регистрация</a></p>
    </form>
  </div>
</div>

</body>
</html>
