<?php
// Параметры подключения к базе данных
$hostname = "localhost";
$username = "root";
$password = "root";
$database_name = "autoservice";

// Подключение к базе данных
$connection = mysqli_connect($hostname, $username, $password, $database_name);

// Проверка соединения
if (!$connection) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Функция для очистки введенных данных от потенциально опасных символов
function clean_input($data) {
    global $connection;
    return mysqli_real_escape_string($connection, htmlspecialchars($data));
}

// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы и очищаем их
    $username = clean_input($_POST["username"]);
    $password = password_hash(clean_input($_POST["password"]), PASSWORD_DEFAULT);
    $email = clean_input($_POST["email"]);
    $full_name = clean_input($_POST["full_name"]);

    // Подготавливаем и выполняем SQL-запрос для добавления пользователя
    $query = "INSERT INTO users (username, password, email, full_name) VALUES ('$username', '$password', '$email', '$full_name')";

    if (mysqli_query($connection, $query)) {
        echo "Новый пользователь успешно добавлен";
    } else {
        echo "Ошибка добавления пользователя: " . mysqli_error($connection);
    }
}

// Закрытие соединения с базой данных
mysqli_close($connection);
?>
