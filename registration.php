<?php
// Создайте переменную для сообщения от триггера
$triggerMessage = "";

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
        // Если запрос выполнен успешно, выводим сообщение
        $triggerMessage = "New record created successfully";
    } else {
        // Если есть ошибка, сохраняем ее в переменной
        $triggerMessage = $conn->error;
    }

    // Закрытие соединения
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" href="registration.css">
    <style>
        /* CSS для модального окна */
        .modal {
            display: <?php echo ($triggerMessage) ? 'block' : 'none'; ?>; /* Показываем модальное окно только при наличии сообщения */
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
        <p><?php echo $triggerMessage; ?></p>
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
    <form class="register-form" action="registration.php" method="post">
      <input type="text" name="firstName" placeholder="First Name" required/>
      <input type="text" name="lastName" placeholder="Last Name" required/>
      <input type="text" name="address" placeholder="Address" required/>
      <input type="tel" name="phone" placeholder="Phone Number" required/>
      <input type="text" name="email" placeholder="Email Address" required/>
      <input type="password" name="password" placeholder="Password" required/>
      <button type="submit" data-toggle="modal" data-target=".modal">Создать</button>
      <p class="message">Уже зарегестрированы? <a href="login.php">Login</a></p>
    </form>
  </div>
</div>

</body>
</html>
