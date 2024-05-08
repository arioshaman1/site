<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .content {
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 30px;
        }

        .buttons {
            display: flex;
            justify-content: center;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content">
        <h1>Ваша Корзина</h1>
        <p>Вы не вошли в систему. Пожалуйста, зарегестрируйтесь или войдите.</p>
        <div class="buttons">
            <a href="login.php" class="btn">Log In</a>
            <a href="registration.php" class="btn">Register</a>
        </div>
    </div>
</div>

</body>
</html>
