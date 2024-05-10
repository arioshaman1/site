<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$database = "autoservice";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['car_name']) && isset($_POST['user_id']) && isset($_POST['rating']) && isset($_POST['comment'])) {
        // Получаем данные из формы
        $car_name = $_POST['car_name'];
        $user_id = $_POST['user_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        // Подготавливаем SQL запрос для поиска ID машины по её названию
        $car_sql = "SELECT CarID FROM Cars WHERE Model = '$car_name'";
        $car_result = $conn->query($car_sql);

        if ($car_result->num_rows > 0) {
            // Найдена машина с введённым названием
            $car_row = $car_result->fetch_assoc();
            $car_id = $car_row['CarID'];
            $review_date = date('Y-m-d H:i:s');

            // Подготавливаем SQL запрос для вставки отзыва
            $sql = "INSERT INTO Reviews (CarID, UserID, Rating, Comment, ReviewDate) VALUES ('$car_id', '$user_id', '$rating', '$comment', '$review_date')";

            // Выполняем SQL запрос
            if ($conn->query($sql) === TRUE) {
                // Перенаправляем пользователя обратно на страницу с отзывами
                header("Location: reviews.php");
                exit(); // Обязательно завершаем выполнение скрипта после перенаправления
            } else {
                echo "Error adding review: " . $conn->error;
            }
        } else {
            echo "Car not found.";
        }
    } else {
        echo "Form fields are not set.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h2 {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .car-info {
            display: flex;
            align-items: center;
        }
        .car-info img {
            width: 100px;
            margin-right: 10px;
        }
        .review-form {
            margin-top: 30px;
        }
        .review-form label {
            display: block;
            margin-bottom: 5px;
        }
        .review-form input[type="text"],
        .review-form input[type="number"],
        .review-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        .review-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        .review-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Отзывы о машинах</h1>
    <table>
        <tr>
            <th>Car</th>
            <th>User</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>ReviewDate</th>
        </tr>
        <?php
        // Fetch reviews data from the database
        $sql = "SELECT Reviews.CarID, Reviews.UserID, Reviews.Rating, Reviews.Comment, Reviews.ReviewDate, Cars.Model, Users.FirstName, Users.LastName, Cars.Photo
                FROM Reviews
                JOIN Cars ON Reviews.CarID = Cars.CarID
                JOIN Users ON Reviews.UserID = Users.UserID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>
                            <div class='car-info'>
                                <img src='".$row["Photo"]."' alt='".$row["Model"]."'>
                                <div>".$row["Model"]."</div>
                            </div>
                        </td>
                        <td>".$row["FirstName"]." ".$row["LastName"]."</td>
                        <td>".$row["Rating"]."</td>
                        <td>".$row["Comment"]."</td>
                        <td>".$row["ReviewDate"]."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>0 results</td></tr>";
        }
        ?>
    </table>
    <h2>Добавить отзыв</h2>
    <form class="review-form" action="reviews.php" method="post">
        <label for="car_name">Название машины:</label>
        <input type="text" id="car_name" name="car_name">
        <label for="user_id">ID Пользователя:</label>
        <input type="text" id="user_id" name="user_id">
        <label for="rating">Оценка:</label>
        <input type="number" id="rating" name="rating" min="1" max="5">
        <label for="comment">Отзыв</label>
        <textarea id="comment" name="comment"></textarea>
        <input type="submit" value="Отправить отзыв ">
    </form>
</div>
</body>
</html>
