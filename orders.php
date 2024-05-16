<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];

$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "autoservice";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_user_id = "SELECT UserID FROM Users WHERE Email = '$email'";
$result_user_id = $conn->query($sql_user_id);

if ($result_user_id->num_rows > 0) {
    $row = $result_user_id->fetch_assoc();
    $user_id = $row["UserID"];

    $sql_orders = "SELECT * FROM Orders WHERE UserID = '$user_id'";
    $result_orders = $conn->query($sql_orders);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                            Dashboard
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
                <p class="text-white me-2">Добро пожаловать, <?php echo $email; ?></p>
                <button type="button" class="btn btn-primary" onclick="window.location.href = 'user_session.php';">Личный кабинет</button>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <h2>Ваши заказы</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Car ID</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_orders->num_rows > 0) {
                    while ($row = $result_orders->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["OrderID"] . "</td>";
                        echo "<td>" . $row["CarID"] . "</td>";
                        echo "<td>" . $row["OrderDate"] . "</td>";
                        echo "<td>" . $row["Quantity"] . "</td>";
                        echo "<td>" . $row["TotalPrice"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>У вас пока нет заказов.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php
} else {
    echo "Не удалось найти UserID для данного пользователя.";
}

$conn->close();
?>
