<?php
// Начинаем сессию
session_start();

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
            // Пользователь не найден или пароль не совпадает, выводим сообщение об ошибке
            echo "Invalid email or password. Passwords do not match.";
        }
    } else {
        // Пользователь не найден или пароль не совпадает, выводим сообщение об ошибке
        echo "Invalid email or password. User not found.";
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
</head>
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
