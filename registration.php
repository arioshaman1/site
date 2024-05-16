<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" href="registration.css">
</head>
<body>

<div class="login-page">
  <div class="form">
    <form class="register-form" action="registration.php" method="post">
      <input type="text" name="firstName" placeholder="First Name" required/>
      <input type="text" name="lastName" placeholder="Last Name" required/>
      <input type="text" name="address" placeholder="Address" required/>
      <input type="tel" name="phone" placeholder="Phone Number" required/>
      <input type="email" name="email" placeholder="Email Address" required/>
      <input type="password" name="password" placeholder="Password" required/>
      <button type="submit">Создать</button>
      <p class="message">Уже зарегестрированы? <a href="login.php">Login</a></p>
    </form>
  </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Получение данных из формы
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Генерация UserID (можно использовать, например, функцию uniqid())
    $userId = uniqid();

    // Генерация хэша для пароля
    // Ограничение количества цифр в номере телефона
    $phoneLimited = substr($phone, 0, 20);

    // SQL-запрос для добавления пользователя в базу данных
    $sql = "INSERT INTO Users (UserID, FirstName, LastName, Email, Password, Address, Phone)
            VALUES ('$userId', '$firstName', '$lastName', '$email', '$password', '$address', '$phoneLimited')";

    // Выполнение запроса
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Ошибка: " . $conn->error;
    }

    // Закрытие соединения
    $conn->close();
}
?>

</body>
</html>
